@extends('layout')

@section('title') {{$title}} @endsection

@section('content')
<h3>{{$modulo->NombreModulo}}</h3>

@if (!$currentUser->userBelongsToModule)
 <button>Unirte al módulo</button>
@endif

<table class="table mt-4">
    <caption>Asignaturas</caption>
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre de la asignatura</th>
        <th scope="col">Acceder</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($subjects as $subject)
        <tr>
            <td>{{$subject->NombreAsignatura}}</td>
            @if ($currentUser->userBelongsToModule && $usersubject->userBelongsToSubject(
                $currentUser->Id, 
                $subject->Id, 
                $modulo->Id
                ))
                <td><a href="">Acceder</a></td>
            @elseif ($currentUser->userBelongsToModule && !$usersubject->userBelongsToSubject(
                $currentUser->Id, 
                $subject->Id, 
                $modulo->Id
                ))
                <td><a href="">Solicitar unirse</a></td>
            @else 
                <td>No perteneces a este módulo</td>
            @endif

        </tr>
        @endforeach
    </tbody>
</table>

<table class="table mt-5">
    <caption>Profesores</caption>
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Email</th>
        <th scope="col">Asignaturas que imparte</th>
        <th scope="col">Fecha Último Acceso</th>
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
                <td>
                    @foreach ($professor->subjects as $subject)
                        <span>"{{$subject->NombreAsignatura}}"</span>
                    @endforeach
                </td>
                <td>{{$professor->FechaUltimoAcceso}}</td>
            </tr>
        @endforeach

</tbody>
</table>

<table class="table mt-5">
    <caption>Alumnos</caption>
    <thead class="bg-dark text-white">
        <th scope="col">Nombre</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Email</th>
        <th scope="col">Telefono</th>
        <th scope="col">Ciudad</th>
        <th scope="col">Fecha del último acceso</th>
        <th scope="col">Asignaturas que cursa</th>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{$student->Nombre}}</td>
            <td>{{$student->Apellidos}}</td>
            <td><a href="{{config('app.url')}}{{config('app.name')}}/profile/{{$student->Email}}">
                {{$student->Email}}
            </a></td>
            <td>{{$student->Telefono}}</td>
            <td>{{$student->Ciudad}}, {{$student->ComunidadAutonoma}}</td>
            <td>{{$student->FechaUltimoAcceso}}</td>
            <td>
                @foreach ($student->subjects as $subject)
                    <span>"{{$subject->NombreAsignatura}}"</span>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection