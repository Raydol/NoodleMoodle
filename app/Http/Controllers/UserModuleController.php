<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Usuario;
use App\Models\UsuarioAsignatura;
use App\Models\UsuarioModulo;
use Illuminate\Support\Facades\Redirect;

class UserModuleController extends Controller
{
    public function joinModule($id_module) {
        $usermodule = new UsuarioModulo;
        $user = new Usuario;
        $usermodule->addUserToModule($user->getUserByEmail($_SESSION['email'])->Id, $id_module);
        
        return Redirect::to(config('app.url').config('app.name')."/module/$id_module");
    }

    public function leaveModule($id_module) {

        //Instanciamos los modelos que vamos a necesitar
        $usermodule = new UsuarioModulo;
        $user = new Usuario;
        $usersubject = new UsuarioAsignatura;
        $advice = new Aviso;

        //Primero borramos al usuario del módulo en la tabla usuariosmodulos
        $usermodule->deleteUserFromModule($user->getUserByEmail($_SESSION["email"])->Id, $id_module);
        
        /*
          Después borramos de usuariosasignaturas las filas en las que el usuario estaba relacionado
          con las asignaturas del módulo que ha abandonado
        */
        $usersubject->deleteUserFromSubjectsOnModule($user->getUserByEmail($_SESSION["email"])->Id, $id_module);

        /*
          Borramos también las solicitudes de ese usuario en la tabla avisos
        */
        $advice->deleteUserAdvicesOnModule($user->getUserByEmail($_SESSION["email"])->Id, $id_module);


        return Redirect::to(config('app.url').config('app.name')."/modules/".$_SESSION['email']);
    }
}
