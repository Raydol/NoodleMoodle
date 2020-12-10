@extends('layout')


@section('content')

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active text-center">
        <img src="assets/images/pp.jpg" alt="Acceder a mis módulos" class="w-80">
        <div class="carousel-caption d-none d-md-block text-dark">
            @if (isset($_SESSION['email']))
              <a class="btn btn-primary" href="{{config('app.url')}}{{config('app.name')}}/modules/{{$_SESSION["email"]}}">Mis módulos</a>
            @endif
        </div>
      </div>
      <div class="carousel-item text-center">
        <img src="assets/images/pp.jpg" alt="Acceder a mis asignaturas" class="w-80">
        <div class="carousel-caption d-none d-md-block text-dark">
            @if (isset($_SESSION['email']))
              <a class="btn btn-primary" href="{{config('app.url')}}{{config('app.name')}}/subjects/{{$_SESSION["email"]}}">Mis asignaturas</a>
            @endif
        </div>
      </div>
      <div class="carousel-item text-center">
        <img src="assets/images/pp.jpg" alt="Acceder a mi perfil" class="w-80">
        <div class="carousel-caption d-none d-md-block text-dark">
            @if (isset($_SESSION['email']))
              <a class="btn btn-primary" href="{{config('app.url')}}{{config('app.name')}}/profile/{{$_SESSION["email"]}}">Mi perfil</a>
            @endif
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>


@endsection