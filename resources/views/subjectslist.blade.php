@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')

<a class="btn btn-outline-dark float-right mt-3 mr-5 mb-2" href="{{config('app.url')}}{{config('app.name')}}/subject/new">
  <i class="fas fa-plus"></i> Añadir asignatura
</a>

<table class="table mt-3">
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre de la asignatura</th>
        <th scope="col">Número de módulos en los que se cursa</th>
        <th scope="col">Número de alumnos que la cursan</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @foreach ($subjects as $subject)
      <tr>
        <td>{{$subject->NombreAsignatura}}</td>
        <td>{{$subject->AmountOfModules}}</td>
        <td>{{$subject->AmountOfStudents}}</td>
        <td class="text-center">
          <a href="javascript:void(0)" class="text-dark btn btn-outline-dark" style="text-decoration: none" 
          onclick="deleteSubject({{$subject->Id}});">
              <i class="fas fa-trash-alt"></i>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
</table>

<script src="{{config('app.url')}}{{config('app.name')}}/../resources/js/functions.js"></script>
@endsection