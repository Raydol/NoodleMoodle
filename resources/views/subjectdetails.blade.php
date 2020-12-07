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

<!-- Si el usuario es el profesor de la asignatura y del módulo -->
@if ($current_user->isProfessorOnSubjectInModule)

<form method="POST" action="{{config('app.url')}}{{config('app.name')}}/module/{{$modulo->Id}}/{{strtolower(str_replace(" ", "", $asignatura->NombreAsignatura))}}/temary/load" enctype="multipart/form-data">
  @csrf
  <input type="file" name="file">
  <input type="hidden" name="id_module" value="{{$modulo->Id}}">
  <input type="hidden" name="id_subject" value="{{$asignatura->Id}}">
  <input type="submit" value="Subir archivo">
</form>

@endif

<h3 class="mt-5 text-center">Archivos subidos por el profesor</h3>
<table class="table">
  <thead class="bg-dark text-white">
    <th scope="col">Nombre del archivo</th>
    <th scope="col">Descargar</th>
    @if ($current_user->isProfessorOnSubjectInModule)
    <th scope="col">Eliminar</th>
    @endif
  </thead>
  <tbody>
    @for ($i = 2; $i < count($files); $i++)
        <tr>
          <td>{{$files[$i]}}</td>
          <td>
            <a title="Descargar Archivo" class="text-dark"href="../../../assets/files/{{$asignatura->Id}}{{$modulo->Id}}/{{$files[$i]}}" download="{{$files[$i]}}">
              <i class="fas fa-download"></i>
            </a>
          </td>
          @if ($current_user->isProfessorOnSubjectInModule)
          
          <form method="POST" action="{{config('app.url')}}{{config('app.name')}}/module/{{$modulo->Id}}/{{strtolower(str_replace(" ", "", $asignatura->NombreAsignatura))}}/temary/delete">
            @csrf
            <input type="hidden" name="id_module" value="{{$modulo->Id}}">
            <input type="hidden" name="id_subject" value="{{$asignatura->Id}}">
            <input type="hidden" name="file_name" value="{{$files[$i]}}">
            <td>
              <button type="submit" class="btn btn-link text-dark">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </form>

          
          @endif
        </tr>
    @endfor
  </tbody>
</table>

@endsection