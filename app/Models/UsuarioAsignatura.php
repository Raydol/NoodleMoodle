<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioAsignatura extends Model
{
    use HasFactory;
    protected $table = 'usuariosasignaturas';
    protected $primarykey = ['IdUsuario', 'IdAsignatura', 'IdModulo'];
    public $incrementing = false;
    public $timestamps = false;

    public function userBelongsToSubject($id_usuario, $id_asignatura, $id_modulo) {
        return (UsuarioAsignatura::where('IdUsuario', $id_usuario)
        ->where('IdAsignatura', $id_asignatura)
        ->where('IdModulo', $id_modulo)
        ->first() != null) ? true : false;
    }

    public function deleteUserFromSubjectsOnModule($id_user, $id_module) {
        DB::table('usuariosasignaturas')->where('IdUsuario', $id_user)
        ->where('IdModulo', $id_module)
        ->delete();
    }
}
