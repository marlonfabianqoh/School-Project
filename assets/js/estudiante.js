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
        var forms = document.getElementsByClassName('observacion-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-observacion");
                    
                    $.ajax({
                        url: '../../index.php?c=c_estudiante&a=observar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./estudiantes.php";
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

function listar_estudiantes () {
    $('#estudiantes .table tbody tr').remove();

    $.ajax({
        url: '../../index.php?c=c_estudiante&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#estudiantes table tbody').append(`
                        <tr>
                            <td>${element.nombre_aspirante}</td>
                            <td>${element.nombre_sede}</td>
                            <td>${element.nombre_jornada}</td>
                            <td>${element.nombre_grado}</td>
                            <td>${element.nombre_curso}</td>
                            <td class="text-end">
                                <a href="./observacion.php?id=${element.id}" class="btn btn-light">Ver / Evaluar</a>
                            </td>
                        </tr>
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
var course = '';

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

function listar_jornadas_filtro (sede, jornada=null) {
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

function listar_grados_filtro (jornada, grado=null) {
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

function filtrar_estudiantes (sede, jornada, grado) {
    $('#estudiantes .table tbody tr').remove();

    $.ajax({
        url: '../../index.php?c=c_estudiante&a=filtrar',
        type: 'POST',
        data: { sede: sede, jornada: jornada, grado: grado },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#estudiantes table tbody').append(`
                        <tr>
                            <td>${element.nombre_aspirante}</td>
                            <td>${element.nombre_sede}</td>
                            <td>${element.nombre_jornada}</td>
                            <td>${element.nombre_grado}</td>
                            <td>${element.nombre_curso}</td>
                            <td class="text-end">
                                <a href="./observacion.php?id=${element.id}" class="btn btn-light">Ver / Evaluar</a>
                            </td>
                        </tr>
                    `);
                });
            } else {
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}