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
        var forms = document.getElementsByClassName('usuario-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-usuario");
                    
                    $.ajax({
                        url: '../../index.php?c=c_usuario&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./usuarios.php";
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

function listar_usuarios () {
    $('#usuarios .table tbody tr').remove();

    $.ajax({
        url: '../../index.php?c=c_usuario&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#usuarios table tbody').append(`
                        <tr>
                            <td>${element.usuario}</td>
                            <td>${element.nombres} ${element.apellidos}</td>
                            <td>${element.nombre_rol}</td>
                            <td>${element.nombre_estado}</td>
                            <td class="text-end">
                                <a href="./formularioUsuarios.php?id=${element.id}" class="btn btn-light">Ver / Editar</a>
                                <button type="button" class="btn btn-danger" onclick="eliminar_usuario(${element.id})"><i class="bi bi-trash"></i></button>
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

var role = '';
var state = '';
var typeId = '';
var department = '';
var gender = '';
var typeBlood = '';
var preference = '';
function buscar_usuario (id) {
    $.ajax({
        url: '../../index.php?c=c_usuario&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                console.log(data.DATA[0]);
                data = data.DATA[0];
                $('#txtUser').val(data.usuario);
                $('#selRole').val(data.id_rol_fk);
                role = parseInt(data.id_rol_fk);
                $('#selStatus').val(data.id_estado_usuario_fk);
                state = parseInt(data.id_estado_usuario_fk);
                $('#selTypeId').val(data.id_tipo_documento_fk);
                typeId = parseInt(data.id_tipo_documento_fk);
                $('#txtId').val(parseInt(data.documento));
                $('#txtName').val(data.nombres);
                $('#txtLastName').val(data.apellidos);
                $('#txtDate').val(data.fecha_nacimiento);
                $('#txtEmail').val(data.correo);
                $('#txtPhone').val(parseInt(data.telefono));
                $('#txtMobile').val(parseInt(data.celular));
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
                $('#txtObservation').val(data.observacion);
            } else {
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_roles () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_roles',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == role) {
                        $('#selRole').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
                        $('#selRole').append(`<option value="${element.id}">${element.nombre}</option>`);
                    }
                });
            } else {
                $('#selRole').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_estados_usuario () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_estados_usuario',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    if (element.id == state) {
                        $('#selStatus').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                    } else {
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
        $('#selCity').prop('disabled', false);

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
    } else {
        $('#selCity').prop('disabled', true);
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

function filtrar_usuarios (usuario, nombre, rol, estado) {
    $('#usuarios .table tbody tr').remove();

    $.ajax({
        url: '../../index.php?c=c_usuario&a=filtrar',
        type: 'POST',
        data: { usuario: usuario, nombre: nombre, rol: rol, estado: estado },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#usuarios table tbody').append(`
                        <tr>
                            <td>${element.usuario}</td>
                            <td>${element.nombres} ${element.apellidos}</td>
                            <td>${element.nombre_rol}</td>
                            <td>${element.nombre_estado}</td>
                            <td class="text-end">
                                <a href="./formularioUsuarios.php?id=${element.id}" class="btn btn-light">Ver / Editar</a>
                                <button type="button" class="btn btn-danger" onclick="eliminar_usuario(${element.id})"><i class="bi bi-trash"></i></button>
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

function eliminar_usuario (id) {
    Swal.fire({
        title: '¿Está seguro(a) que desea eliminar este usuario?',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../index.php?c=c_usuario&a=eliminar',
                type: 'POST',
                data: { id: id },
                success: function (result) {
                    let data = JSON.parse(result);
        
                    if (data.CODE == 1) {
                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                        listar_usuarios();
                    } else {
                        Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                    }
                }
            });
        }
    })
}

function limpiar () {
    $('#txtUser').val('');
    $('#txtName').val('');
    $('#selRole').val('');
    $('#selStatus').val('');
    listar_usuarios();
}