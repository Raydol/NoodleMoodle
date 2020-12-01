<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function moduleExists($nombreModulo) {
        return count(Modulo::where('NombreModulo', $nombreModulo)->get()) > 0 ? true : false;
    }

    public function addModule($nombreModulo) {
        DB::table('modulos')->insert([
            'NombreModulo' => $nombreModulo
        ]);
    }

    public function getModuleById($id) {
        return Modulo::where('Id', $id)->first();
    }

    public function deleteModuleById($id) {
        DB::table('modulos')->delete($id);
    }
}
