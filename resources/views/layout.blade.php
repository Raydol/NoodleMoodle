<?php
    use App\Models\Usuario;
    use App\Models\Aviso;
    $advice = new Aviso;
    $user = new Usuario;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <title>
        @yield('title')
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
    </style>

    <script>
        var URL_PATH = 'NoodleMoodle/public';
    </script>
    
</head>

<body>

    @section('header')

        <div class="container-fluid">
            <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="{{config('app.name')}}">
                    <img width="50" height="50"
                    src="https://pikwizard.com/photos/plate-meal-food--5d9c5c35695b714113ccd7e5bca6b5be-m.jpg"
                        class="d-inline-block align-top rounded-circle" alt="" loading="lazy">
                    NoodleMoodle    
                </a>
            </nav>
    @show

    <div id="navbar">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
              <div class="navbar-nav">
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}">Home</a>
                
        @if (!isset($_SESSION["email"]))
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/login">Login</a>
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/register">Register</a>
            </div>
          </nav>
        @else
            @if ($_SESSION["email"] === 'admin@admin.admin')
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/moduleslist">Módulos</a>
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/subjectslist">Asignaturas</a>
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/userslist">Usuarios</a>
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/profile/{{$_SESSION["email"]}}">Mi perfil</a>
                <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/logout">Cerrar sesión</a>
            @else
                <!-- Aqui comprobamos si el usuario es profesor -->
                @if (!$user->isProfessor($user->getUserByEmail($_SESSION['email'])->Id))
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/modules/{{$_SESSION["email"]}}">Mis módulos</a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/subjects">Mis asignaturas</a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/profile/{{$_SESSION["email"]}}">Mi perfil</a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/logout">Cerrar sesión</a>
                @else
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/modules/{{$_SESSION["email"]}}">Mis módulos</a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/subjects">Mis asignaturas</a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/profile/{{$_SESSION["email"]}}">Mi perfil</a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/advices">
                        Avisos 
                        <span class="badge badge-warning">
                            {{count($advice->getAdvicesFromProfessor($user->getUserByEmail($_SESSION['email'])->Id))}}
                        </span>
                    </a>
                    <a class="nav-link" href="{{config('app.url')}}{{config('app.name')}}/logout">Cerrar sesión</a>
                @endif
            @endif
        @endif
    </div>
    </div>
</div>

    <div id="content">
        @yield('content')
    </div>

    <div id="footer">
        @yield('footer')
    </div>


</div>
</body>


</html>
