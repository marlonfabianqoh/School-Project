
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
                <a class="navbar-brand" href="../../home.php">School Project</a>
                <a href="../../login.php">
                    <button type="button" class="btn btn-light">Ingresar</button>
                </a>
            </div>
        </nav>

        <div class="container my-5">
            <div class="row">
                <div class="col">
                    <div class="px-4 text-center">
                        <h1 class="fw-bold">Formulario de preinscripción</h1>
                        <p class="lead mb-4">Complete el siguiente formulario en su totalidad para iniciar el proceso de preinscripción</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form id="form-preinscripcion" class="row preinscripcion-validation" method="POST" novalidate>
                        <legend class="mt-5">Datos del acudiente</legend>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtNameAttendant" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="txtNameAttendant" name="txtNameAttendant" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtLastNameAttendant" class="form-label">Apellidos:</label>
                                <input type="text" class="form-control" id="txtLastNameAttendant" name="txtLastNameAttendant" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtEmailAttendant" class="form-label">Correo:</label>
                                <input type="email" class="form-control" id="txtEmailAttendant" name="txtEmailAttendant" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPhoneAttendant" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" id="txtPhoneAttendant" name="txtPhoneAttendant" onkeypress="validarNumeros(event)">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtMobileAttendant" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="txtMobileAttendant" name="txtMobileAttendant" onkeypress="validarNumeros(event)" required>
                            </div>
                        </div>

                        <div class="col-md-6"></div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selDepartmentAttendant" class="form-label">Departamento:</label>
                                <select class="form-select" id="selDepartmentAttendant" name="selDepartmentAttendant" onchange="listar_ciudades_acudiente(selDepartmentAttendant.value)" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selCityAttendant" class="form-label">Ciudad:</label>
                                <select class="form-select" id="selCityAttendant" name="selCityAttendant" disabled required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtAddressAttendant" class="form-label">Dirección:</label>
                                <input type="text" class="form-control" id="txtAddressAttendant" name="txtAddressAttendant" required>
                            </div>
                        </div>

                        <legend class="mt-5">Datos del aspirante</legend>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtUser" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="txtUser" name="txtUser" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPass" class="form-label">Clave:</label>
                                <input type="password" class="form-control" id="txtPass" name="txtPass" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPassConfirm" class="form-label">Confirmar clave:</label>
                                <input type="password" class="form-control" id="txtPassConfirm" name="txtPassConfirm" required>
                            </div>
                        </div>

                        <div class="col-md-3"></div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selTypeId" class="form-label">Tipo de identificación:</label>
                                <select class="form-select" id="selTypeId" name="selTypeId" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtId" class="form-label">Identificación:</label>
                                <input type="text" class="form-control" id="txtId" name="txtId" onkeypress="validarNumeros(event)" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtName" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="txtName" name="txtName" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtLastName" class="form-label">Apellidos:</label>
                                <input type="text" class="form-control" id="txtLastName" name="txtLastName" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtDate" class="form-label">Fecha de nacimiento:</label>
                                <input type="date" class="form-control" id="txtDate" name="txtDate" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtEmail" class="form-label">Correo:</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPhone" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" id="txtPhone" name="txtPhone" onkeypress="validarNumeros(event)">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtMobile" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="txtMobile" name="txtMobile" onkeypress="validarNumeros(event)" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selDepartment" class="form-label">Departamento:</label>
                                <select class="form-select" id="selDepartment" name="selDepartment" onchange="listar_ciudades(selDepartment.value)" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selCity" class="form-label">Ciudad:</label>
                                <select class="form-select" id="selCity" name="selCity" disabled required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="txtAddress" class="form-label">Dirección:</label>
                                <input type="text" class="form-control" id="txtAddress" name="txtAddress" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selGender" class="form-label">Género:</label>
                                <select class="form-select" id="selGender" name="selGender" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selTypeBlood" class="form-label">Tipo de sangre:</label>
                                <select class="form-select" id="selTypeBlood" name="selTypeBlood" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selPreference" class="form-label">Preferencia:</label>
                                <select class="form-select" id="selPreference" name="selPreference" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="txtObservation" class="form-label">Observaciones:</label>
                                <textarea class="form-control" cols="30" rows="5" id="txtObservation" name="txtObservation"></textarea>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selYear" class="form-label">Año:</label>
                                <select class="form-select" id="selYear" name="selYear" onchange="listar_sedes(selYear.value)" required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selCampus" class="form-label">Sede:</label>
                                <select class="form-select" id="selCampus" name="selCampus" onchange="listar_jornadas(selCampus.value)" disabled required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selSession" class="form-label">Jornada:</label>
                                <select class="form-select" id="selSession" name="selSession" onchange="listar_grados(selSession.value)" disabled required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="selGrade" class="form-label">Grado al que aspira:</label>
                                <select class="form-select" id="selGrade" name="selGrade" disabled required>
                                    <option value="" selected disabled>Seleccionar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtPhoto" class="form-label">Adjunte foto:</label>
                                <input type="file" accept=".jpg, .png, .jpeg, .svg" id="txtPhoto" name="txtPhoto" onchange="changeFilePhoto()" hidden />
                                <button type="button" class="form-control btn btn-success" onclick="selectFilePhoto()">
                                    <i class="bi bi-clip"></i>
                                    Adjuntar
                                </button>
                                <label id="lblPhoto" class="form-label"></label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="txtCertificate" class="form-label">Certificado grado anterior:</label>
                                <input type="file" id="txtCertificate" name="txtCertificate" onchange="changeFileCertificate()" hidden />
                                <button type="button" class="form-control btn btn-success" onclick="selectFileCertificate()">
                                    <i class="bi bi-clip"></i>
                                    Adjuntar
                                </button>
                                <label id="lblCertificate" class="form-label"></label>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <a href="../../home.php">
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
            listar_tipos_identificacion();
            listar_departamentos();
            listar_generos();
            listar_tipos_sangre();
            listar_preferencias();
            listar_anualidades();
        });
    </script>
</body>
</html>