<?php
	class C_parametro {
		public function __construct(){
			require_once "models/m_parametro.php";
		}

		public function buscar () {
			$anio = $_POST['anio'];

			$parametro = new M_parametro();
			$response = $parametro->obtener_parametro($anio);
			echo $response;
		}

		public function guardar () {
			/* $id = $_POST['id'];
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

			echo $response; */
		}
	}
?>