@extends('layout')

@section('title') Perfil @endsection


@section('content')

<div class="container">
    <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                    <h4>{{$usuario->Nombre}} {{$usuario->Apellidos}}</h4>
                    <p class="text-secondary mb-1">{{$usuario->Rol}}</p>
                    <p class="text-muted font-size-sm">{{$usuario->Ciudad}}, {{$usuario->ComunidadAutonoma}}</p>
                      <button class="btn btn-primary">Seguir</button>
                      <button class="btn btn-outline-primary">Enviar mensaje</button>
                    </div>
                  </div>
                </div>
              </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><i class="far fa-calendar-alt fa-lg"></i> Primer acceso: </h6>
                        <span class="text-secondary">{{$usuario->FechaPrimerAcceso}}</span>
                    </li>
                </div>
                <div class="card mt-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0"><i class="far fa-calendar-alt fa-lg"></i> Ultimo acceso: </h6>
                        <span class="text-secondary">{{$usuario->FechaUltimoAcceso}}</span>
                    </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Nombre completo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$usuario->Nombre}} {{$usuario->Apellidos}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$usuario->Email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Teléfono</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$usuario->Telefono}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Ciudad</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$usuario->Ciudad}}, {{$usuario->ComunidadAutonoma}}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Módulos</i></h6>
                        <hr>
                        @foreach ($usuario->Modulos as $modulo)
                            <p>
                              <a href="{{config('app.url')}}{{config('app.name')}}/module/{{$modulo->Id}}" class="text-primary">
                                {{ucwords(strtolower($modulo->NombreModulo))}}
                              </a>
                            </p>
                        @endforeach 
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <!-- Comprobación para poner asignaturas que cursa o asignaturas que imparte -->
                      @if ($usuario->isProfessor)
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Asignaturas que imparte</i></h6>
                      @else
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Asignaturas que cursa</i></h6>
                      @endif
                      <hr>
                      
                      @foreach ($usuario->asignaturas as $asignatura)
                          <p>{{ucwords(strtolower($asignatura->NombreAsignatura))}}</p>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>    



@endsection