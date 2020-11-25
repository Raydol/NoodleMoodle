<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsignaturaModulo extends Model
{
    use HasFactory;

    protected $table = 'asignaturasmodulos';
    protected $primarykey = ['IdAsignatura', 'IdModulo'];
    public $incrementing = false;
    public $timestamps = false;

    public function addSubjectModule($id_subject, $id_module) {
        $query = "insert into asignaturasmodulos values(?, ?)";

        return DB::insert($query, [$id_subject, $id_module]);
    }

    public function getAmountOfModulesPerSubject($id_subject) {
        return AsignaturaModulo::where('IdAsignatura', $id_subject)->count();
    }
    
}
