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

        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <h1>Listado de estudiantes</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <legend class="mt-5">Filtro de búsqueda</legend>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="selCampus" class="form-label">Sede:</label>
                                <select class="form-select" id="selCampus" name="selCampus" onchange="listar_jornadas_filtro(selCampus.value);" >
                                    <option value="" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="selSession" class="form-label">Jornada:</label>
                                <select class="form-select" id="selSession" name="selSession" onchange="listar_grados_filtro(selSession.value);" disabled>
                                    <option value="" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="selGrade" class="form-label">Grado:</label>
                                <select class="form-select" id="selGrade" name="selGrade" disabled>
                                    <option value="" selected>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-success" onclick="filtrar_estudiantes(selCampus.value, selSession.value, selGrade.value)">
                                <i class="bi bi-search"></i>
                                Filtrar
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="limpiar()">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="estudiantes" class="row mt-5">
                <div class="col-12">
                    <table class="table mt-5">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Sede</th>
                                <th scope="col">Jornada</th>
                                <th scope="col">Grado</th>
                                <th scope="col">Curso</th>
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
    <script type="text/javascript" src="../../assets/js/estudiante.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            listar_estudiantes();
            listar_sedes();
        });
    </script>
</body>
</html>

<?php 
        }
    }
?> 