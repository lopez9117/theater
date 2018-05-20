@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Crear Reservación</div>
                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                <div class="panel-body">
                <div id="mensaje" style="display:none" class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Exito!</strong> Se ha creado la reservación.
                </div>
                <div id="mensaje_error" style="display:none" class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Exito!</strong> Debe seleccionar las butacas.
                </div>
                    <div id="butacas">
            
                    </div>
                    <button onclick="crearReservas()" >Reservar</button>
                    <script src="/js/butacas.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
