@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Crear Usuario</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/usuarios" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Apellido</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="" required >
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="text" placeholder="Deje en blanco si no desea cambiar" class="form-control" name="password" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button onclick="actualizarUsuario()" id="btnActualizar" class="btn btn-primary">
                                    Crear
                                </button>
                                <a class="btn btn-primary" href="/usuarios" >
                                    Volver
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function actualizarUsuario(){
        var user_id   = document.getElementById('user_id').value
        var name      = document.getElementsByName('name')[0].value
        var last_name = document.getElementsByName('last_name')[0].value
        var email     = document.getElementsByName('email')[0].value
        
        $.ajax({
                url: '/usuarios/'+user_id,
                type: 'put',
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: name,
                    last_name: last_name,
                    email: email
                }
            }).done((response) => {
                console.log(response)
                $("#btnActualizar").notify(
                    response.mensaje,
                    { position:"right" }
                );
            })
    }
</script>
@endsection
