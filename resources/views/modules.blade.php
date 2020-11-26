@extends('layout');

@section('title') {{$title}}  @endsection


@section('content')

<table class="table">
    <thead class="bg-dark text-white">
      <tr>
        <th scope="col">Nombre del módulo</th>
        <th scope="col">Usuarios matriculados por módulo</th>
        <th scope="col">Unirte</th>
      </tr>
    </thead>
    <tbody>
@foreach ($modules as $module)
<tr>
<td><a href="{{config('app.url')}}{{config('app.name')}}/module/{{$module->Id}}" class="text-dark">{{$module->NombreModulo}}</a></td>
    <td>{{$module->NumeroUsuarios}}</td>
    @if ($module->UserBelongsToModule)
    <td>Ya cursas este módulo</td>
    @else
    <td><a class="btn btn-dark" href="{{config('app.url')}}{{config('app.name')}}/module/{{$module->Id}}" role="button">Unirte al módulo</a></td>
    @endif
</tr>

@endforeach
</tbody>
</table>


@endsection