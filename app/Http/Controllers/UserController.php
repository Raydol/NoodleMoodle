<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Rol;
use Illuminate\Http\Request;
use App\Models\Usuario;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    /**
     * Función de registro. Se encarga de mostrar la vista de registro y crear las variables que necesito para el modelo de la BD 
     * para facilitarme luego la recarga del formulario si lo he de mostrar otra vez porque
     * algún dato introducido no ha sido validado
     */
    public function register()
    {
        //Maybe TO-DO: Estaría bien que el select de ciudades y comunidades autónomas se rellenera usando una API
        $title = "Registro";
        $nombre = $apellidos = $email = $telefono = $ciudad = $comunidad_autonoma = $rol_name = $password = $repassword = 
        $errorPassword = $errorTelefono = $errorEmail = "";

        return view('register', compact(
            'title', 
            'nombre', 
            'apellidos', 
            'email', 
            'telefono', 
            'ciudad', 
            'comunidad_autonoma', 
            'rol_name', 
            'password', 
            'repassword',
            'errorPassword',
            'errorTelefono',
            'errorEmail'
        ));
    }

    public function processRegistration()
    {
        $user = new Usuario;
        $rol = new Rol;
        $title = "Registro";
            $nombre = $_POST["nombre"] ?? "";
            $apellidos = $_POST["apellidos"] ?? "";
            $email = $_POST["email"] ?? "";
            $telefono = $_POST["telefono"] ?? "";
            $ciudad = $_POST["ciudad"] ?? "";
            $comunidad_autonoma = $_POST["comunidad_autonoma"] ?? "";
            $rol_name = $_POST["rol_name"];
            $password =  $_POST["password"] ?? "";
            $repassword =  $_POST["repassword"] ?? "";
            $errorPassword = "";
            $errorTelefono = "";
            $errorEmail = "";

            $problems = false;

            /** COMPROBACIONES DEL FORMULARIO DE REGISTRO **/

            //Comprobar que las contraseñas coinciden
            if ($password !== $repassword) {
                $errorPassword = "*Las contraseñas no coinciden";
                $problems = true;
            }

            //Comprobar que el teléfono móvil introducido es válido
            if (!preg_match('/(\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}$/', $telefono)) {
                $errorTelefono = "*El número de teléfono móvil no es válido";
                $problems = true;
            }

            //Comprobar que el usuario introducido no está registrado
            var_dump($user->userExists($email));
            if ($user->userExists($email)) {
                $errorEmail = "*El usuario introducido ya existe";
                $problems = true;
            }

            //Comprobar los inputs para evitar inyecciones de código



            //Si no pasa alguna comprobación recarga el formulario.
            //Si las pasa añade un registro con el nuevo usuario a la base de datos.
            if($problems) {
                
                return view('register', compact(
                    'title', 
                    'nombre', 
                    'apellidos', 
                    'email', 
                    'telefono', 
                    'ciudad', 
                    'comunidad_autonoma', 
                    'rol_name', 
                    'password', 
                    'repassword',
                    'errorPassword',
                    'errorTelefono',
                    'errorEmail'
                ));

            } else {
                $usuario = new Usuario;
                $usuario->Nombre = $nombre;
                $usuario->Apellidos = $apellidos;
                $usuario->Email = $email;
                $usuario->Telefono = $telefono;
                $usuario->Ciudad = $ciudad;
                $usuario->ComunidadAutonoma = $comunidad_autonoma;
                $usuario->IdRol = $rol->getIdByRol($rol_name);
                $usuario->FechaPrimerAcceso = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                $usuario->FechaUltimoAcceso = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                $usuario->Password = password_hash($password, PASSWORD_DEFAULT);
                $user->addUser($usuario);
                $_SESSION["email"] = $usuario->Email;
                return Redirect::to(config('app.url').config('app.name'));
            }   
    }

    public function login() {
        $title = "Logueo";
        $email = $errorLogueo = "";
        return view('login', compact('title', 'email', 'errorLogueo'));
    }

    public function processLogin() {
        $user = new Usuario;
        $title = "Logueo";
        $errorLogueo = "";
        $email = $_POST["email"];
        $password = $_POST["password"];
        $db_password = "";

        $problems = false;

        /** Comprobaciones para validar los datos introducidos **/

        if ($user->userExists($email)) {
            $db_password = $user->getPasswordByEmail($email);
            if(password_verify($password, $db_password)) {
                $_SESSION["email"] = $email;
                $user->updateUserLastAccessDate($email);
                return Redirect::to(config('app.url').config('app.name'));
            } else {
                $problems = true;
            }
        } else {
            $problems = true;
        }

        if($problems) {
            $errorLogueo = "El email o la contraseña que ha introducido no son correctos";
            return view('login', compact('title', 'errorLogueo', 'email'));
        }
    }

    public function logout() {
        session_destroy();
        return Redirect::to(config('app.url').config('app.name'));
    }



    /**
     * Función que recupera los datos de un usuario en concreto y renderiza una vista de perfil con ellos
     */
    public function profile($email) {
        $user = new Usuario;
        $rol = new Rol;
        $modulo = new Modulo;
        $usuario = $user->getUserByEmail($email);
        $usuario->Rol = ucwords($rol->getRolById($usuario->IdRol));
        $usuario->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($usuario->FechaPrimerAcceso));
        $usuario->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($usuario->FechaUltimoAcceso));
        $usuario->Modulos = $modulo->getModulesByUser($usuario->Id);
        return view('userprofile', compact('usuario'));
    }

    public function users() {

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $rol_filter = $data;

        $title = "Usuarios";
        $user = new Usuario;
        $rol = new Rol;

        if($rol_filter == "") {
            $users = $user->getUsers();
            foreach($users as $u) {
                $u->RolName = ucwords($rol->getRolById($u->IdRol));
                $u->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($u->FechaPrimerAcceso));
                $u->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($u->FechaUltimoAcceso));
            }
            return view('userslist', compact('title', 'users'));
        } else {
            if ($rol_filter === 'alumno') {
                $users = $user->getAllStudents();
                foreach($users as $u) {
                    $u->RolName = ucwords($rol->getRolById($u->IdRol));
                    $u->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($u->FechaPrimerAcceso));
                    $u->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($u->FechaUltimoAcceso));
                }
                return json_encode($users);
            } elseif ($rol_filter === 'profesor') {
                $users = $user->getAllProfessors();
                foreach($users as $u) {
                    $u->RolName = ucwords($rol->getRolById($u->IdRol));
                    $u->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($u->FechaPrimerAcceso));
                    $u->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($u->FechaUltimoAcceso));
                }
                return json_encode($users);
            } elseif ($rol_filter === 'all') {
                $users = $user->getUsers();
                foreach($users as $u) {
                    $u->RolName = ucwords($rol->getRolById($u->IdRol));
                    $u->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($u->FechaPrimerAcceso));
                    $u->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($u->FechaUltimoAcceso));
                }
                return json_encode($users);
            } else
                throw new Exception("El filtro introducido no es válido");
            }
        }
        
    public function deleteUser() {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        
        $user = new Usuario;

        try {
            $user->deleteUser($data[0]);
            if ($data[1] == "alumno") {
                $users = $user->getAllStudents();
            } else if ($data[1] == "profesor") {
                $users = $user->getAllProfessors();
            } else {
                $users = $user->getUsers();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return json_encode($users);
    }
    
    
}
