@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar Reservación</div>
                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" id="reservacion_id" value="{{$reservacion_id}}">
                <div class="panel-body">
                <div id="mensaje" style="display:none" class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Exito!</strong> Se ha actualizado la reservación.
                </div>
                <div id="mensaje_error" style="display:none" class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Exito!</strong> Debe seleccionar las butacas.
                </div>
                    <div id="butacas">
                        
                    </div>
                    <button onclick="actualizarReservas()" >Reservar</button>
                    <script src="/js/show_reserva.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
