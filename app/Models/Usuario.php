<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'Id';
    public $timestamps = false;


    /**
     * Comprueba si existe en la base de datos un usuario con el mismo email pasado
     * como parámetro
     */
    public function userExists($email)
    {
        return count(Usuario::where('Email', $email)->get()) > 0 ? true : false;
    }

    /**
     * Añade un usuario a la base de datos
     */
    public function addUser($usuario)
    {
        $usuario->save();
    }

    public function getUserByEmail($email) {
        return (object)Usuario::where('Email', $email)->first();
    }

    public function getPasswordByEmail($email) {
        return Usuario::where('Email', $email)->first()->Password;
    }

    public function updateUserLastAccessDate($email) {
        $usuario = Usuario::Where("Email", $email)->first();
        $usuario->FechaUltimoAcceso = new DateTime('now', new DateTimeZone('Europe/Madrid'));
        $usuario->save();
    }

    public function getUsers() {
        return Usuario::all();
    }

    public function getAllStudents() {
        return Usuario::select()
        ->join('roles', 'roles.Id', '=', 'usuarios.IdRol')
        ->where('roles.NombreRol', '=', 'alumno')
        ->get();
    }

    public function getAllProfessors() {
        return Usuario::select()
        ->join('roles', 'roles.Id', '=', 'usuarios.IdRol')
        ->where('roles.NombreRol', '=', 'profesor')
        ->get();
    }
}
