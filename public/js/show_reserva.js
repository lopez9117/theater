window.onload = cargarButacas

function cargarButacas (){
    $.ajax({
        url: '/butacas',
        type: 'get',
    }).done(function(response) {
        console.log('todo bien' + response.butacas);
        var contenedor
        contenedor = document.getElementById('butacas');
        contenedor.innerHTML = ""
        var reservacion_id = document.getElementById('reservacion_id').value
        console.log(reservacion_id)
        for( i = 1; i < 6; i++ ){
            contenedor.innerHTML += `<div class="row">`
            for( j = 1; j < 11; j++ ){
                // contenedor.innerHTML += '<input type="text" value="'+(i+1)+','+(j+1)+'">'
                var seat = i+"-"+j
                var taken = ""
                var clases = "available"
                response.butacas.forEach(element => {

                    if(element.seat==seat && element.reservation_id==reservacion_id){
                        clases = "taken"
                        taken = "checked"
                        console.log(element.reservation_id  )
                    }
                    if(element.seat==seat && element.reservation_id!=reservacion_id && element.taken=="si" ){
                        taken = "disabled"
                        clases = "no_available"
                        console.log(element.reservation_id  )
                    }
                });
                contenedor.innerHTML += 
                `<div class="col-md-1 center">
                    <input type="checkbox" ${taken} value="${i}-${j}" name="butaca">
                    <span class="badge ${clases} ">${i}-${j}</span>
                </div>`

            }
            contenedor.innerHTML += `</div>`
        }


    })
}





function actualizarReservas(){
    var butacas = document.getElementsByName('butaca')
    var numero_personas = 0
    var reservacion_id = document.getElementById('reservacion_id').value
    
    for( i = 0; i<butacas.length; i++ ){
        if( butacas[i].checked ){
            numero_personas += 1;
        }
    }
    if(numero_personas > 0){
        $.ajax({
            url: '/reservaciones/'+reservacion_id,
            type: 'put',
            data: {
                _token: $("#token").val(),
                number_persons: numero_personas
            }
        }).done((response) => {
            console.log('id de reservacion: ' + response.reservacion.id);
            reservacion_id = response.reservacion.id
            $.ajax({
                url:'/reservaciones/delete_all_butacas/'+reservacion_id,
                type: 'delete',
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }
            })
            for( i = 0; i<butacas.length; i++ ){
                if( butacas[i].checked ){
                    $.ajax({
                        url: '/butacas',
                        type: 'post',
                        data: {
                            _token: $("#token").val(),
                            reservacion_id: reservacion_id,
                            seat: butacas[i].value,
                            taken: 'si',
                            number_persons: numero_personas
                        }
                    }).done(function() {
                        console.log('todo bien');
                    })
        
                }
            }
            document.getElementById('mensaje').setAttribute('class','show alert alert-success alert-dismissible')
            cargarButacas()
        })
    }else{
        document.getElementById('mensaje_error').setAttribute('class','show alert alert-danger alert-dismissible')
    }
    
}