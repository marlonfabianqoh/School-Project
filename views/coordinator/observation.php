<?php
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['rol'] != '5') {
        header("Location: ../../index.php");
    } else {
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


    <!-- CSS Custom -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>School Project</title>
</head>

<body>
    <main class="content">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="../home.php">School Project</a>
                <div>
                    <!-- <a href="/views/secretary/dashboard.html">
                        <button type="button" class="btn btn-light">Secretaria</button>
                    </a> -->
                    <a href="../../controllers/logout.php">
                        <button type="button" class="btn btn-light">Cerrar Sesion</button>
                    </a>
                </div>
            </div>
        </nav>
        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <h1>Observaciones del Coordinador.</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form class="row">
                        <legend class="mt-5">Datos del coordinador</legend>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombresCoordinador" class="form-label">Nombres del coordinador:</label>
                                <input type="text" class="form-control" id="nombresCoordinador">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellidosCoordinador" class="form-label">Apellidos del coordinador:</label>
                                <input type="text" class="form-control" id="apellidosCoordinador">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="telefonoCoordinador" class="form-label">Identificacion del
                                    coordinador:</label>
                                <input type="number" class="form-control" id="telefonoCoordinador">
                            </div>
                        </div>
                        <legend class="mt-5">Datos del estudiante</legend>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nombresEstudiante" class="form-label">Nombres del estudiante:</label>
                                <input type="text" class="form-control" id="nombresEstudiante">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="apellidosEstudiante" class="form-label">Apellidos del estudiante:</label>
                                <input type="text" class="form-control" id="apellidosEstudiante">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="telefonoEstudiante" class="form-label">Identificacion del
                                    estudiante:</label>
                                <input type="number" class="form-control" id="telefonoEstudiante">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="observacionesEstudiante" class="form-label">Observaciones:</label>
                                <textarea name="observacionesEstudiante" class="form-control" id="observacionesEstudiante"
                                    cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="studentObservation.php">
                                <button type="button" class="btn btn-success">
                                    <i class="bi bi-book"></i>
                                    Historial de observaciones
                                </button>
                            </a>
                        </div>
                        <div class="col-12 mt-5">
                            <a href="studentList.php">
                                <button type="button" class="btn btn-primary">Enviar</button>
                            </a>
                            <a href="studentList.php">
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
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                      <use xlink:href="#twitter"></use>
                    </svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                      <use xlink:href="#instagram"></use>
                    </svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                      <use xlink:href="#facebook"></use>
                    </svg></a></li>
              </ul>
            </div>
          </footer>
    </main>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>

<?php 
    }
?> 