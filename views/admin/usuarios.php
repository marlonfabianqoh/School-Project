<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        session_destroy();
        header("Location: ../../login.php");
    } else {
        if ($_SESSION['rol'] != '1') {
            header("Location: ../dashboard.php");
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

    <!-- CSS Custom -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>School Project</title>
</head>

<body>
    <main class="content">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="../dashboard.php">School Project</a>
                <div>
                    <a href="../../index.php?c=c_login&a=salir">
                        <button type="button" class="btn btn-light">Cerrar Sesion</button>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <h1>Administrador de usuarios</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <legend class="mt-5">Filtro de busqueda</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtUser" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="txtUser" name="txtUser">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="txtName" name="txtName">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selRole" class="form-label">Rol:</label>
                                <select class="form-select" id="selRole" name="selRole">
                                    <option value="" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selStatus" class="form-label">Estado:</label>
                                <select class="form-select" id="selStatus" name="selStatus">
                                    <option value="" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success" onclick="filtrar_usuarios(txtUser.value, txtName.value, selRole.value, selStatus.value)">
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
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre Completo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Estado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
                </div>

                <div class="col-12 mt-5">
                    <a href="../dashboard.php">
                        <button type="button" class="btn btn-outline-secondary">Volver</button>
                    </a>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <!-- Bootstrap Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JS Custom -->
    <script type="text/javascript" src="../../assets/js/usuario.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            listar_usuarios();
            listar_roles();
            listar_estados_usuario();
        });
    </script>

    <!-- <script type="text/javascript">
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
    </script> -->
</body>
</html>

<?php 
        }
    }
?> 