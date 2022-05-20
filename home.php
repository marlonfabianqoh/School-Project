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
                <a class="navbar-brand" href="home.php">School Project</a>
                <a href="login.php">
                    <button type="button" class="btn btn-light">Ingresar</button>
                </a>
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <div class="px-4 text-center">
                        <h1 class="fw-bold">Bienvenido a la plataforma de recepción de solicitudes de inscripción.</h1>
                        <p class="lead mb-4">Seleccione la opción que desea realizar</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="views/student/preinscription.php">
                                <button type="button" class="btn btn-primary btn-lg px-4 gap-3">Iniciar la preinscripción</button>
                            </a>

                            <a href="views/student/consult.php">
                                <button type="button" class="btn btn-outline-secondary btn-lg px-4">Consultar el estado de la inscripción</button>
                            </a>
                        </div>
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
  </body>
</html>