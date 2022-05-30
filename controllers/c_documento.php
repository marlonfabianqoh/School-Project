<?php
	class C_documento {
		public function __construct(){
			require_once "models/m_documento.php";
		}

		public function listar () {
			$anio = $_POST['anio'];

			$documento = new M_documento();
			$response = $documento->obtener_documentos($anio);
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$documento = new M_documento();
			$response = $documento->obtener_documento($id);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id_document'];
			$nombre = $_POST['txtName'];
			$anio = $_POST['anio_document'];

			$documento = new M_documento();

			if (empty($id)) {
				$response = $documento->crear_documento($nombre, $anio);
			} else {
				$response = $documento->editar_documento($id, $nombre, $anio);
			}

			echo $response;
		}

		public function eliminar () {
			$id = $_POST['id'];

			$documento = new M_documento();
			$response = $documento->eliminar_documento($id);
			echo $response;
		}
	}
?>