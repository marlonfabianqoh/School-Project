<?php
    require_once "config/routes.php";
    require_once "config/database.php";

	if (isset($_GET['c'])) {
		$controlador = cargar_controlador($_GET['c']);
		
		if (isset($_GET['a'])) {
            cargar_accion($controlador, $_GET['a']);
		}
	} else {
        session_start();

        if (isset($_SESSION['id'])) {
            header("Location: views/dashboard.php");
        } else {
            session_destroy();
            header("Location: home.php");
        }
    }
?>