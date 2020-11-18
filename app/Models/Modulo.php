<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table = 'modulos';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function getModulesByUser($id) {
        return Modulo::select()
        ->join('usuariosmodulos', 'usuariosmodulos.IdModulo', '=', 'modulos.Id')
        ->where('usuariosmodulos.IdUsuario', '=', $id)
        ->get();
    }

    public function getModules() {
        return Modulo::all();
    }
}
