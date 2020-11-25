@extends('layout')

@section('title') {{$title}} @endsection


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm">
                <form class="form-horizontal" method="post" action="{{config('app.url')}}{{config('app.name')}}/register">
                    @csrf
                    <fieldset>
                        <legend class="text-center header">Registro</legend>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="nombre" class="lead">Nombre</label>
                                <input id="nombre" name="nombre" type="text" placeholder="Introduzca su nombre" class="form-control"
                            value="{{ $nombre }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="apellidos" class="lead">Apellidos</label>
                                <input id="apellidos" name="apellidos" type="text" placeholder="Introduzca sus apellidos" class="form-control" 
                                value="{{ $apellidos }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="email" class="lead">Email</label>
                                <input id="email" name="email" type="email" placeholder="Introduzca su dirección de correo electrónico" class="form-control" 
                                value="{{ $email }}" required><br>
                                <span class="alert-danger"><?=$errorEmail?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="telefono" class="lead">Teléfono móvil</label>
                                <input id="telefono" name="telefono" type="tel" placeholder="Introduzca su número de teléfono" class="form-control" 
                                value="{{ $telefono }}" required><br>
                                <span class="alert-danger"><?=$errorTelefono?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="ciudad" class="lead">Ciudad</label>
                                <input id="ciudad" name="ciudad" type="text" placeholder="Introduzca la ciudad en la que reside actualmente" class="form-control" 
                                value="{{ $ciudad }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="comunidad_autonoma" class="lead">Comunidad Autónoma</label>
                                <input id="comunidad_autonoma" name="comunidad_autonoma" type="text" placeholder="Introduzca la comunidad autónoma pertinente" class="form-control" 
                                value="{{ $comunidad_autonoma }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label text="Rol" style="display: block" class="lead">Rol:</label>
                                <select name="rol_name" required>
                                    <option value="alumno">Alumno</option> 
                                    <option value="profesor">Profesor</option>
                                  </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <label for="password" class="lead">Contraseña</label>
                                <input id="password" name="password" type="password" placeholder="Escriba una contraseña" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-2 text-center"></span>
                            <div class="col-md-8">
                                <input id="repassword" name="repassword" type="password" placeholder="Repita su contraseña" class="form-control" required><br>
                                <span class="alert-danger"><?=$errorPassword?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection