@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de reservaciones</div>

                <div class="panel-body">
                    
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Número de personas</th>
                            <th>Butacas</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="reservas" >
                        @foreach($reservaciones as $reservacion)
                            <tr>
                                <td>{{$reservacion->updated_at}}</td>
                                <td>{{$reservacion->number_persons}}</td>
                                <td>
                                    @foreach( $reservacion->butacas as $butaca )
                                        <span class="badge taken ">{{$butaca->seat}}</span>
                                    @endforeach
                                </td>
                                <td> 
                                    <a onclick="eliminarReservacion({{$reservacion->id}})">Cancelar</a>
                                    <a href="/reservaciones/{{$reservacion->id}}" >Editar</a>
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
    function eliminarReservacion(id){
        $.ajax({
            url: 'reservaciones/'+id,
            type: 'delete',
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        }).done((response) => {
            location.href=""
        })
    }

</script>
@endsection
