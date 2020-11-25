<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaModulo;
use App\Models\Usuario;
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

}
