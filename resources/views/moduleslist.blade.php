@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')
<?php
  $cont = 0;
?>

<a class="btn btn-outline-dark float-right mt-3 mr-5 mb-2" href="{{config('app.url')}}{{config('app.name')}}/module/new">
  <i class="fas fa-plus"></i> Añadir módulo
</a>

<table class="table mt-3">
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre del módulo</th>
        <th scope="col">Asignaturas del módulo</th>
        <th scope="col">Añadir asignatura al módulo</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
@foreach ($modules as $module)
  <tr>
    <td>
      <a href="{{config('app.url')}}{{config('app.name')}}/module/{{$module->Id}}" class="text-primary">
        {{$module->NombreModulo}}
      </a>
    </td>
    
    <td id="td{{$cont}}">
      @foreach ($module->subjects as $subject)
          <span>"{{$subject->NombreAsignatura}}"</span>
      @endforeach
    </td>

    <td>
      <form>
        @csrf
        <select id="{{$cont}}" name="subject">
        <option value="nothing"></option>
          @foreach ($module->subjectsSelect as $subject)
        <option value="{{$subject->Id}}" id="option{{$subject->Id}}{{$cont}}">{{$subject->NombreAsignatura}}</option>
          @endforeach
        </select>
        <input type="button" value="Añadir" onclick="addSubjectToModule({{$cont}}, {{$module->Id}});">
      </form>
    </td>

    <td class="text-center">
      <a href="javascript:void(0)" class="text-dark btn btn-outline-dark" style="text-decoration: none" 
      onclick="deleteModule({{$module->Id}});">
          <i class="fas fa-trash-alt"></i>
      </a>
    </td>
  </tr>
<?php $cont++; ?>
@endforeach
</tbody>
</table>

<script src="{{config('app.name')}}/../resources/js/functions.js"></script>

@endsection