<?php
	class C_jornada {
		public function __construct(){
			require_once "models/m_jornada.php";
		}
		
		public function listar () {
			$jornada = new M_jornada();
			$response = $jornada->obtener_jornadas();
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$jornada = new M_jornada();
			$response = $jornada->obtener_jornada($id);
			echo $response;
		}

		public function filtrar () {
			$nombre = $_POST['nombre'];
			$sede = $_POST['sede'];

			$jornada = new M_jornada();
			$response = $jornada->filtrar_jornadas($nombre, $sede);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$nombre = $_POST['txtName'];
			$sede = $_POST['selCampus'];
			$observacion = $_POST['txtObservation'];

			$jornada = new M_jornada();

			if (empty($id)) {
				$response = $jornada->crear_jornada($nombre, $sede, $observacion);
			} else {
				$response = $jornada->editar_jornada($id, $nombre, $sede, $observacion);
			}

			echo $response;
		}

		public function eliminar () {
			$id = $_POST['id'];

			$jornada = new M_jornada();
			$response = $jornada->eliminar_jornada($id);
			echo $response;
		}
	}
?>