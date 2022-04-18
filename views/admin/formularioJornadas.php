<?php
    session_start();

    if (!isset($_SESSION['id']) || $_SESSION['rol'] != '1') {
        header("Location: ../index.php");
    } else {
        require "../../controllers/connection.php";

        if (!empty($_GET['id'])) {
            $id = $_GET["id"];

            $query = "SELECT * FROM `jornada` WHERE id = '$id' LIMIT 1";
            $result = $mysqli->query($query);
        
            if($result->num_rows){
                $row = $result->fetch_assoc();

                $nombre = $row['nombre'];

                echo $nombre;
            }
        } else {

            if (!empty($_POST['nombreSede']) && !empty($_POST['observacionesSede'])) {

                $nombre = $_POST["nombreSede"];
                $observaciones = $_POST["observacionesSede"];
                
                $query = "INSERT INTO `jornada`(`nombre`) VALUES ('$nombre');";
                $mysqli->query($query);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


    <!-- CSS Custom -->
    <link rel="stylesheet" href="../../assets/css/style.css">
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
                    <h1>Formulario de jornadas.</h1>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col">
                    <form action="formularioJornadas.php" method="post" class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="nombreSede" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreSede" name="nombreSede" value="<?php echo $nombre;?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="observacionesSede" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observacionesSede" name="observacionesSede"
                                    cols="30" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="adminJornadas.php" role="button" class="btn btn-outline-secondary">Volver</a>
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