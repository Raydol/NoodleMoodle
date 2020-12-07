@extends('layout')

@section('title') {{$title}} @endsection

@section('content')

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h4 class="display-8">Archivo cargado con éxito</h4>
            <p class="lead">El archivo se ha subido satisfactoriamente al sistema</p>
            <form method="POST" action="{{config('app.url')}}{{config('app.name')}}/module/{{$modulo->Id}}/{{strtolower(str_replace(" ", "", $asignatura->NombreAsignatura))}}/temary">
                @csrf
                <input type="hidden" name="id_module" value="{{$modulo->Id}}">
                <input type="hidden" name="id_subject" value="{{$asignatura->Id}}">
                <td>
                  <button type="submit" class="btn btn-link">Volver al temario</button>
                </td>
              </form>
        </div>
    </div>




@endsection