<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Aviso;
use App\Models\Modulo;
use App\Models\Usuario;
use App\Models\UsuarioAsignatura;
use Illuminate\Support\Facades\Redirect;

class AdviceController extends Controller
{
    public function advices() {
        $title = "Mis avisos";
        
        //Instanciamos los models que vamos a utilizar
        $user = new Usuario;
        $advice = new Aviso;
        $subject = new Asignatura;
        $module = new Modulo;

        $usuario = $user->getUserByEmail($_SESSION['email']);
        $advices = $advice->getAdvicesFromProfessor($usuario->Id);


        return view('advices', compact('title', 'advices', 'user', 'subject', 'module'));
    }

    public function processRequest() {
        $advice_id = $_POST['advice_id'] ?? "";
        $success = isset($_POST['accept']);

        $usersubject = new UsuarioAsignatura;
        $advice = new Aviso;

        $aviso = $advice->getAdviceById($advice_id);

        if ($success) {
            //Meto al alumno en la asignatura, borro el aviso y recargo los avisos
            $usersubject->addUserToSubjectOnModule($aviso->IdAlumno, $aviso->IdAsignatura, $aviso->IdModulo);
            $advice->deleteAdviceById($aviso->Id);
            return Redirect::to(config('app.url').config('app.name')."/advices");

        } else {
            //Borro el aviso y recargo los avisos
            $advice->deleteAdviceById($aviso->Id);
            return Redirect::to(config('app.url').config('app.name')."/advices");
        }
    }
}
