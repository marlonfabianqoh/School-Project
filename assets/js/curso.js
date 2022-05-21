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
        var forms = document.getElementsByClassName('curso-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-curso");
                    
                    $.ajax({
                        url: '../../index.php?c=c_curso&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./cursos.php";
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

function listar_cursos () {
    $('#cursos .curso').remove();

    $.ajax({
        url: '../../index.php?c=c_curso&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#cursos div').eq(-1).before(`
                        <div class="col-md-4 curso">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioCursos.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_curso(${element.id})"><i class="bi bi-trash"></i></button>
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
var session = '';
var grade = '';
function buscar_curso (id) {
    $.ajax({
        url: '../../index.php?c=c_curso&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data = data.DATA[0];
                $('#txtName').val(data.nombre);
                $('#selYear').val(parseInt(data.anio));
                $('#selCampus').val(parseInt(data.id_sede_fk));
                campus = parseInt(data.id_sede_fk);
                listar_jornadas(data.id_sede_fk, data.id_jornada_fk);
                $('#selSession').val(parseInt(data.id_jornada_fk));
                listar_grados(data.id_jornada_fk, data.id_grado_fk);
                $('#selGrade').val(parseInt(data.id_grado_fk));
                $('#txtObservation').val(data.observacion);
            } else {
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_anualidades () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_anualidades',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    $('#selYear').append(`<option value="${element.id}">${element.anio}</option>`);
                });
            } else {
                $('#selYear').append(`<option value="">Seleccionar</option>`);
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
    $('#selGrade').html(`<option value="" selected>Seleccionar</option>`);
    $('#selGrade').prop('disabled', true);
    
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
                        if (element.id == session || element.id == jornada) {
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

function listar_grados (jornada, grado=null) {
    $('#selGrade').html(`<option value="" selected>Seleccionar</option>`);
    
    if (jornada != '') {
        $('#selGrade').prop('disabled', false);

        $.ajax({
            url: '../../index.php?c=c_grado&a=filtrar',
            type: 'POST',
            data: { nombre: '', sede: '', jornada: jornada },
            success: function (result) {
                let data = JSON.parse(result);

                if(data.CODE == 1){
                    data.DATA.forEach(element => {
                        if (element.id == grade || element.id == grado) {
                            $('#selGrade').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                        } else {
                            $('#selGrade').append(`<option value="${element.id}">${element.nombre}</option>`);
                        }
                    });
                } else {
                    Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                }
            }
        });
    } else {
        $('#selGrade').prop('disabled', true);
    }
}

function filtrar_cursos (anio, nombre, sede, jornada, grado) {
    $('#cursos .curso').remove();

    $.ajax({
        url: '../../index.php?c=c_curso&a=filtrar',
        type: 'POST',
        data: { anio: anio, nombre: nombre, sede: sede, jornada: jornada, grado: grado },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#cursos div').eq(-1).before(`
                        <div class="col-md-4 curso">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioCursos.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_curso(${element.id})"><i class="bi bi-trash"></i></button>
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

function eliminar_curso (id) {
    Swal.fire({
        title: '¿Está seguro(a) que desea eliminar este curso?',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../index.php?c=c_curso&a=eliminar',
                type: 'POST',
                data: { id: id },
                success: function (result) {
                    let data = JSON.parse(result);
        
                    if (data.CODE == 1) {
                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                        listar_cursos();
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
    $('#selYear').val('');
    $('#selCampus').val('');
    $('#selSession').val('');
    $('#selGrade').val('');
    listar_cursos();
}