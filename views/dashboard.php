<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: ../login.php");
    } else {
        $nombre = $_SESSION['nombre'];
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

    <title>School Project</title>
</head>

<body>
    <main class="content">
        <nav class="navbar navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="dashboard.php">School Project</a>
                <div>
                    <a href="../index.php?c=c_login&a=salir">
                        <button type="button" class="btn btn-light">Cerrar Sesion</button>
                    </a>
                </div>
            </div>
        </nav>
        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <div class="px-4 text-center">
                        <h1 class="fw-bold">Bienvenido a School Project.</h1>
                        <h2 class="text-primary"><?php echo $nombre; ?></h2>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <?php if ($_SESSION['rol'] == '1') { ?>
                    <div class="col-md-3">
                        <a href="./admin/usuarios.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Usuarios</h4>
                                <h2>
                                    <i class="bi bi-person text-primary"></i>
                                </h2>
                            </div>
                        </a>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['rol'] == '2') { ?>
                    <div class="col-md-3">
                        <a href="./secretary/sedes.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Sedes</h4>
                                <h2>
                                    <i class="bi bi-house text-primary"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="./secretary/jornadas.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Jornadas</h4>
                                <h2>
                                    <i class="bi bi-clock-history text-success"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="./secretary/grados.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Grados</h4>
                                <h2>
                                    <i class="bi bi-puzzle text-primary"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="./secretary/cursos.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Cursos</h4>
                                <h2>
                                    <i class="bi bi-journal-bookmark text-success"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                <?php } ?>

                <?php if ($_SESSION['rol'] == '3') {?>
                    <div class="col-md-3">
                        <a href="./secretary/sedes.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Sedes</h4>
                                <h2>
                                    <i class="bi bi-house text-primary"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="./secretary/jornadas.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Jornadas</h4>
                                <h2>
                                    <i class="bi bi-clock-history text-success"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="./secretary/grados.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Grados</h4>
                                <h2>
                                    <i class="bi bi-puzzle text-primary"></i>
                                </h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="./secretary/dashboard.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Cursos</h4>
                                <h2>
                                    <i class="bi bi-journal-bookmark text-success"></i>
                                </h2>
                            </div>
                        </a>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['rol'] == '4') {?>
                    <div class="col-md-3">
                        <a href="./psychologist/studentList.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Estudiantes</h4>
                                <h2>
                                    <i class="bi bi-person text-primary"></i>
                                </h2>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                
                <?php if ($_SESSION['rol'] == '5') {?>
                    <div class="col-md-3">
                        <a href="./student/consult.php" class="text-decoration-none">
                            <div class="card text-center shadow-sm p-4">
                                <h4 class="card-title text-dark">Consultar matricula</h4>
                                <h2>
                                    <i class="bi bi-journal-bookmark text-success"></i>
                                </h2>
                            </div>
                        </a>
                    </div>
                <?php } ?> 
            </div>
        </div>
        <?php
            require('../componentes/footer.php');
        ?>
    </main>

   <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>

<?php 
    }
?>