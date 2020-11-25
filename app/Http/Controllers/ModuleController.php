<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaModulo;
use App\Models\Modulo;
use App\Models\Usuario;
use App\Models\UsuarioAsignatura;
use App\Models\UsuarioModulo;
use Illuminate\Support\Facades\Redirect;

class ModuleController extends Controller
{


    public function modules() {
        $module = new Modulo;
        $usermodule = new UsuarioModulo;
        $user = new Usuario;

        $usuario = $user->getUserByEmail($_SESSION["email"]);
        
        $title = "Módulos";
        $modules = $module->getModules();
        foreach($modules as $m) {
            $m->NumeroUsuarios = $usermodule->getAmountOfUsersPerModule($m->Id);
            $m->UserBelongsToModule = $usermodule->userBelongsToModule($usuario->Id, $m->Id);
        }
        return view('modules', compact('title', 'modules'));
    }


    public function userModules($email) {
        $module = new Modulo;
        $user = new Usuario;
        $title = "Mis módulos";
        $usuario = $user->getUserByEmail($email);
        $modules = $module->getModulesByUser($usuario->Id);

        return view('usermodules', compact('title', 'usuario', 'modules'));  
    }

    public function moduleslist() {
        $module = new Modulo;
        $subject = new Asignatura;
        $subjectmodule = new AsignaturaModulo;
        $title = "Módulos";

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if(!$data) {
            $modules = $module->getModules();
            foreach($modules as $m) {
                $m->subjects = $subject->getSubjectsPerModule($m->Id);
                $m->subjectsSelect = $subject->getAllSubjectsNotInModule($m->Id);
            }
            return view('moduleslist', compact('title', 'modules'));

        } else {

            if ($data[0] == "nothing") {
                return;
            } 
            
            $id_subject = $data[0];
            $id_module = $data[1];

            $subjectmodule->addSubjectModule($id_subject, $id_module);
            return json_encode($subject->getSubjectById($id_subject));
        }
    }

    public function moduleForm() {
        $title = "Nuevo módulo";
        $nombreModulo = $moduleError = "";
        return view('moduleform', compact('title', 'nombreModulo', 'moduleError'));
    }


    public function addModule() {
        $title = "Nuevo Módulo";
        $moduleError = "";
        $problems = false;
        $nombreModulo = $_POST["nombreModulo"] ?? "";
        $module = new Modulo;

        //Comprobaciones

        if ($nombreModulo != "") {
            if ($module->moduleExists(strtoupper($nombreModulo))) {
                $problems = true;
                $moduleError = "* El módulo que ha introducido ya existe";
            }
        } else {
            $problems = true;
            $moduleError = "* El nombre del módulo no puede estar vacio";
        }

        if ($problems) {
            return view('moduleform', compact('title', 'moduleError', 'nombreModulo'));
        } else {
            $module->addModule(strtoupper($nombreModulo));
            return Redirect::to(config('app.url').config('app.name')."/moduleslist");
        }
    }

    public function moduleDetails($id_module) {
        //Instancio los ORM que voy a necesitar
        $module = new Modulo;
        $subject = new Asignatura;
        $user = new Usuario;
        $usermodule = new UsuarioModulo;
        $usersubject = new UsuarioAsignatura;

        //Obtengo de la BD los datos que voy a necesitar en la vista
        $modulo = $module->getModuleById($id_module);
        $subjects = $subject->getSubjectsPerModule($id_module);
        $professors = $user->getProfessorsPerModule($id_module);
        $students = $user->getStudentsPerModule($id_module);

        //Obtengo de la BD todas las asignaturas que imparte un profesor
        foreach($professors as $professor) {
            $professor->subjects = $subject->getSubjectsPerUserAndPerModule($professor->Id, $id_module);
            $professor->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($professor->FechaPrimerAcceso));
            $professor->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($professor->FechaUltimoAcceso));
        }

        //Obtengo de la BD todas las asignaturas que cursa un alumno
        foreach($students as $student) {
            $student->subjects = $subject->getSubjectsPerUserAndPerModule($student->Id, $id_module);
            $student->FechaPrimerAcceso = date('d-m-Y H:i:s', strtotime($student->FechaPrimerAcceso));
            $student->FechaUltimoAcceso = date('d-m-Y H:i:s', strtotime($student->FechaUltimoAcceso));
        }

      /*
        Estabezco el título de la ventana, compruebo si el usuario está vinculado al módulo o no y 
        renderizo la vista envíandole las
        variables que necesito en la misma
      */
        $title = $modulo->NombreModulo;
        $currentUser = $user->getUserByEmail($_SESSION['email']);
        $currentUser->userBelongsToModule = $usermodule->userBelongsToModule($currentUser->Id, $id_module);
        return view('moduledetails', compact('title', 'modulo', 'subjects', 'professors', 'students', 'currentUser', 'usersubject'));
    }

}
