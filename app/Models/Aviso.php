<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aviso extends Model
{
    use HasFactory;
    protected $table = 'avisos';
    protected $primarykey = ['IdAlumno', 'IdAsignatura', 'IdModulo', 'IdProfesor'];
    public $incrementing = false;
    public $timestamps = false;

    public function addAdvice($id_student, $id_subject, $id_module, $id_professor) {
        DB::table('avisos')->insert([
            'IdAlumno' => $id_student,
            'IdAsignatura' => $id_subject,
            'IdModulo' => $id_module,
            'IdProfesor' => $id_professor
        ]);
    }

    public function adviceExists($id_student, $id_subject, $id_module) {
        return count(Aviso::where('IdAlumno', $id_student)
        ->where('IdAsignatura', $id_subject)
        ->where('IdModulo', $id_module)
        ->get()) > 0 ? true : false;
    }

    public function deleteUserAdvicesOnModule($id_user, $id_module) {
        DB::table('avisos')->where('IdAlumno', $id_user)
        ->where('IdModulo', $id_module)
        ->delete();
    }

    public function getAdvicesFromProfessor($id_professor) {
        return Aviso::where('IdProfesor', $id_professor)->get();
    }

    public function getAdviceById($id) {
        return Aviso::where('Id', $id)->first();
    }

    public function deleteAdviceById($id) {
        DB::table('avisos')->where('Id', $id)->delete();
    }
}
