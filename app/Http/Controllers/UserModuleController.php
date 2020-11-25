<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
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
}
