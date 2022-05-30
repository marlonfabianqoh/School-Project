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
        var forms = document.getElementsByClassName('anualidad-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-anualidad");

                    $.ajax({
                        url: '../../index.php?c=c_parametro&a=guardar_anualidad',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                setTimeout(() => {
                                    window.location.href = "parametros.php";
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

(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('parametro-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-parametro");

                    $.ajax({
                        url: '../../index.php?c=c_parametro&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                buscar_parametro($('#selYear').val());
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

(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('documento-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-documento");

                    $.ajax({
                        url: '../../index.php?c=c_documento&a=guardar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                listar_documentos($('#selYear').val());
                                limpiar_modal();
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

function buscar_parametro (anio) {
    $.ajax({
        url: '../../index.php?c=c_parametro&a=buscar',
        type: 'POST',
        data: { anio: anio },
        success: function (result) {
            $('#result').removeClass('d-none');
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                
                if (data.DATA.length > 0) {
                    data = data.DATA[0];
                    $("#id").val(data.id);
                    $("#txtCourse").val(data.cantidad_cursos);
                    $("#txtStudent").val(data.cantidad_estudiantes);
                }
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

function listar_documentos (anio) {
    $('#documentos table tbody').html('');

    $.ajax({
        url: '../../index.php?c=c_documento&a=listar',
        type: 'POST',
        data: { anio: anio },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                data.DATA.forEach(element => {
                    $('#documentos table tbody').append(`
                        <tr>
                            <td>${element.nombre}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDocument" onclick="buscar_documento(${element.id});"><i class="bi bi-pencil"></i></button>
                                <button type="button" class="btn btn-danger" onclick="eliminar_documento(${element.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `);
                });
            }
        }
    });
}

function buscar_documento (id) {
    $.ajax({
        url: '../../index.php?c=c_documento&a=buscar',
        type: 'POST',
        data: { id: id },
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data = data.DATA[0];
                $('#id_document').val(data.id);
                $('#txtName').val(data.nombre);
                $('#anio_document').val(data.anio);
            } else {
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function eliminar_documento (id) {
    Swal.fire({
        title: '¿Está seguro(a) que desea eliminar este documento?',
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../index.php?c=c_documento&a=eliminar',
                type: 'POST',
                data: { id: id },
                success: function (result) {
                    let data = JSON.parse(result);
        
                    if (data.CODE == 1) {
                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                        listar_documentos($('#selYear').val());
                    } else {
                        Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                    }
                }
            });
        }
    })
}

function limpiar_modal () {
    $('#id_document').val('');
    $('#anio_document').val('');
    $('#txtName').val('');
    $('#modalDocument').modal('toggle');
}