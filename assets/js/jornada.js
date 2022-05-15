toastr.options.timeOut = 5000;
toastr.options.closeButton = true;

(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('jornada-validation');
        var tag = $("body").attr("tag");
        
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    toastr.warning("Diligencie todos los campos antes de continuar");
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-jornada");
                    
                    $.ajax({
                        url: '../../index.php?c=c_jornada&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                toastr.success(data.DESCRIPTION, {timeOut: 3000});
                                setTimeout(() => {
                                    window.location.href = "./adminJornadas.php";
                                }, 3000);
                            } else {
                                toastr.error(data.DESCRIPTION);
                            }
                        }
                    })
                }

                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function listar_jornadas () {
    $('#jornadas .jornada').remove();

    $.ajax({
        url: '../../index.php?c=c_jornada&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#jornadas div').eq(-1).before(`
                        <div class="col-md-4 jornada">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioJornadas.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_jornada(${element.id})"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                toastr.error(data.DESCRIPTION);
            }
        }
    });
}

function buscar_jornada (id) {
    $.ajax({
        url: '../../index.php?c=c_jornada&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data = data.DATA[0];
                $('#txtName').val(data.nombre);
                $('#txtObservation').val(data.observacion);
                $('#selCampus').val(parseInt(data.id_sede_fk));
            } else {
                toastr.error(data.DESCRIPTION);
            }
        }
    });
}

function listar_sedes () {
    $.ajax({
        url: '../../index.php?c=c_sede&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    $('#selCampus').append(`<option value="${element.id}">${element.nombre}</option>`);
                });
            } else {
                $('#selCampus').append(`<option value="">Seleccionar</option>`);
                toastr.error(data.DESCRIPTION);
            }
        }
    });
}

function filtrar_jornadas (nombre, sede) {
    $('#jornadas .jornada').remove();

    $.ajax({
        url: '../../index.php?c=c_jornada&a=filtrar',
        type: 'POST',
        data: { nombre: nombre, sede: sede },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#jornadas div').eq(-1).before(`
                        <div class="col-md-4 jornada">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioJornadas.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_jornada(${element.id})"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                toastr.error(data.DESCRIPTION);
            }
        }
    });
}

function eliminar_jornada (id) {
    toastr.warning("<button type='button' id='confirmation' class='btn btn-secondary mt-2'>Si</button>",'¿Está seguro(a) que desea eliminar esta jornada?', {
        closeButton: false,
        allowHtml: true,
        timeOut: 0,
        extendedTimeOut: 0,
        onShown: function (toast) {
            $("#confirmation").click(function(){
                $.ajax({
                    url: '../../index.php?c=c_jornada&a=eliminar',
                    type: 'POST',
                    data: { id: id },
                    success: function (result) {
                        let data = JSON.parse(result);
    
                        if (data.CODE == 1) {
                            toastr.success(data.DESCRIPTION, { timeOut: 3000 });
                            listar_jornadas();
                        } else {
                            toastr.error(data.DESCRIPTION);
                        }
                    }
                });
            });
        }
    });
}

function limpiar () {
    $('#txtName').val('');
    $('#selCampus').val('');
    listar_jornadas();
}