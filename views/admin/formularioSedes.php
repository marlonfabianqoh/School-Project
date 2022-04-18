<?php
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['rol'] != '1') {
        header("Location: ../../index.php");
    } else {
        $option = 1;

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $params = parse_url($url);
        if (isset($params['query'])) {
            parse_str($params['query'], $params);

            if (isset($params['id'])) {
                $option = 2;
            }
        }
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- CSS Custom -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>School Project</title>
</head>

<body tag="">
    <main class="content">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="/views/visitor/home.html">School Project</a>
                <div>
                    <a href="/views/secretary/dashboard.html">
                        <button type="button" class="btn btn-light">Secretaria</button>
                    </a>
                    <a href="userList.html">
                        <button type="button" class="btn btn-light">Ingresar</button>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <h1>Formulario de sedes</h1>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col">
                    <form id="form-sede" class="row sede-validation" method="POST" novalidate>
                        <input type="text" id="option" name="option" value="<?php if ($option == 1) { echo 'sedes-crear'; } else { echo 'sedes-editar'; } ?>" hidden>
                        <input type="text" id="id" name="id" value="<?php if (isset($params['id'])) { echo $params['id']; } else { echo ''; } ?>" hidden>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="txtName" name="txtName" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="txtAddress" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="txtAddress" name="txtAddress" required>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="txtPhone" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="txtPhone" name="txtPhone" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="selDepartment" class="form-label">Departamento</label>
                                <select class="form-select" id="selDepartment" name="selDepartment" onchange="ciudades(selDepartment.value)" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="selCity" class="form-label">Ciudad</label>
                                <select class="form-select" id="selCity" name="selCity" disabled required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="txtObservation" class="form-label">Observaciones</label>
                                <textarea class="form-control" cols="30" rows="5" id="txtObservation" name="txtObservation"></textarea>
                            </div>
                        </div>
                    
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="./adminSedes.php">
                                <button type="button" class="btn btn-outline-secondary">Cancelar</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="container mt-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top">
                <div class="col d-flex align-items-center">
                    <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                        <svg class="bi" width="30" height="24">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                    </a>
                    <span class="text-muted">© 2022 School Project -- Marlon Garcia -- Carlos Rueda</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
                </ul>
            </div>
        </footer>
    </main>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="../../assets/js/validation.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <script type="text/javascript">
        // FUNCION QUE CARGA LA SEDE AL EDITAR
        $(document).ready(async function () {
            let department = '';

            <?php 
                if (isset($params['id'])) { 
            ?>

            const result1 = await $.ajax({
                url: '../../controllers/c_sede.php',
                type: 'POST',
                data: { option: 'sedes-listar', id: <?php echo $params['id']; ?> },
                success: function (result) {
                    let data = JSON.parse(result);

                    if(data.STATUS){
                        data = data.DATA[0];
                        console.log(data);
                        $('#txtName').val(data.nombre);
                        $('#txtAddress').val(data.direccion);
                        $('#txtPhone').val(data.telefono);
                        $('#selDepartment').val(parseInt(data.id_departamento_fk));
                        ciudades(data.id_departamento_fk, data.id_ciudad_fk);
                        $('#selCity').val(parseInt(data.id_ciudad_fk));
                        department = parseInt(data.id_departamento_fk);
                        $('#txtObservation').val(data.observacion);
                    } else {
                        toastr.error(data.MESSAGE);
                    }
                }
            });

            <?php 
                }
            ?>

            console.log(department);

            // FUNCION QUE CARGA LOS DEPARTAMENTOS
            const result2 = await $.ajax({
                url: '../../controllers/c_principal.php',
                type: 'POST',
                data: { option: 'departamentos-listar' },
                success: function (result) {
                    let data = JSON.parse(result);

                    if(data.STATUS){
                        $('#selDepartment').html('<option value="" selected disabled>Seleccionar</option>');

                        data.DATA.forEach(element => {
                            if (element.id == department) {
                                $('#selDepartment').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                            } else {
                                $('#selDepartment').append(`<option value="${element.id}">${element.nombre}</option>`);
                            }
                        });
                    } else {
                        toastr.error(data.MESSAGE);
                    }
                }
            });
        });

        function ciudades (departamento, ciudad=null) {
            $.ajax({
                url: '../../controllers/c_principal.php',
                type: 'POST',
                data: { option: 'ciudades-listar', departamento: departamento },
                success: function (result) {
                    let data = JSON.parse(result);
                    
                    if(data.STATUS){
                        $('#selCity').html('<option value="" selected disabled>Seleccionar</option>');
                        data.DATA.forEach(element => {
                            if (element.id == ciudad) {
                                $('#selCity').append(`<option value="${element.id}" selected>${element.nombre}</option>`);
                            } else {
                                $('#selCity').append(`<option value="${element.id}">${element.nombre}</option>`);
                            }
                            
                            $('#selCity').prop('disabled', false);
                        });
                    } else {
                        toastr.error(data.MESSAGE);
                    }
                }
            });
        }
    </script>
</body>
</html>

<?php 
    }
?>