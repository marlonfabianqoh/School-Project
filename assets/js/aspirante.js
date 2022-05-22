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
                        url: '../../index.php?c=c_aspirante&a=observar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./aspirantes.php";
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

function validarNumeros (evt) {
    let keyCode = evt.keyCode ? evt.keyCode : evt.which;

    if (keyCode < 48 || keyCode > 57) {
        evt.preventDefault();
    }
}

function listar_aspirantes () {
    $('#aspirantes .table tbody tr').remove();

    $.ajax({
        url: '../../index.php?c=c_aspirante&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#aspirantes table tbody').append(`
                        <tr>
                            <td>${element.nombre_aspirante}</td>
                            <td>${element.nombre_sede}</td>
                            <td>${element.nombre_jornada}</td>
                            <td>${element.nombre_grado}</td>
                            <td>${element.nombre_estado}</td>
                            <td>${element.fecha}</td>
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

var typeId = '';
var department = '';
var gender = '';
var typeBlood = '';
var preference = '';
var campus = '';
var session = '';
var grade = '';
function buscar_aspirante (id) {
    $.ajax({
        url: '../../index.php?c=c_aspirante&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data = data.DATA[0];
                $('#selTypeId').val(data.id_tipo_documento_fk);
                typeId = parseInt(data.id_tipo_documento_fk);
                $('#txtId').val(parseInt(data.documento));
                $('#txtName').val(data.nombres);
                $('#txtLastName').val(data.apellidos);
                $('#txtDate').val(data.fecha_nacimiento);
                $('#txtEmail').val(data.correo);
                $('#txtPhone').val(data.telefono);
                $('#txtMobile').val(data.celular);
                $('#selDepartment').val(parseInt(data.id_departamento_fk));
                department = parseInt(data.id_departamento_fk);
                listar_ciudades(data.id_departamento_fk, data.id_ciudad_fk);
                $('#selCity').val(parseInt(data.id_ciudad_fk));
                $('#txtAddress').val(data.direccion);
                $('#selGender').val(data.id_genero_fk);
                gender = parseInt(data.id_genero_fk);
                $('#selTypeBlood').val(data.id_tipo_sangre_fk);
                typeBlood = parseInt(data.id_tipo_sangre_fk);
                $('#selPreference').val(data.id_preferencia_fk);
                preference = parseInt(data.id_preferencia_fk);
                $('#txtObservationn').val(data.observacionn);
                $('#selYear').val(parseInt(data.anio));
                $('#selCampus').val(parseInt(data.id_sede_fk));
                campus = parseInt(data.id_sede_fk);
                listar_jornadas(data.id_sede_fk, data.id_jornada_fk);
                $('#selSession').val(parseInt(data.id_jornada_fk));
                listar_grados(data.id_jornada_fk, data.id_grado_fk);
                $('#selGrade').val(parseInt(data.id_grado_fk));
                $('#txtObservation').val(data.observacion);
                $('#cbxStatus').val(data.id_estado_matricula_fk);
                if (data.id_estado_matricula_fk == 2) {
                    $('#cbxAccepted').prop('checked', true);
                } else if (data.id_estado_matricula_fk == 4) {
                    $('#cbxRehected').prop('checked', true);
                }
                console.log(data.documentos)
                if (data.documentos != '') {
                    var documentos = data.documentos.split(',');
                    console.log(documentos)

                    documentos.forEach(element => {
                        document.getElementById('modal-body').innerHTML += `<iframe style="width:100%;height:600px;" src="http://localhost/School-Project/files/${element}"></iframe>`;

                    });
                }
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

function listar_jornadas (sede, jornada=null) {
    $('#selSession').html(`<option value="" selected>Seleccionar</option>`);
    $('#selGrade').html(`<option value="" selected>Seleccionar</option>`);
    
    if (sede != '') {
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
    }
}

function listar_grados (jornada, grado=null) {
    $('#selGrade').html(`<option value="" selected>Seleccionar</option>`);
    
    if (jornada != '') {
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
    }
}

function listar_estados_matricula () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_estados_matricula',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == 1 || element.id == 2) {
                        $('#selStatus').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selStatus').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_tipos_identificacion () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_tipos_documento',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == typeId) {
                        $('#selTypeId').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selTypeId').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selTypeId').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_departamentos () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_departamentos',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == department) {
                        $('#selDepartment').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selDepartment').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selDepartment').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_ciudades (departamento, ciudad=null) {
    $('#selCity').html(`<option value="" selected>Seleccionar</option>`);
    
    if (departamento != '') {
        $.ajax({
            url: '../../index.php?c=c_general&a=listar_ciudades',
            type: 'POST',
            data: { departamento: departamento },
            success: function (result) {
                let data = JSON.parse(result);

                if(data.CODE == 1){
                    data.DATA.forEach(element => {
                        if (element.id == ciudad) {
                            $('#selCity').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                        } else {
                            $('#selCity').append(`<option value="${element.id}">${element.nombre}</option>`);
                        }
                    });
                } else {
                    Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                }
            }
        });
    }
}

function listar_generos () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_generos',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == gender) {
                        $('#selGender').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selGender').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selGender').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_tipos_sangre () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_tipos_sangre',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == typeBlood) {
                        $('#selTypeBlood').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selTypeBlood').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selTypeBlood').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_preferencias () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_preferencias',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == preference) {
                        $('#selPreference').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selPreference').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selPreference').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function filtrar_aspirantes (anio, sede, jornada, grado, estado) {
    $('#aspirantes .table tbody tr').remove();

    $.ajax({
        url: '../../index.php?c=c_aspirante&a=filtrar',
        type: 'POST',
        data: { anio: anio, sede: sede, jornada: jornada, grado: grado, estado: estado },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#aspirantes table tbody').append(`
                        <tr>
                            <td>${element.nombre_aspirante}</td>
                            <td>${element.nombre_sede}</td>
                            <td>${element.nombre_jornada}</td>
                            <td>${element.nombre_grado}</td>
                            <td>${element.nombre_estado}</td>
                            <td>${element.fecha}</td>
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

function limpiar () {
    $('#selYear').val('');
    $('#selCampus').val('');
    $('#selSession').val('');
    $('#selGrade').val('');
    $('#selState').val('');
    listar_aspirantes();
}