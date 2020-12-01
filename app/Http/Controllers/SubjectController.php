<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaModulo;
use App\Models\Aviso;
use App\Models\Modulo;
use App\Models\Usuario;
use App\Models\UsuarioAsignatura;
use Exception;
use Illuminate\Support\Facades\Redirect;

class SubjectController extends Controller
{
    
    public function subjectslist() {
        $title = "Asignaturas";
        $subject = new Asignatura;
        $user = new Usuario;
        $subjectmodule = new AsignaturaModulo;

            $subjects = $subject->getSubjects();

            foreach($subjects as $sub) {
                $sub->AmountOfModules = $subjectmodule->getAmountOfModulesPerSubject($sub->Id);
                $sub->AmountOfStudents = $user->getAmountOfStudentsPerSubject($sub->Id);
            }

            return view('subjectslist', compact('title', 'subjects'));

    }

    public function subjectForm() {
        $title = "Nueva asignatura";
        $nombreAsignatura = $codeError = $subjectError = "";
        return view('subjectform', compact('title', 'nombreAsignatura', 'codeError', 'subjectError'));
    }

    public function addSubject() {
        $title = "Nueva asignatura";
        $codeError = "";
        $subjectError = "";
        $problems = false;
        $nombreAsignatura = $_POST["nombreAsignatura"] ?? "";
        $codigoActivacion = $_POST["codigoActivacion"] ?? "";
        $subject = new Asignatura;

        //Comprobaciones

        if ($codigoActivacion == "") {
            $codeError = "*Debe introducir un código de activación de asignatura";
            $problems = true;
        }

        if ($nombreAsignatura != "") {
            if ($subject->subjectExists(strtoupper($nombreAsignatura))) {
                $subjectError = "*La asignatura que ha introducido ya existe";
                $problems = true;
            }
        } else {
            $subjectError = "*El nombre de la asignatura no puede estar vacío";
            $problems = true;
        }
        

        if ($problems) {
            return view('subjectform', compact('title', 'nombreAsignatura', 'codeError', 'subjectError'));
        } else {
            $subject->addSubject(strtoupper($nombreAsignatura), $codigoActivacion);
            return Redirect::to(config('app.url').config('app.name')."/subjectslist");
        }
        
    }


    public function generateCode() {
        $rn = "";
        
        for($i = 0; $i < 5; $i++) {
            $rn .= mt_rand(0,9);
        }

        return $rn;
    }

    public function validateSubject() {
        /*
          Obtenemos tanto el id del módulo como el id de la asignatura
          a la cual se quiere unir el usuario
        */
        $id_module = $_POST["id_module"] ?? "";
        $id_subject = $_POST["id_subject"] ?? "";

        //Instanciamos los modelos que vamos a necesitar
        $usersubject = new UsuarioAsignatura;
        $user = new Usuario;
        $subject = new Asignatura;
        $module = new Modulo;

        /*
          Si el usuario de la sesión es un profesor le metemos directamente en la asignatura
          y pasa a ser el profesor que la imparte.

          Si no es un profesor. Comprobamos que la asignatura a la que el alumno quiere entrar
          tiene o no profesor. 
          
          Si lo tiene, le enviamos al formulario de la asignatura para que
          introduzca el código de activación y, si este es correcto, que el profesor valide su entrada
          a la asignatura. 
          
          Si no lo tiene, enviamos de vuelta al alumno a la vista
          en detalle del módulo.
        */
        if ($user->isProfessor($user->getUserByEmail($_SESSION["email"])->Id)) {
            $usersubject->addUserToSubjectOnModule(
                $user->getUserByEmail($_SESSION["email"])->Id, 
                $id_subject, 
                $id_module
            );
            return Redirect::to(config('app.url').config('app.name')."/module/$id_module");
        } else {
            if ($usersubject->subjectHasProfessor($id_subject, $id_module)) {
                $title = "Validar incorporación";
                $codeError = "";
                $asignatura = $subject->getSubjectById($id_subject);
                $modulo = $module->getModuleById($id_module);
                return view('joinsubjectform', compact('title', 'asignatura', 'modulo', 'codeError'));
            } else {
                //Introducir mensaje de que esa asignatura aun no tiene profesor
                return Redirect::to(config('app.url').config('app.name')."/module/$id_module");
            }
        }   
    }

    public function processActivationCode() {
        $title = "Validar incorporación";
        $codeError = "";
        $problems = false;
        $activationCode = $_POST["activationCode"] ?? "";
        $id_subject = $_POST["idSubject"] ?? "";
        $id_module = $_POST["idModule"] ?? "";

        $subject = new Asignatura;
        $advice = new Aviso;
        $user = new Usuario;
        $usersubject = new UsuarioAsignatura;
        $module = new Modulo;

        $asignatura = $subject->getSubjectById($id_subject);
        $modulo = $module->getModuleById($id_module);

        if ($activationCode != "") {
            if ($asignatura->CodigoActivacion === $activationCode) {
                //Se introduce una fila a la tabla avisos
                $advice->addAdvice($user->getUserByEmail(
                    $_SESSION["email"])->Id, 
                    $id_subject, 
                    $id_module,
                    $usersubject->getSubjectProfessorFromModule($id_subject, $id_module)->Id);
            } else {
                $problems = true;
                $codeError = "*El código introducido no es correcto";
            }
        } else {
            $problems = true;
            $codeError = "*El código de activación no puede estar vacío";
        }

        if($problems) {
            return view('joinsubjectform', compact('title', 'asignatura', 'modulo', 'codeError'));
        } else {
            return Redirect::to(config('app.url').config('app.name')."/module/$id_module");
        }
    }

    public function userSubjects($email) {
        $user = new Usuario;
        $usersubject = new UsuarioAsignatura;
        $subject = new Asignatura;
        $module = new Modulo;

        $usuario = $user->getUserByEmail($email);
        $subjects = $usersubject->getSubjectsByUser($usuario);

        if($_SESSION['email'] == $email) {
            $title = "Mis asignaturas";
        } else {
            $title = "Asignaturas de " . $user->getUserByEmail($email)->Nombre;
        }

        return view('usersubjects', compact('title', 'usuario', 'subjects', 'subject', 'module'));
    }

}
