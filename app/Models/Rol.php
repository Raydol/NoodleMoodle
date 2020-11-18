<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'Id';
    public $incrementing = false;
    public $timestamps = false;

    public function getIdByRol($rol_name) {

        return Rol::where('NombreRol', $rol_name)->get('Id')[0]->Id;
    }

    public function getRolById($id_rol) {
        return Rol::where('Id', $id_rol)->get('NombreRol')[0]->NombreRol;
    }
}
