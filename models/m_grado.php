<?php
	class M_grado {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_grados () {
			$query = "SELECT g.id, g.nombre, g.id_jornada_fk, s.id AS id_sede_fk, IFNULL(g.observacion, '') as observacion FROM grado g INNER JOIN jornada j ON g.id_jornada_fk = j.id INNER JOIN sede s ON j.id_sede_fk = s.id;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Grados cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen grados', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_grado ($id) {
			$query = "SELECT g.id, g.nombre, g.id_jornada_fk, s.id AS id_sede_fk, IFNULL(g.observacion, '') as observacion FROM grado g INNER JOIN jornada j ON g.id_jornada_fk = j.id INNER JOIN sede s ON j.id_sede_fk = s.id WHERE g.id = ".$id.";";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Grado cargado con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe el grado', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_grados ($nombre, $sede, $jornada) {
			$query = "SELECT g.id, g.nombre, g.id_jornada_fk, s.id AS id_sede_fk, IFNULL(g.observacion, '') as observacion FROM grado g INNER JOIN jornada j ON g.id_jornada_fk = j.id INNER JOIN sede s ON j.id_sede_fk = s.id";
        
			if (!empty($nombre) || !empty($sede) || !empty($jornada)) {
				$count = 0;
				$query .= " WHERE";
	
				if (!empty($nombre)) {
					$query .= " g.nombre LIKE '%$nombre%'";
					$count++;
				}

				if (!empty($sede) && empty($jornada)) {
					if ($count > 0) {
						$query .= " AND s.id = $sede";
					} else {
						$query .= " s.id = $sede";
					}

					$count++;
				}
	
				if (!empty($jornada)) {
					if ($count > 0) {
						$query .= " AND g.id_jornada_fk = $jornada";
					} else {
						$query .= " g.id_jornada_fk = $jornada";
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
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Grados cargadas con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen grados', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_grado ($nombre, $jornada, $observacion) {
			$query = "INSERT INTO grado (nombre, id_jornada_fk, observacion) VALUES ('$nombre', $jornada, '$observacion');";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Grado creado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear el grado', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_grado ($id, $nombre, $jornada, $observacion) {
			$query = "UPDATE grado SET nombre = '$nombre', id_jornada_fk =  $jornada, observacion = '$observacion' WHERE id = $id";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Grado actualizado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al actualizar el grado', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function eliminar_grado ($id) {
			$query = "DELETE FROM grado WHERE id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Grado eliminado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al eliminar el grado', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>