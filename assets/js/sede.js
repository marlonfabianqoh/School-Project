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
        var forms = document.getElementsByClassName('sede-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-sede");
                    
                    $.ajax({
                        url: '../../index.php?c=c_sede&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "./adminSedes.php";
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

function listar_sedes () {
    $('#sedes .sede').remove();

    $.ajax({
        url: '../../index.php?c=c_sede&a=listar',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#sedes div').eq(-1).before(`
                        <div class="col-md-4 sede">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioSedes.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_sede(${element.id})"><i class="bi bi-trash"></i></button>
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

function buscar_sede (id) {
    $.ajax({
        url: '../../index.php?c=c_sede&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data = data.DATA[0];
                $('#txtName').val(data.nombre);
                $('#txtAddress').val(data.direccion);
                $('#txtPhone').val(data.telefono);
                $('#selDepartment').val(parseInt(data.id_departamento_fk));
                listar_ciudades(data.id_departamento_fk, data.id_ciudad_fk);
                $('#selCity').val(parseInt(data.id_ciudad_fk));
                department = parseInt(data.id_departamento_fk);
                $('#txtObservation').val(data.observacion);
            } else {
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
                    $('#selDepartment').append(`<option value="${element.id}">${element.nombre}</option>`);
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

function filtrar_sedes (nombre, departamento, ciudad) {
    $('#sedes .sede').remove();

    $.ajax({
        url: '../../index.php?c=c_sede&a=filtrar',
        type: 'POST',
        data: { nombre: nombre, departamento: departamento, ciudad: ciudad },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#sedes div').eq(-1).before(`
                        <div class="col-md-4 sede">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${element.nombre}</h5>
                                    <p class="card-text text-secondary">${element.observacion}</p>
                                    <a href="./formularioSedes.php?id=${element.id}"><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger" onclick="eliminar_sede(${element.id})"><i class="bi bi-trash"></i></button>
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

function eliminar_sede (id) {
    Swal.fire({
        title: '¿Está seguro(a) que desea eliminar esta sede?',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../index.php?c=c_sede&a=eliminar',
                type: 'POST',
                data: { id: id },
                success: function (result) {
                    let data = JSON.parse(result);
        
                    if (data.CODE == 1) {
                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                        listar_sedes();
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
    $('#selDepartment').val('');
    $('#selCity').val('');
    listar_sedes();
}