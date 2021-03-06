<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioModulo extends Model
{
    use HasFactory;
    protected $table = 'usuariosmodulos';
    protected $primarykey = ['IdUsuario', 'IdModulo'];
    public $incrementing = false;
    public $timestamps = false;

    public function getAmountOfUsersPerModule($id_module) {
        return UsuarioModulo::where('IdModulo', $id_module)->count();
    }

    public function userBelongsToModule($id_usuario, $id_modulo) {
        return (UsuarioModulo::where('IdModulo', $id_modulo)
        ->where('IdUsuario', $id_usuario)->first() != null) ? true : false;
    }

    public function addUserToModule($id_user, $id_module) {
        DB::table('usuariosmodulos')->insert([
            'IdUsuario' => $id_user,
            'IdModulo' => $id_module
        ]);
    }

    public function deleteUserFromModule($id_user, $id_module) {
        DB::table('usuariosmodulos')->where('IdUsuario', $id_user)
        ->where('IdModulo', $id_module)
        ->delete();
    }
}
