@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de Usuarios | <a href="/usuarios/create">Crear</a> </div>

                <div class="panel-body">
                    
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>E-mail</th>
                            <th>Reservaciones</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="reservas" >
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{$usuario->name." ".$usuario->last_name}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>{{$usuario->reservations}}</td>
                                <td> 
                                    <a href="/usuarios/{{$usuario->id}}" >Editar</a>
                                    <a href="#" onclick="eliminarUsuario({{$usuario->id}})" >Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function eliminarUsuario(id){
        $.ajax({
            url: 'usuarios/'+id,
            type: 'delete',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        }).done((response) => {
            console.log(response)
            location.href="/usuarios"
        })
    }

</script>
@endsection
