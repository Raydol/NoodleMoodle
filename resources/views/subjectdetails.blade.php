@extends('layout')

@section('title') {{$title}} @endsection

@section('content')
<nav aria-label="breadcrumb bg-light">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <span>
          <form method="POST" 
          action="{{config('app.url')}}{{config('app.name')}}/module/{{$modulo->Id}}/{{strtolower(str_replace(" ", "", $asignatura->NombreAsignatura))}}/participants">
              @csrf
              <input type="hidden" name="id_module" value="{{$modulo->Id}}">
              <input type="hidden" name="id_subject" value="{{$asignatura->Id}}">
              <button type="submit" class="btn btn-link">Participantes</button>
          </form>
      </span>
      </li>
      <li class="breadcrumb-item">
        <form method="POST" 
          action="{{config('app.url')}}{{config('app.name')}}/module/{{$modulo->Id}}/{{strtolower(str_replace(" ", "", $asignatura->NombreAsignatura))}}/temary">
              @csrf
              <input type="hidden" name="id_module" value="{{$modulo->Id}}">
              <input type="hidden" name="id_subject" value="{{$asignatura->Id}}">
              <button type="submit" class="btn btn-link">Temario</button>
          </form>
      </li>
    </ol>
  </nav>

<h3>{{$asignatura->NombreAsignatura}} - Temario</h3>
@endsection