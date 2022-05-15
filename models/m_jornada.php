<?php
	class M_jornada {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_jornadas () {
			$query = "SELECT id, nombre, IFNULL(observacion, '') as observacion, id_sede_fk FROM jornada;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Jornadas cargadas con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen jornadas', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_jornada ($id) {
			$query = "SELECT id, nombre, IFNULL(observacion, '') as observacion, id_sede_fk FROM jornada WHERE id = ".$id.";";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Jornada cargada con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe la jornada', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_jornadas ($nombre, $sede) {
			$query = "SELECT id, nombre, IFNULL(observacion, '') as observacion, id_sede_fk FROM jornada";
        
			if (!empty($nombre) || !empty($sede)) {
				$count = 0;
				$query .= " WHERE";
	
				if (!empty($nombre)) {
					$query .= " nombre LIKE '%$nombre%'";
					$count++;
				}

				if (!empty($sede)) {
					if ($count > 0) {
						$query .= " AND id_sede_fk = $sede";
					} else {
						$query .= " id_sede_fk = $sede";
					}
				}
	
				$query .= ";";
			}

			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Jornadas cargadas con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen jornadas', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_jornada ($nombre, $sede, $observacion) {
			$query = "INSERT INTO jornada (nombre, observacion, id_sede_fk) VALUES ('$nombre', '$observacion', $sede);";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Jornada creada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear la jornada', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_jornada ($id, $nombre, $sede, $observacion) {
			$query = "UPDATE jornada SET nombre = '$nombre', observacion = '$observacion', id_sede_fk = $sede WHERE id = $id";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Jornada actualizada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al actualizar la jornada', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function eliminar_jornada ($id) {
			$query = "DELETE FROM jornada WHERE id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Jornada eliminada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al eliminar la jornada', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>