<?php
	class M_documento {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_documentos ($anio) {
			$query = "SELECT id, nombre, anio FROM tipo_documento_matricula WHERE anio = ".$anio.";";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Documentos cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen documentos', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_documento ($id) {
			$query = "SELECT id, nombre, anio FROM tipo_documento_matricula WHERE id = ".$id.";";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Documento cargado con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe el documento', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_documento ($nombre, $anio) {
			$query = "INSERT INTO tipo_documento_matricula (nombre, anio) VALUES ('$nombre', $anio);";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Documento creado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear el documento', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_documento ($id, $nombre, $anio) {
			$query = "UPDATE tipo_documento_matricula SET nombre = '$nombre', anio = $anio WHERE id = $id";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Documento actualizado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al actualizar el documento', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function eliminar_documento ($id) {
			$query = "DELETE FROM tipo_documento_matricula WHERE id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Documento eliminado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al eliminar el documento', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>