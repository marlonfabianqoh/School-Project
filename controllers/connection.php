<?php
    $mysqli = new mysqli("localhost", "root", "", "matricula");

    if ($mysqli -> connect_errno) {
        echo "Fallo la conexión a la base de datos: " . $mysqli -> connect_error;
        exit();
    }
?>