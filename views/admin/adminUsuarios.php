<?php
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['rol'] != '1') {
        header("Location: ../index.php");
    } else {
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
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>School Project</title>
</head>

<body>
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
                    <h1>Administrador de Usuarios</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <legend class="mt-5">Filtro de busqueda</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtNames" class="form-label">Nombres del usuario:</label>
                                <input type="text" class="form-control" id="txtNames" name="txtNames">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtLastNames" class="form-label">Apellidos del usuario:</label>
                                <input type="text" class="form-control" id="txtLastNames" name="txtLastNames">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtIdentification" class="form-label">Identificacion del usuario:</label>
                                <input type="number" class="form-control" id="txtIdentification" name="txtIdentification">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtEmail" class="form-label">Email del usuario:</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success" onclick="buscar()">
                            <i class="bi bi-search"></i>
                            Filtrar
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="limpiar()">Limpiar</button>
                    </div>
                </div>
            </div>

            <div id="usuarios" class="row mt-5">
                <div class="col-md-6">
                    <a href="./formularioUsuarios.php">
                        <button type="button" class="btn btn-success">
                            <i class="bi bi-plus"></i>
                            Nuevo Usuario
                        </button>
                    </a>
                </div>

                <div class="col-12">
                    <table class="table mt-5">
                        <thead>
                            <tr>
                                <th scope="col">Nombre Completo</th>
                                <th scope="col">Email</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Ultima Conexión</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
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
        // FUNCION QUE CARGA LOS USUARIOS
        $(document).ready(function () {
            $.ajax({
                url: '../../controllers/c_usuario.php',
                type: 'POST',
                data: { option: 'usuarios-listar'},
                success: function (result) {
                    let data = JSON.parse(result);

                    if (data.STATUS) {
                        data.DATA.forEach(element => {
                            $('#usuarios table tbody').append(`
                                <tr>
                                    <td>${element.nombres} ${element.apellidos}</td>
                                    <td>${element.correo}</td>
                                    <td>${element.celular}</td>
                                    <td>${element.nombre_rol}</td>
                                    <td>${element.fecha_conexion}</td>
                                    <td class="text-end">
                                        <a href="./formularioUsuarios.php?id=${element.id}" class="btn btn-light">Ver / Editar</a>
                                        <button type="button" class="btn btn-danger" onclick="eliminar(${element.id})"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        toastr.error(data.MESSAGE);
                    }
                }
            });
        });

        function buscar () {
            let nombres = $('#txtNames').val();
            let apellidos = $('#txtLastNames').val();
            let documento = $('#txtIdentification').val();
            let correo = $('#txtEmail').val();

            $.ajax({
                url: '../../controllers/c_usuario.php',
                type: 'POST',
                data: { option: 'usuarios-buscar', nombres: nombres, apellidos: apellidos, documento: documento, correo: correo },
                success: function (result) {
                    let data = JSON.parse(result);

                    if (data.STATUS) {
                        $('#usuarios .usuario').remove();

                        data.DATA.forEach(element => {
                            $('#usuarios table tbody').append(`
                                <tr>
                                    <td>${element.nombres} ${element.apellidos}</td>
                                    <td>${element.correo}</td>
                                    <td>${element.celular}</td>
                                    <td>${element.nombre_rol}</td>
                                    <td>${element.fecha_conexion}</td>
                                    <td class="text-end">
                                        <a href="./formularioUsuarios.php?id=${element.id}" class="btn btn-light">Ver / Editar</a>
                                        <button type="button" class="btn btn-danger" onclick="eliminar(${element.id})"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        toastr.error(data.MESSAGE);
                    }
                }
            });
        }

        function limpiar () {
            $('#txtNames').val('');
            $('#txtLastNames').val('');
            $('#txtIdentification').val('');
            $('#txtEmail').val('');
        }

        function eliminar (id) {
            $.ajax({
                url: '../../controllers/c_usuario.php',
                type: 'POST',
                data: { option: 'usuarios-eliminar', id: id },
                success: function (result) {
                    let data = JSON.parse(result);

                    if (data.STATUS) {
                        toastr.success(data.MESSAGE, { timeOut: 3000 });
                        window.location.reload();
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