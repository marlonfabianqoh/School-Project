<?php
	class M_sede {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_sedes () {
			$query = "SELECT s.id, s.nombre, s.direccion, d.id AS id_departamento_fk, s.id_ciudad_fk, s.telefono, IFNULL(s.observacion, '') as observacion FROM sede s INNER JOIN ciudad c ON s.id_ciudad_fk = c.id INNER JOIN departamento d ON c.id_departamento_fk = d.id;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Sedes cargadas con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen sedes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_sede ($id) {
			$query = "SELECT s.id, s.nombre, s.direccion, (SELECT d.id FROM departamento d INNER JOIN ciudad c ON c.id_departamento_fk = d.id WHERE c.id = s.id_ciudad_fk) AS id_departamento_fk, s.id_ciudad_fk, s.telefono, IFNULL(s.observacion, '') as observacion FROM sede s WHERE s.id = ".$id.";";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Sede cargada con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe la sede', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_sedes ($nombre, $departamento, $ciudad) {
			$query = "SELECT s.id, s.nombre, s.direccion, d.id AS id_departamento_fk, s.id_ciudad_fk, s.telefono, IFNULL(s.observacion, '') as observacion FROM sede s INNER JOIN ciudad c ON s.id_ciudad_fk = c.id INNER JOIN departamento d ON c.id_departamento_fk = d.id";
        
			if (!empty($nombre) || !empty($departamento) || !empty($ciudad)) {
				$count = 0;
				$query .= " WHERE";
	
				if (!empty($nombre)) {
					$query .= " s.nombre LIKE '%$nombre%'";
					$count++;
				}

				if (!empty($departamento) && empty($ciudad)) {
					if ($count > 0) {
						$query .= " AND d.id = $departamento";
					} else {
						$query .= " d.id = $departamento";
					}

					$count++;
				}
	
				if (!empty($ciudad)) {
					if ($count > 0) {
						$query .= " AND s.id_ciudad_fk = $ciudad";
					} else {
						$query .= " s.id_ciudad_fk = $ciudad";
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
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Sedes cargadas con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen sedes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_sede ($nombre, $direccion, $ciudad, $telefono, $observacion) {
			$query = "INSERT INTO sede (nombre, direccion, id_ciudad_fk, telefono, observacion) VALUES ('$nombre', '$direccion', $ciudad, '$telefono', '$observacion');";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Sede creada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear la sede', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_sede ($id, $nombre, $direccion, $ciudad, $telefono, $observacion) {
			$query = "UPDATE sede SET nombre = '$nombre', direccion = '$direccion', id_ciudad_fk =  $ciudad, telefono = '$telefono', observacion = '$observacion' WHERE id = $id";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Sede actualizada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al actualizar la sede', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function eliminar_sede ($id) {
			$query = "DELETE FROM sede WHERE id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Sede eliminada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al eliminar la sede', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>