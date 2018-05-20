var contenedor = document.getElementById('butacas');

for( i = 0; i < 5; i++ ){
    contenedor.innerHTML += `<div class="row">`
    for( j = 0; j < 10; j++ ){
        // contenedor.innerHTML += '<input type="text" value="'+(i+1)+','+(j+1)+'">'
        contenedor.innerHTML += 
        `<div class="col-md-1">
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" value="${i}-${j}" name="butaca">
                </span>
                <input type="text" class="form-control" value="${i}-${j}" disabled>
            </div>
        </div>`

    }
    contenedor.innerHTML += `</div>`
}
function crearReservas(){
    var butacas = document.getElementsByName('butaca')
    var butacas_reservadas = []
    for( i = 0; i<butacas.length; i++ ){
        if( butacas[i].checked ){
            console.log(butacas[i].value)
            $.ajax({
                url: 'butacas',
                type: 'post',
                data: {
                    _token: $("#token").val(),
                    seat: butacas[i].value,
                    taken: 'si'
                }
            })
        }
    }
}