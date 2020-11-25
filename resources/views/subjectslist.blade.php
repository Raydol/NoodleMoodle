@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')

<form>
  @csrf
<label for="filter_subject" class="mr-3 mt-3">Buscar asignatura: 
  <input type="text" id="filter_subject">
</label>

<a class="btn btn-outline-dark float-right mt-3 mr-5" href="{{config('app.url')}}{{config('app.name')}}/subject/new">
  <i class="fas fa-plus"></i> Añadir asignatura
</a>

<table class="table mt-3">
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre de la asignatura</th>
        <th scope="col">Número de módulos en los que se cursa</th>
        <th scope="col">Número de alumnos que la cursan</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @foreach ($subjects as $subject)
      <tr>
        <td>{{$subject->NombreAsignatura}}</td>
        <td>{{$subject->AmountOfModules}}</td>
        <td>{{$subject->AmountOfStudents}}</td>
      </tr>
      @endforeach
    </tbody>
</table>

<script src="{{config('app.url')}}{{config('app.name')}}/../resources/js/functions.js"></script>
@endsection