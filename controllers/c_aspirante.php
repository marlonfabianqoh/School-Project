<?php
	class C_aspirante {
		public function __construct(){
			require_once "models/m_aspirante.php";
		}
		
		public function listar () {
			$aspirante = new M_aspirante();
			$response = $aspirante->obtener_aspirantes();
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$aspirante = new M_aspirante();
			$response = $aspirante->obtener_aspirante($id);
			echo $response;
		}

		public function filtrar () {
			$anio = $_POST['anio'];
			$sede = $_POST['sede'];
			$jornada = $_POST['jornada'];
			$grado = $_POST['grado'];
			$estado = $_POST['estado'];
			
			$aspirante = new M_aspirante();
			$response = $aspirante->filtrar_aspirantes($anio, $sede, $jornada, $grado, $estado);
			echo $response;
		}

		public function observar () {
			$id = $_POST['id'];
			$observacion = $_POST['txtObservation'];
			$estado = $_POST['cbxStatus'];

			$aspirante = new M_aspirante();
			$response = $aspirante->observar_aspirante($id, $observacion, $estado);
			echo $response;
		}
	}
?>