@extends('layout')

@section('title') {{$title}} @endsection

@section('content')
<nav aria-label="breadcrumb bg-light">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{config('app.url')}}{{config('app.name')}}/module/{{$id_module}}/{{strtolower(str_replace(" ", "", $asignatura->NombreAsignatura))}}/participants">
          Participantes
        </a>
      </li>
      <li class="breadcrumb-item"><a href="#">Temario</a></li>
    </ol>
  </nav>

<h3>{{$asignatura->NombreAsignatura}}</h3>
@endsection