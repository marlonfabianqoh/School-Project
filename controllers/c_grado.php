<?php
	class C_grado {
		public function __construct(){
			require_once "models/m_grado.php";
		}
		
		public function listar () {
			$grado = new M_grado();
			$response = $grado->obtener_grados();
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$grado = new M_grado();
			$response = $grado->obtener_grado($id);
			echo $response;
		}

		public function filtrar () {
			$nombre = $_POST['nombre'];
			$sede = $_POST['sede'];
			$jornada = $_POST['jornada'];

			$grado = new M_grado();
			$response = $grado->filtrar_grados($nombre, $sede, $jornada);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$nombre = $_POST['txtName'];
			$jornada = $_POST['selSession'];
			$observacion = $_POST['txtObservation'];

			$grado = new M_grado();

			if (empty($id)) {
				$response = $grado->crear_grado($nombre, $jornada, $observacion);
			} else {
				$response = $grado->editar_grado($id, $nombre, $jornada, $observacion);
			}

			echo $response;
		}

		public function eliminar () {
			$id = $_POST['id'];

			$grado = new M_grado();
			$response = $grado->eliminar_grado($id);
			echo $response;
		}
	}
?>