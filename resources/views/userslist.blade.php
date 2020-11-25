@extends('layout')

@section('title') {{$title}}  @endsection

@section('content')

<form>
    @csrf
<label for="rol" class="mr-3 mt-3">Filtrar por rol: 
    <select id="rol" name="rol" onchange="filtrarRol();">
        <option value="all" selected>Todos</option>
        <option value="alumno">Alumno</option>
        <option value="profesor">Profesor</option>
    </select>
</label>

<!--<label for="nombre">Filtrar por nombre: 
    <input type="text" id="nombre">
</label>-->
</form>

<table class="table mt-4">
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Correo electrónico</th>
        <th scope="col">Teléfono</th>
        <th scope="col">Ciudad</th>
        <th scope="col">Comunidad Autónoma</th>
        <th scope="col">Rol</th>
        <th scope="col">Fecha del primer acceso</th>
        <th scope="col">Fecha del ultimo acceso</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody id="tableBody">
@foreach ($users as $user)
    <tr>
        <td>{{$user->Nombre}}</td>
        <td>{{$user->Apellidos}}</td>
        <td>{{$user->Email}}</td>
        <td>{{$user->Telefono}}</td>
        <td>{{$user->Ciudad}}</td>
        <td>{{$user->ComunidadAutonoma}}</td>
        <td>{{$user->RolName}}</td>
        <td>{{$user->FechaPrimerAcceso}}</td>
        <td>{{$user->FechaUltimoAcceso}}</td>
        <td class="text-center">
            <a href="javascript:void(0)" class="text-dark" style="text-decoration: none" 
            onclick="deleteUser({{$user->Id}})">
                <i class="fas fa-trash-alt"></i>
            </a>
        </td>
    </tr>

@endforeach
</tbody>
</table>

<script src="{{config('app.name')}}/../resources/js/functions.js"></script>

@endsection