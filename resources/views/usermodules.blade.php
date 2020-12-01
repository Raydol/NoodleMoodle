@extends('layout')

@section('title') {{$title}}  @endsection


@section('content')

@if ($usuario->Email == $_SESSION["email"])
<blockquote class="blockquote">
  <h1 class="mb-0 display-5">Mis módulos</h1>
<footer class="blockquote-footer"><cite title="Source Title">{{$usuario->Nombre}} {{$usuario->Apellidos}}</cite></footer>
</blockquote>
@else
<blockquote class="blockquote">
<h2 class="mb-0 display-5">Módulos que cursa 
    <a href="{{config('app.url')}}{{config('app.name')}}/profile/{{$usuario->Email}}">
      {{$usuario->Nombre}} {{$usuario->Apellidos}}
    </a>
</h2>
</blockquote>
@endif

@if ($usuario->Email == $_SESSION["email"])
<a class="btn btn-dark mb-3" href="{{config('app.url')}}{{config('app.name')}}/modules" role="button">Unirte a un módulo</a>
@endif

<div class="row">
@foreach ($modules as $module)
<div class="col-md-2">
  <div class="card card-cascade wider bg-white shadow-sm" style="width: 18rem;">
      <div class="view view-cascade overlay">
        <img class="card-img-top ml-5 mt-2 rounded-circle" src="https://pikwizard.com/photos/diary,-sticky-notes,-pencil-and-paper-clip-on-wooden-table--71297efed296e01e1feebb7051751140-m.jpg" style="width: 12rem;" alt="Card image cap">
      </div>
        <div class="card-body card-body-cascade text-center">
          <h5 class="card-title">{{$module->NombreModulo}}</h5>
          @if ($usuario->Email == $_SESSION["email"])
            <a href="{{config('app.url')}}{{config('app.name')}}/module/{{$module->Id}}" class="btn btn-outline-secondary">Acceder</a>
          @endif
        </div>
  </div>
</div>
@endforeach
</div>

@endsection