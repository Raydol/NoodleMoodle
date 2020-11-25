@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')

<!-- Default module form -->

<form class="p-5 w-50" 
action="{{config('app.url')}}{{config('app.name')}}/module/new" method="POST" style="margin:0 auto">
    @csrf
    <p class="h4 mb-4 text-center">Nuevo Módulo</p>

    <!-- Nombre Módulo -->
    <input type="text" name="nombreModulo" class="form-control mb-4" 
placeholder="Nombre del módulo" value="{{$nombreModulo}}" required>
<span class="alert-danger d-block mb-1">{{$moduleError}}</span>

    <!-- Guardar los cambios -->
    <button class="btn btn-outline-dark btn-block my-4" type="submit">Añadir</button>
</form>
<!-- Default module form -->

@endsection