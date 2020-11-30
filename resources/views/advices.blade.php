@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')

    @if (count($advices) == 0)
        <p class="mt-3 ml-3"> * No tienes ningún aviso</p>
    @else
        <ul class="list-group mt-2">
            @foreach ($advices as $advice)
                <li class="list-group-item mt-1">
                    <span>
                        <a href="{{config('app.url')}}{{config('app.name')}}/profile/{{$user->getUserById($advice->IdAlumno)->Email}}">
                            {{$user->getUserById($advice->IdAlumno)->Nombre}} 
                            {{$user->getUserById($advice->IdAlumno)->Apellidos}}
                        </a>
                        ha solicitado unirse a 
                        <a href="">
                            {{$subject->getSubjectById($advice->IdAsignatura)->NombreAsignatura}}
                        </a>
                        en el módulo
                        <a href="{{config('app.url')}}{{config('app.name')}}/module/{{$advice->IdModulo}}">
                            {{$module->getModuleById($advice->IdModulo)->NombreModulo}}
                        </a>
                    </span>
                    <span class="float-right">
                        <form action="{{config('app.url')}}{{config('app.name')}}/advice/request" method="POST">
                            @csrf
                            <input type="hidden" value="{{$advice->Id}}" name="advice_id">
                            <button type="submit" class="btn btn-success" name="accept">Aceptar</button>
                            <button type="submit" class="btn btn-danger" name="reject">Rechazar</button>
                        </form>
                    </span>
                </li>
            @endforeach
        </ul>
    @endif



@endsection