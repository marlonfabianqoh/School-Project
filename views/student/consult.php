<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        session_destroy();
        header("Location: ../../login.php");
    } else {
        if ($_SESSION['rol'] != '5') {
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
                        <button type="button" class="btn btn-light">Salir</button>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <div class="px-4 text-center">
                        <h1 class="fw-bold">Consulta de matricula</h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form id="form-consult" class="row consult-validation" method="POST" novalidate>
                        <input type="text" id="txtId" name="txtId" value="<?php echo $_SESSION['documento']; ?>" hidden>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selYear" class="form-label">Año:</label>
                                <select class="form-select" id="selYear" name="selYear" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3 pt-3">
                                <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                            </div>
                        </div>
                    </form>

                    <div id="result" class="d-none">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="nombresSolicitud" class="form-label">Resultado:</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cbxPending" id="cbxPending" value="" disabled>
                                        <label class="form-check-label" for="cbxPending">Pendiente</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cbxAccepted" id="cbxAccepted" value="" disabled>
                                        <label class="form-check-label" for="cbxAccepted">Aceptado</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cbxRejected" id="cbxRejected" value="" disabled>
                                        <label class="form-check-label" for="cbxRejected">Rechazado</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="txtObservation" class="form-label">Observaciones:</label>
                                <textarea name="txtObservation" class="form-control" id="txtObservation" cols="30" rows="5" readonly></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <a href="../dashboard.php">
                            <button type="button" class="btn btn-outline-secondary">Volver</button>
                        </a>
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
    <script type="text/javascript" src="../../assets/js/matricula.js"></script>

    <script type="text/javascript">
        $(document).ready(async function () {
            listar_anualidades();
        });
    </script>
</body>
</html>

<?php 
        }
    }
?>