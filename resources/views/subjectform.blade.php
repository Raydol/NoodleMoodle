@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')

<!-- Default form login -->

<form class="p-5 w-50" 
action="{{config('app.url')}}{{config('app.name')}}/subject/new" method="POST" style="margin:0 auto">
    @csrf
    <p class="h4 mb-4 text-center">Nueva Asignatura</p>

    <!-- Nombre Asignatura -->
    <input type="text" name="nombreAsignatura" class="form-control mb-4" 
placeholder="Nombre de la asignatura" value="{{$nombreAsignatura}}" required>
<span class="alert-danger d-block mb-1">{{$subjectError}}</span>

    <!-- Código de activación  -->
    <a class="btn btn-dark" onclick="generateCode();">Generar código de activación</a>
    <br><br>
    <label for="generatedCode">Código generado: <span id="generatedCode" required></span></label>
    <span class="alert-danger d-block">{{$codeError}}</span>

    <!-- Input hidden para recoger el código generado en el span anterior -->
    <input type="hidden" id="inputGeneratedCode" name="codigoActivacion">

    <!-- Guardar los cambios -->
    <button class="btn btn-outline-dark btn-block my-4" type="submit">Añadir</button>
</form>
<!-- Default form login -->

<script src="{{config('app.name')}}/../resources/js/functions.js"></script>

@endsection