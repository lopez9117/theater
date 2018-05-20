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

        for( i = 1; i < 6; i++ ){
            contenedor.innerHTML += `<div class="row">`
            for( j = 1; j < 11; j++ ){
               
                var seat = i+"-"+j
                var taken = ""
                var clases = "available"
                response.butacas.forEach(element => {
                    if(element.seat==seat && element.taken=="si"){
                        taken = "disabled"
                        clases = "no_available"
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




function crearReservas(){
    var butacas = document.getElementsByName('butaca')
    var numero_personas = 0
    var reservacion_id = 0
    
    for( i = 0; i<butacas.length; i++ ){
        if( butacas[i].checked ){
            numero_personas += 1;
        }
    }
    if(numero_personas > 0){
        $.ajax({
            url: '/reservaciones',
            type: 'post',
            data: {
                _token: $("#token").val(),
                number_persons: numero_personas
            }
        }).done((response) => {
            console.log('id de reservacion: ' + response.reservacion.id);
            reservacion_id = response.reservacion.id
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