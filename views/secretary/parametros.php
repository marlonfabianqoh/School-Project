<?php
session_start();

if (!isset($_SESSION['id'])) {
    session_destroy();
    header("Location: ../../login.php");
} else {
    if ($_SESSION['rol'] != '2') {
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
            <link rel="stylesheet" href="../../assets/css/style.css">

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
                                <button type="button" class="btn btn-light">Cerrar sesión</button>
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="container my-5">
                    <div class="row">
                        <div class="col">
                            <h1>Parámetros</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selYear" class="form-label">Año:</label>
                                <select class="form-select" id="selYear" name="selYear" onchange="buscar_parametro(selYear.value); listar_documentos(selYear.value)" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mt-md-3">
                            <button type="button" class="btn btn-success mt-0 mt-md-3" data-bs-toggle="modal" data-bs-target="#modalAnnuity">
                                <i class="bi bi-plus"></i>
                                Agregar
                            </button>
                        </div>
                    </div>

                    <div id="result" class="row mt-5 d-none">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Curso</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Documentos</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row mt-5">
                                    <div class="col">
                                        <form id="form-parametro" class="row parametro-validation" method="POST" novalidate>
                                            <input type="text" id="id" name="id" value="" hidden>
                                            <input type="text" id="anio" name="anio" value="" hidden>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="txtCourse" class="form-label">Número de de cursos por grado:</label>
                                                    <input type="text" class="form-control" id="txtCourse" name="txtCourse" onkeypress="validarNumeros(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="txtStudent" class="form-label">Número de estudiantes por curso:</label>
                                                    <input type="text" class="form-control" id="txtStudent" name="txtStudent" onkeypress="validarNumeros(event)">
                                                </div>
                                            </div>

                                            <div class="col-12 mt-5">
                                                <button type="submit" class="btn btn-primary" onclick="anio.value = selYear.value">Guardar</button>
                                                <a href="../dashboard.php">
                                                    <button type="button" class="btn btn-outline-secondary">Volver</button>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row mt-5">
                                    <div class="offset-md-9 col-md-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDocument" onclick="limpiar_modal(); anio_document.value = selYear.value;">
                                            <i class="bi bi-plus"></i>
                                            Agregar
                                        </button>
                                    </div>

                                    <div id="documentos" class="col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nombre / Descripción</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>

                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalAnnuity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar anualidad</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form id="form-anualidad" class="row anualidad-validation" method="POST" novalidate>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="txtYear" class="form-label">Año:</label>
                                            <input type="number" placeholder="YYYY" min="2022" max="2100" class="form-control" maxlength="4" id="txtYear" name="txtYear" onkeypress="validarNumeros(event)" required>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalDocument" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Documentos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form id="form-documento" class="row documento-validation" method="POST" novalidate>
                                    <input type="text" id="id_document" name="id_document" value="" hidden>
                                    <input type="text" id="anio_document" name="anio_document" value="" hidden>

                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="txtName" class="form-label">Nombre / Descripción:</label>
                                            <input type="text" class="form-control" id="txtName" name="txtName" required>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                            </div>
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
                            <span class="text-muted">© 2022 School Project -- Marlon Garcia -- Carlos Rueda -- Luis Corredor -- Eva Orejarena</span>
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
            <script type="text/javascript" src="../../assets/js/parametro.js"></script>

            <script type="text/javascript">
                $(document).ready(function() {
                    listar_anualidades();
                });
            </script>
        </body>

        </html>

<?php
    }
}
?>