toastr.options.progressBar = true;
toastr.options.closeDuration = 500;
toastr.options.closeButton = true;

// VALIDACIÓN DEL FORMULARIO LOGIN
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('login-validation');
        var tag = $("body").attr("tag");

        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity() === false){
                    toastr.warning("Campos imcompletos")
                }
                else if(form.checkValidity() === true){
                    var frm = $("#form-login");

                    $.ajax({
                        url: tag+'controllers/c_index.php',
                        type: "POST",
                        data: frm.serialize(),
                        success:function(result){
                            let data = JSON.parse(result);

                            if(data.STATUS){
                                toastr.success(data.MESSAGE)
                                window.location.href = "views/home.php"
                            } else {
                                toastr.error(data.MESSAGE)
                            }
                        }
                    })
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();