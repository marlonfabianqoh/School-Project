<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        session_destroy();
        header("Location: ../../login.php");
    } else {
        if ($_SESSION['rol'] != '4') {
            header("Location: ../dashboard.php");
        } else {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $params = parse_url($url);
            if (isset($params['query'])) {
                parse_str($params['query'], $params);
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
                    <h1>Observaciones del psicoorientador</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <legend class="mt-5">Datos del Aspirante</legend>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selTypeId" class="form-label">Tipo de identificación:</label>
                                <select class="form-select" id="selTypeId" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtId" class="form-label">Identificación:</label>
                                <input type="text" class="form-control" id="txtId" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="txtName" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtLastName" class="form-label">Apellidos:</label>
                                <input type="text" class="form-control" id="txtLastName" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtDate" class="form-label">Fecha de nacimiento:</label>
                                <input type="date" class="form-control" id="txtDate" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtEmail" class="form-label">Correo:</label>
                                <input type="email" class="form-control" id="txtEmail" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPhone" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" id="txtPhone" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtMobile" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="txtMobile" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selDepartment" class="form-label">Departamento:</label>
                                <select class="form-select" id="selDepartment" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selCity" class="form-label">Ciudad:</label>
                                <select class="form-select" id="selCity" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtAddress" class="form-label">Dirección:</label>
                                <input type="text" class="form-control" id="txtAddress" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selGender" class="form-label">Género:</label>
                                <select class="form-select" id="selGender" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selTypeBlood" class="form-label">Tipo de sangre:</label>
                                <select class="form-select" id="selTypeBlood" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selPreference" class="form-label">Preferencia:</label>
                                <select class="form-select" id="selPreference" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="txtObservationn" class="form-label">Observaciones:</label>
                                <textarea class="form-control" cols="30" rows="5" id="txtObservationn" disabled></textarea>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selYear" class="form-label">Año:</label>
                                <select class="form-select" id="selYear" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selCampus" class="form-label">Sede:</label>
                                <select class="form-select" id="selCampus" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selSession" class="form-label">Jornada:</label>
                                <select class="form-select" id="selSession" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selGrade" class="form-label">Grado al que aspira:</label>
                                <select class="form-select" id="selGrade" disabled>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPhoto" class="form-label">Documentos:</label>
                                <button type="button" class="form-control btn btn-success" data-bs-toggle="modal" data-bs-target="#modalViewer" onclick="">
                                    <i class="bi bi-eye"></i>
                                    Visualizar
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <form id="form-observacion" class="row observacion-validation" method="POST" novalidate>
                        <input type="text" id="id" name="id" value="<?php if (isset($params['id'])) { echo $params['id']; } else { echo ''; } ?>" hidden>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="txtObservation" class="form-label">Observaciones del aspirante:</label>
                                <textarea class="form-control" cols="30" rows="5" id="txtObservation" name="txtObservation" required></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" value="2" id="cbxAccepted" name="cbxStatus" required>
                                <label class="form-check-label" for="cbxAccepted">Aceptado</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" value="4" id="cbxRejected" name="cbxStatus" required>
                                <label class="form-check-label" for="cbxRejected">Rechazado</label>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <a href="aspirantes.php">
                              <button type="button" class="btn btn-outline-secondary">Cancelar</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalViewer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="modal-body">
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
    <script type="text/javascript" src="../../assets/js/aspirante.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            <?php if (isset($params['id'])) { ?>

            buscar_aspirante(<?php echo $params['id']; ?>);
            
            <?php } ?>

            listar_tipos_identificacion();
            listar_departamentos();
            listar_generos();
            listar_tipos_sangre();
            listar_preferencias();
            listar_anualidades();
            listar_sedes();
        });
    </script>
</body>
</html>

<?php
        } 
    }
?> 