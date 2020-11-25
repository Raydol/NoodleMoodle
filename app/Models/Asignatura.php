<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asignatura extends Model
{
    use HasFactory;
    protected $table = 'asignaturas';
    protected $primaryKey = 'Id';
    public $timestamps = false;


    public function getSubjectsPerModule($id_module) {
        return Asignatura::select()
        ->join('asignaturasmodulos', 'asignaturasmodulos.IdAsignatura', '=', 'asignaturas.Id')
        ->where('asignaturasmodulos.IdModulo', '=', $id_module)
        ->get();
    }

    public function getSubjects($filter_subject = "") {
        if ($filter_subject == "") {
            return Asignatura::all();
        } else {
            return Asignatura::where('NombreAsignatura','like',$filter_subject.'%')->get();
        }
    }

    public function getAllSubjectsNotInModule($id_module) {
        $query = "select * from asignaturas where Id not in 
        (select IdAsignatura from asignaturasmodulos) or 
        Id not in (SELECT IdAsignatura from asignaturasmodulos 
        WHERE IdModulo = ?)";

        return DB::select($query, [$id_module]);
    }

    public function getSubjectById($id) {
        return (object)Asignatura::where('Id', $id)->first(); 
    }

    public function addSubject($nombreAsignatura, $codigoActivacion) {
        DB::table('asignaturas')->insert([
            'NombreAsignatura' => $nombreAsignatura,
            'CodigoActivacion' => $codigoActivacion
        ]);
    }

    public function subjectExists($nombreAsignatura) {
        return count(Asignatura::where('NombreAsignatura', $nombreAsignatura)->get()) > 0 ? true : false;
    }
}
