@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')
    @if ($usuario->Email == $_SESSION["email"])
        <blockquote class="blockquote">
            <h1 class="mb-0 display-5">Mis asignaturas</h1>
            <footer class="blockquote-footer"><cite title="Source Title">{{$usuario->Nombre}} {{$usuario->Apellidos}}</cite></footer>
        </blockquote>
    @else
        <blockquote class="blockquote">
            <h2 class="mb-0 display-5">Asignaturas que cursa 
                <a href="{{config('app.url')}}{{config('app.name')}}/profile/{{$usuario->Email}}">
                    {{$usuario->Nombre}} {{$usuario->Apellidos}}
                </a>
            </h2>
        </blockquote>
    @endif
    @if (count($subjects) == 0)
        <p class="mt-3 ml-3"> * No se encuentra ninguna asignatura</p>
    @else
        <ul class="list-group mt-2">
            @foreach ($subjects as $sub)
                <li class="list-group-item mt-1">
                    <span>
                        @if ($usuario->Email == $_SESSION["email"])
                            <form method="POST" class="d-inline"
                                action="{{config('app.url')}}{{config('app.name')}}/module/{{$sub->IdModulo}}/{{strtolower(str_replace(" ", "", $subject->getSubjectById($sub->IdAsignatura)->NombreAsignatura))}}">
                                @csrf
                                <input type="hidden" name="module_id" value="{{$sub->IdModulo}}">
                                <input type="hidden" name="subject_id" value="{{$sub->IdAsignatura}}">
                                <button type="submit" class="btn btn-link">
                                    {{$subject->getSubjectById($sub->IdAsignatura)->NombreAsignatura}}
                                </button>
                            </form>
                        @else
                            <span class="text-primary">{{$subject->getSubjectById($sub->IdAsignatura)->NombreAsignatura}}</span>
                        @endif
                        perteneciente a 
                        <a href="{{config('app.url')}}{{config('app.name')}}/module/{{$sub->IdModulo}}">
                            {{$module->getModuleById($sub->IdModulo)->NombreModulo}}
                        </a>
                    </span>
                    @if ($usuario->Email == $_SESSION["email"])
                        <span class="float-right">
                            <form method="POST" 
                            action="{{config('app.url')}}{{config('app.name')}}/module/{{$sub->IdModulo}}/{{strtolower(str_replace(" ", "", $subject->getSubjectById($sub->IdAsignatura)->NombreAsignatura))}}">
                                @csrf
                                <input type="hidden" name="module_id" value="{{$sub->IdModulo}}">
                                <input type="hidden" name="subject_id" value="{{$sub->IdAsignatura}}">
                                <button type="submit" class="btn btn-success" name="accept">Acceder</button>
                            </form>
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif


    <script src="{{config('app.url')}}{{config('app.name')}}/../resources/js/functions.js"></script>
@endsection