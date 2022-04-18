toastr.options.timeOut = 5000;
toastr.options.closeButton = true;

// VALIDACIÓN DEL FORMULARIO LOGIN
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('login-validation');
        var tag = $("body").attr("tag");

        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    toastr.warning("Diligencie todos los campos antes de continuar");
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-login");

                    $.ajax({
                        url: tag+'controllers/c_index.php',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if (data.STATUS) {
                                toastr.success(data.MESSAGE, { timeOut: 3000 });
                                setTimeout(() => {
                                    window.location.href = "views/home.php";
                                }, 3000);
                            } else {
                                toastr.error(data.MESSAGE);
                            }
                        }
                    })
                }

                form.classList.add('was-validated');
            }, false);
        });
        
    }, false);
})();

// VALIDACIÓN DEL FORMULARIO SEDE
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('sede-validation');
        var tag = $("body").attr("tag");
        
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false) {
                    toastr.warning("Diligencie todos los campos antes de continuar");
                }
                else if (form.checkValidity() === true) {
                    var frm = $("#form-sede");
                    
                    $.ajax({
                        url: '../../controllers/c_sede.php',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if(data.STATUS){
                                toastr.success(data.MESSAGE, {timeOut: 3000});
                                setTimeout(() => {
                                    window.location.href = "./adminSedes.php";
                                }, 3000);
                            } else {
                                toastr.error(data.MESSAGE);
                            }
                        }
                    })
                }

                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();