@extends('layout')

@section('title') {{$title}} @endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm">
            <form class="form-horizontal" method="post" action="{{$_ENV['APP_URL']}}{{$_ENV["APP_NAME"]}}/login">
                    @csrf
                    <fieldset>
                        <legend class="text-center header">Login</legend>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="email" class="lead">Correo electrónico</label>
                                <input id="email" name="email" type="email" placeholder="Introduzca su correo electrónico" class="form-control"
                            value="{{ $email }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="password" class="lead">Contraseña</label>
                                <input id="password" name="password" type="password" placeholder="Introduzca su contraseña" class="form-control" required>
                            </div>
                        </div>

                        <span class="alert-danger ml-3"><?=$errorLogueo?></span>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Login</button>
                            </div>
                        </div>



    
@endsection