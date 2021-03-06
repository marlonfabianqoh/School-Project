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
        var forms = document.getElementsByClassName('preinscripcion-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-preinscripcion");

                    if ($('#txtPass').val() == $('#txtPassConfirm').val()) {
                        var valido = true;

                        if (documentos.length > 0) {
                            documentos.forEach((element, index) => {
                                var file = document.getElementById('txtFile'+index).files;

                                if (file.length == 0) {
                                    Toast.fire({ icon: 'warning', title: 'Debe adjuntar ' + element.nombre });
                                    valido = false;
                                }
                            });
                        }

                        if (valido) {
                            var formData = new FormData(frm[0]);
                            
                            $.ajax({
                                url: '../../index.php?c=c_matricula&a=guardar',
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (result) {
                                    let data = JSON.parse(result);
        
                                    if(data.CODE == 1){
                                        Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                        setTimeout(() => {
                                            window.location.href = "../../home.php";
                                        }, 3000);
                                    } else {
                                        Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                                    }
                                }
                            })
                        }
                    } else {
                        Toast.fire({ icon: 'warning', title: 'Las claves no coinciden' });
                    }
                }

                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('consult-validation');

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    Toast.fire({ icon: 'warning', title: 'Diligencie todos los campos antes de continuar' });
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-consult");
                    
                    $.ajax({
                        url: '../../index.php?c=c_matricula&a=consultar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.CODE == 1){
                                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                                $('#result').removeClass('d-none');
                                let info = data.DATA[0];
                                
                                switch (info.id_estado_matricula_fk) {
                                    case '1':
                                        $("#cbxPending").prop("checked", true);
                                        $("#txtObservation").val(info.observacion);
                                        break;

                                    case '2':
                                        $("#cbxPending").prop("checked", true);
                                        $("#txtObservation").val(info.observacion);
                                        break;

                                    case '3':
                                        $("#cbxAccepted").prop("checked", true);
                                        $("#txtObservation").val(info.observacion);
                                        break;

                                    case '4':
                                        $("#cbxRejected").prop("checked", true);
                                        $("#txtObservation").val(info.observacion);
                                        break;
                                
                                    default:
                                        break;
                                }
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

function listar_tipos_identificacion () {
    $.ajax({
        url: '../../index.php?c=c_general&a=listar_tipos_documento',
        type: 'POST',
        success: function (result) {
            let data = JSON.parse(result);

            if(data.CODE == 1){
                data.DATA.forEach(element => {
                    $('#selTypeId').append(`<option value="${element.id}">${element.nombre}</option>`);
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
                    $('#selDepartmentAttendant').append(`<option value="${element.id}">${element.nombre}</option>`);
                    $('#selDepartment').append(`<option value="${element.id}">${element.nombre}</option>`);
                });
            } else {
                $('#selDepartmentAttendant').append(`<option value="">Seleccionar</option>`);
                $('#selDepartment').append(`<option value="">Seleccionar</option>`);
                Toast.fire({ icon: 'error', title: data.DESCRIPTION });
            }
        }
    });
}

function listar_ciudades_acudiente (departamento) {
    $('#selCityAttendant').html(`<option value="" selected>Seleccionar</option>`);
    
    if (departamento != '') {
        $('#selCityAttendant').prop('disabled', false);

        $.ajax({
            url: '../../index.php?c=c_general&a=listar_ciudades',
            type: 'POST',
            data: { departamento: departamento },
            success: function (result) {
                let data = JSON.parse(result);

                if(data.CODE == 1){
                    data.DATA.forEach(element => {
                        $('#selCityAttendant').append(`<option value="${element.id}">${element.nombre}</option>`);
                    });
                } else {
                    Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                }
            }
        });
    } else {
        $('#selCityAttendant').prop('disabled', true);
    }
}

function listar_ciudades (departamento) {
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
                        $('#selCity').append(`<option value="${element.id}">${element.nombre}</option>`);
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
                    $('#selGender').append(`<option value="${element.id}">${element.nombre}</option>`);
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
                    $('#selTypeBlood').append(`<option value="${element.id}">${element.nombre}</option>`);
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
                    $('#selPreference').append(`<option value="${element.id}">${element.nombre}</option>`);
                });
            } else {
                $('#selPreference').append(`<option value="">Seleccionar</option>`);
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

function listar_sedes (anio) {
    $('#selCampus').html(`<option value="" selected>Seleccionar</option>`);
    $('#selSession').html(`<option value="" selected>Seleccionar</option>`);
    $('#selSession').html(`<option value="" selected>Seleccionar</option>`);
    $('#selSession').prop('disabled', true);
    $('#selGrade').html(`<option value="" selected>Seleccionar</option>`);
    $('#selGrade').prop('disabled', true);

    if (anio != '') {
        $('#selCampus').prop('disabled', false);

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
                    Toast.fire({ icon: 'error', title: data.DESCRIPTION });
                }
            }
        });
    }
}

function listar_jornadas (sede) {
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
                        $('#selSession').append(`<option value="${element.id}">${element.nombre}</option>`);
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

function listar_grados (jornada) {
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
                        $('#selGrade').append(`<option value="${element.id}">${element.nombre}</option>`);
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

var documentos = [];
var tipo_documentos = [];
function listar_documentos (anio) {
    $('#documentos').html('');
    documentos = [];
    tipo_documentos = [];

    $.ajax({
        url: '../../index.php?c=c_documento&a=listar',
        type: 'POST',
        data: { anio: anio },
        success: function (result) {
            let data = JSON.parse(result);

            if (data.CODE == 1) {
                documentos = data.DATA;
                data.DATA.forEach((element, index) => {
                    tipo_documentos.push(element.id);
                    $('#documentos').append(`
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtFile${index}" class="form-label">${element.nombre}:</label>
                                <input type="file" id="txtFile${index}" name="txtFile${index}" onchange="changeFile(${index})" hidden />
                                <button type="button" class="form-control btn btn-success" onclick="selectFile(${index})">
                                    <i class="bi bi-clip"></i>
                                    Adjuntar
                                </button>
                                <label id="lblFile${index}" class="form-label"></label>
                            </div>
                        </div>
                    `);
                });
                $("#tipo_documentos").val(tipo_documentos);
            }
        }
    });
}

function selectFile (index) {
    document.getElementById("txtFile"+index).click();
}

function changeFile (index) {
    let file = document.getElementById("txtFile"+index);

    if (file.files.length > 0) {
        let name = file.files[0].name
        document.getElementById("lblFile"+index).innerHTML = name;
    } else {
        document.getElementById("lblFile"+index).value = "";
        document.getElementById("txtFile"+index).value = '';
    }
}
