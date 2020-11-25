<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaModulo;
use App\Models\Modulo;
use App\Models\Usuario;
use App\Models\UsuarioModulo;
use Illuminate\Http\Request;

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

}
