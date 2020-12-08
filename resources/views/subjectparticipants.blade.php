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

<h3 class="d-inline">{{$asignatura->NombreAsignatura}} - Participantes</h3>
<button type="button" class="btn btn-outline-primary d-inline ml-4 mb-3" onclick="leaveSubject({{$asignatura->Id}}, {{$modulo->Id}});">
  <i class="fas fa-sign-out-alt"></i> Abandonar asignatura
</button>

<table class="table mt-5 text-center">
    <caption>Profesores</caption>
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Email</th>
        <th scope="col">Rol</th>
        <th scope="col">Último acceso al aula virtual</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($professors as $professor)
        <tr>
            <td>{{$professor->Nombre}}</td>
            <td>{{$professor->Apellidos}}</td>
            <td>
              <a href="{{config('app.url')}}{{config('app.name')}}/profile/{{$professor->Email}}">
                {{$professor->Email}}
              </a>
            </td>
            <td>{{$professor->Rol}}</td>
            <td>{{$professor->UltimoAcceso}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table class="table mt-5 text-center">
    <caption>Alumnos</caption>
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Email</th>
        <th scope="col">Rol</th>
        <th scope="col">Último acceso al aula virtual</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{$student->Nombre}}</td>
            <td>{{$student->Apellidos}}</td>
            <td>
              <a href="{{config('app.url')}}{{config('app.name')}}/profile/{{$student->Email}}">
                {{$student->Email}}
              </a>
            </td>
            <td>{{$student->Rol}}</td>
            <td>{{$student->UltimoAcceso}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script src="{{config('app.name')}}/../resources/js/functions.js"></script>

@endsection