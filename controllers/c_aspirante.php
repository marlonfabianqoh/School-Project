<?php
	class C_aspirante {
		public function __construct(){
			require_once "models/m_aspirante.php";
		}
		
		public function listar () {
			$aspirante = new M_aspirante();
			session_start();

			if ($_SESSION['rol'] == '2') {
				$response = $aspirante->obtener_aspirantes_secretaria();
				echo $response;
			} else if ($_SESSION['rol'] == '4') {
				$response = $aspirante->obtener_aspirantes_psicoorientador();
				echo $response;
			}
		}

		public function buscar () {
			$id = $_POST['id'];
			
			$aspirante = new M_aspirante();
			session_start();
			
			if ($_SESSION['rol'] == '2') {
				$response = $aspirante->obtener_aspirante_secretaria($id);
				echo $response;
			} else if ($_SESSION['rol'] == '4') {
				$response = $aspirante->obtener_aspirante_psicoorientador($id);
				echo $response;
			}
		}

		public function filtrar () {
			$anio = $_POST['anio'];
			$sede = $_POST['sede'];
			$jornada = $_POST['jornada'];
			$grado = $_POST['grado'];
			$estado = $_POST['estado'];
			
			$aspirante = new M_aspirante();
			session_start();
			
			if ($_SESSION['rol'] == '2') {
				$response = $aspirante->filtrar_aspirantes_secretaria($anio, $sede, $jornada, $grado, $estado);
				echo $response;
			} else if ($_SESSION['rol'] == '4') {
				$response = $aspirante->filtrar_aspirantes_psicoorientador($anio, $sede, $jornada, $grado, $estado);
				echo $response;
			}
		}

		public function observar () {
			$id = $_POST['id'];
			$observacion = $_POST['txtObservation'];
			$estado = $_POST['cbxStatus'];

			$aspirante = new M_aspirante();
			session_start();

			if ($_SESSION['rol'] == '2') {
				$curso = isset($_POST['selCourse']) ? $_POST['selCourse'] : '';
				$response = $aspirante->observar_aspirante_secretaria($id, $observacion, $estado, $curso);
				echo $response;
			} else if ($_SESSION['rol'] == '4') {
				$response = $aspirante->observar_aspirante_psicoorientador($id, $observacion, $estado);
				echo $response;
			}
		}
	}
?>