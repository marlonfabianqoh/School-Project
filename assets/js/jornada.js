const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

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
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
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
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./jornadas.php";
                                }, 3000);
                            } else {
                                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
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
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

var campus = '';
var user = '';
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
                campus = parseInt(data.id_sede_fk);
                $('#selUser').val(parseInt(data.id_detalle_usuario_fk));
                user = parseInt(data.id_detalle_usuario_fk);
            } else {
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
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
                    if (element.id == campus) {
                        $('#selCampus').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selCampus').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selCampus').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_coordinadores () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_coordinadores',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == campus) {
                        $('#selUser').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selUser').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selUser').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
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
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function eliminar_jornada (id) {
    Swal.fire({
        title: '¿Está seguro(a) que desea eliminar esta sede?',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../index.php?c=c_jornada&a=eliminar',
                type: 'POST',
                data: { id: id },
                success: function (result) {
                    let data = JSON.parse(result);

                    if (data.CODE == 1) {
                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                        listar_jornadas();
                    } else {
                        Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                    }
                }
            });
        }
    })
}

function limpiar () {
    $('#txtName').val('');
    $('#selCampus').val('');
    listar_jornadas();
}