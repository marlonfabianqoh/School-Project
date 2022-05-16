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
        var forms = document.getElementsByClassName('grado-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-grado");
                    
                    $.ajax({
                        url: '../../index.php?c=c_grado&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./grados.php";
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

function listar_grados () {
    $('#grados .grado').remove();

    $.ajax({
        url: '../../index.php?c=c_grado&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#grados div').eq(-1).before(`
                        <div class="col-md-4 grado">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioGrados.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_grado(${element.id})"><i class="bi bi-trash"></i></button>
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
function buscar_grado (id) {
    $.ajax({
        url: '../../index.php?c=c_grado&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data = data.DATA[0];
                $('#txtName').val(data.nombre);
                $('#selCampus').val(parseInt(data.id_jornada_fk));
                listar_jornadas(data.id_sede_fk, data.id_jornada_fk);
                $('#selSession').val(parseInt(data.id_jornada_fk));
                campus = parseInt(data.id_sede_fk);
                $('#txtObservation').val(data.observacion);
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

function listar_jornadas (sede, jornada=null) {
    $('#selSession').html(`<option value="" selected>Seleccionar</option>`);
    
    if (sede != '') {
        $('#selSession').prop('disabled', false);

        $.ajax({
            url: '../../index.php?c=c_jornada&a=filtrar',
            type: 'POST',
            data: { nombre: '', sede: sede },
            success: function (result) {
                let data = JSON.parse(result);

                if(data.CODE == 1){
                    data.DATA.forEach(element => {
                        if (element.id == jornada) {
                            $('#selSession').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                        } else {
                            $('#selSession').append(`<option value="${element.id}">${element.nombre}</option>`);
                        }
                    });
                } else {
                    Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                }
            }
        });
    } else {
        $('#selSession').prop('disabled', true);
    }
}

function filtrar_grados (nombre, sede, jornada) {
    $('#grados .grado').remove();

    $.ajax({
        url: '../../index.php?c=c_grado&a=filtrar',
        type: 'POST',
        data: { nombre: nombre, sede: sede, jornada: jornada },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#grados div').eq(-1).before(`
                        <div class="col-md-4 grado">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioGrados.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_grado(${element.id})"><i class="bi bi-trash"></i></button>
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

function eliminar_grado (id) {
    Swal.fire({
        title: '¿Está seguro(a) que desea eliminar este grado?',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../index.php?c=c_grado&a=eliminar',
                type: 'POST',
                data: { id: id },
                success: function (result) {
                    let data = JSON.parse(result);
        
                    if (data.CODE == 1) {
                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                        listar_grados();
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
    $('#selSession').val('');
    listar_grados();
}