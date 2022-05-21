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
            let data = JSON.parse(result);

            if(data.CODE == 1){
                Toast.fire({ icon: 'success', title: data.DESCRIPTION });
                $('#result').removeClass('d-none');
                data = data.DATA[0];
                console.log(data);
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
