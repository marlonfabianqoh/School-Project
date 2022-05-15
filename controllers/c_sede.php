<?php
	class C_sede {
		public function __construct(){
			require_once "models/m_sede.php";
		}
		
		public function listar () {
			$sede = new M_sede();
			$response = $sede->obtener_sedes();
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$sede = new M_sede();
			$response = $sede->obtener_sede($id);
			echo $response;
		}

		public function filtrar () {
			$nombre = $_POST['nombre'];
			$departamento = $_POST['departamento'];
			$ciudad = $_POST['ciudad'];

			$sede = new M_sede();
			$response = $sede->filtrar_sedes($nombre, $departamento, $ciudad);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$nombre = $_POST['txtName'];
			$direccion = $_POST['txtAddress'];
			$ciudad = $_POST['selCity'];
			$telefono = $_POST['txtPhone'];
			$observacion = $_POST['txtObservation'];

			$sede = new M_sede();

			if (empty($id)) {
				$response = $sede->crear_sede($nombre, $direccion, $ciudad, $telefono, $observacion);
			} else {
				$response = $sede->editar_sede($id, $nombre, $direccion, $ciudad, $telefono, $observacion);
			}

			echo $response;
		}

		public function eliminar () {
			$id = $_POST['id'];

			$sede = new M_sede();
			$response = $sede->eliminar_sede($id);
			echo $response;
		}
	}
?>