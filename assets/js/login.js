toastr.options.timeOut = 5000;
toastr.options.closeButton = true;

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
                        url: 'index.php?c=c_login&a=ingresar',
                        type: "POST",
                        data: frm.serialize(),
                        success: function (result) {
                            let data = JSON.parse(result);

                            if (data.CODE == 1) {
                                toastr.success(data.DESCRIPTION, { timeOut: 3000 });
                                setTimeout(() => {
                                    window.location.href = "views/home.php";
                                }, 3000);
                            } else {
                                toastr.error(data.DESCRIPTION);
                            }
                        }
                    })
                }

                form.classList.add('was-validated');
            }, false);
        });
        
    }, false);
})();