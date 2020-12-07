<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaModulo;
use App\Models\Aviso;
use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\UsuarioAsignatura;
use DateTime;
use DateTimeZone;
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

    

    public function deleteSubject() {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        
        $subject = new Asignatura;
        $subjectmodule = new AsignaturaModulo;
        $user = new Usuario;

        try {
            $subject->deleteSubjectById($data[0]);
            $subjects = $subject->getSubjects();
            foreach($subjects as $sub) {
                $sub->AmountOfModules = $subjectmodule->getAmountOfModulesPerSubject($sub->Id);
                $sub->AmountOfStudents = $user->getAmountOfStudentsPerSubject($sub->Id);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return json_encode($subjects);
    }


    //Temario de la asignatura
    public function subjectDetails() {
        $title = "Asignatura";

        $id_module = $_POST['id_module'] ?? "";
        $id_subject = $_POST['id_subject'] ?? "";

        //Instanciamos los modelos que vamos a necesitar
        $user = new Usuario;
        $subject = new Asignatura;
        $module = new Modulo;

        $asignatura = $subject->getSubjectById($id_subject);
        $modulo = $module->getModuleById($id_module);
        $current_user = $user->getUserByEmail($_SESSION['email']);
        $current_user->isProfessorOnSubjectInModule = $user->isProfessorOnSubjectInModule(
            $current_user->Id, 
            $id_subject, 
            $id_module
        );

        if(is_dir("assets/files/$id_subject$id_module")) {
            $files = scandir("assets/files/$id_subject$id_module");
        } else {
            $files = [];
        }

        return view('subjectdetails', compact('title', 'modulo', 'asignatura', 'current_user', 'files'));
    }


    //Participantes de la asignatura
    public function subjectParticipants() {
        $title = "Participantes";

        $id_module = $_POST['id_module'] ?? "";
        $id_subject = $_POST['id_subject'] ?? "";

        //Instanciamos los modelos que vamos a necesitar
        $user = new Usuario;
        $subject = new Asignatura;
        $module = new Modulo;
        $rol = new Rol;

        $asignatura = $subject->getSubjectById($id_subject);
        $modulo = $module->getModuleById($id_module);
        $professors = $user->getProfessorsPerSubjectOnModule($id_subject, $id_module);
        $students = $user->getStudentsPerSubjectOnModule($id_subject, $id_module);

        foreach ($professors as $professor) {
            $fechaActual = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $fechaUltimoAcceso = new DateTime($professor->FechaUltimoAcceso, new DateTimeZone('Europe/Madrid'));
            $intervalo = $fechaActual->diff($fechaUltimoAcceso);
            
            $professor->UltimoAcceso = $this->getTime($intervalo);
            $professor->Rol = ucwords($rol->getRolById($professor->IdRol));
        }

        foreach ($students as $student) {
            $fechaActual = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $fechaUltimoAcceso = new DateTime($student->FechaUltimoAcceso, new DateTimeZone('Europe/Madrid'));
            $intervalo = $fechaActual->diff($fechaUltimoAcceso);

            $student->UltimoAcceso = $this->getTime($intervalo);
            $student->Rol = ucwords($rol->getRolById($student->IdRol));
        }

        return view('subjectparticipants', compact('title', 'modulo', 'asignatura', 'professors', 'students'));
    }




    public function getTime($fecha) {
        $tiempo = "";

        if($fecha->y > 0) {
            $tiempo .= $fecha->y;
         
            if ($fecha->y == 1)
                $tiempo .= " año, ";
            else
                $tiempo .= " años, ";
        }
     
        //meses
        if ($fecha->m > 0) {
            $tiempo .= $fecha->m;
            
            if ($fecha->m == 1)
                $tiempo .= " mes, ";
            else
                $tiempo .= " meses, ";
        }
     
        //dias
        if ($fecha->d > 0) {
            $tiempo .= $fecha->d;
         
        if ($fecha->d == 1)
            $tiempo .= " día, ";
        else
            $tiempo .= " días, ";
        }
     
        //horas
        if ($fecha->h > 0) {
            $tiempo .= $fecha->h;
         
        if ($fecha->h == 1)
            $tiempo .= " hora, ";
        else
            $tiempo .= " horas, ";
        }
     
        //minutos
        if ($fecha->i > 0) {
            $tiempo .= $fecha->i;
         
            if($fecha->i == 1)
                $tiempo .= " minuto ";
            else
                $tiempo .= " minutos ";
        } 
        
        $tiempo .= $fecha->s." segundos";

        return $tiempo;
    }


    public function loadFile() {

        $fichero = $_FILES["file"];
        $id_subject = $_POST['id_subject'];
        $id_module = $_POST['id_module'];
        $title = "Archivo subido";

        //Instanciamos los modelos que vamos a necesitar
        $module = new Modulo;
        $subject = new Asignatura;

        $asignatura = $subject->getSubjectById($id_subject);
        $modulo = $module->getModuleById($id_module);

        if(!is_dir("assets/files/$id_subject$id_module")) {
            mkdir("assets/files/$id_subject$id_module", 0777, true);
        }

        move_uploaded_file($fichero["tmp_name"], "assets/files/$id_subject$id_module/".$fichero["name"]);


        return view("loadfile", compact('title', 'modulo', 'asignatura'));
    }

    public function deleteFile() {
        $id_subject = $_POST["id_subject"];
        $id_module = $_POST["id_module"];
        $file_name = $_POST["file_name"];
        $title = "Archivo borrado";

        //Instanciamos los modelos que vamos a necesitar
        $module = new Modulo;
        $subject = new Asignatura;

        $asignatura = $subject->getSubjectById($id_subject);
        $modulo = $module->getModuleById($id_module);

        unlink("assets/files/$id_subject$id_module/$file_name");

        return view("deletefile", compact('title', 'modulo', 'asignatura'));
    }


}
