@extends('layout')

@section('title') {{$title}} @endsection

@section('content')

<form class="p-5 w-50" 
action="{{config('app.url')}}{{config('app.name')}}/module/{{strtolower($asignatura->NombreAsignatura)}}/join" method="POST" style="margin:0 auto">
    @csrf
    <p class="h4 mb-4 text-center">{{$asignatura->NombreAsignatura}}</p>

    <!-- Input hidden para recoger el código generado en el span anterior -->
    <label for="activationCode" class="label">Activar asignatura:</label>
    <input type="text" id="activationCode" name="activationCode" placeholder="Introduce el código"
    maxlength="5" required>
    <input type="hidden" value="{{$asignatura->Id}}" name="idSubject">
    <input type="hidden" value="{{$modulo->Id}}" name="idModule">
    <span class="alert-danger">{{$codeError}}</span>

    <!-- Guardar los cambios -->
    <button class="btn btn-outline-dark btn-block my-4" type="submit">Solicitar incorporación</button>
</form>

@endsection