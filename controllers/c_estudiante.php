<?php
	class C_estudiante {
		public function __construct(){
			require_once "models/m_estudiante.php";
		}
		
		public function listar () {
			$estudiante = new M_estudiante();
			session_start();

			if ($_SESSION['rol'] == '2') {
				$response = $estudiante->obtener_estudiantes_secretaria();
				echo $response;
			} else if ($_SESSION['rol'] == '3') {
				$response = $estudiante->obtener_estudiantes_coordinador();
				echo $response;
			}
		}

		public function filtrar () {
			$sede = $_POST['sede'];
			$jornada = $_POST['jornada'];
			$grado = $_POST['grado'];
			
			$estudiante = new M_estudiante();
			session_start();
			
			if ($_SESSION['rol'] == '2') {
				$response = $estudiante->filtrar_estudiantes_secretaria($sede, $jornada, $grado);
				echo $response;
			} else if ($_SESSION['rol'] == '3') {
				$response = $estudiante->filtrar_estudiantes_coordinador($sede, $jornada, $grado);
				echo $response;
			}
		}
	}
?>