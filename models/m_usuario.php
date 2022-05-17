<?php
	class M_usuario {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_usuarios () {
			$query = "SELECT u.id, u.usuario, du.nombres, du.apellidos, u.id_rol_fk, r.nombre AS nombre_rol, u.id_estado_usuario_fk, eu.nombre AS nombre_estado FROM usuario u INNER JOIN detalle_usuario du ON u.id = du.id_usuario_fk INNER JOIN rol r ON u.id_rol_fk = r.id INNER JOIN estado_usuario eu ON u.id_estado_usuario_fk = eu.id;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Usuarios cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen usuarios', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_usuario ($id) {
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

		public function filtrar_usuarios ($usuario, $nombre, $rol, $estado) {
			$query = "SELECT u.id, u.usuario, du.nombres, du.apellidos, u.id_rol_fk, r.nombre AS nombre_rol, u.id_estado_usuario_fk, eu.nombre AS nombre_estado FROM usuario u INNER JOIN detalle_usuario du ON u.id = du.id_usuario_fk INNER JOIN rol r ON u.id_rol_fk = r.id INNER JOIN estado_usuario eu ON u.id_estado_usuario_fk = eu.id";
        
			if (!empty($usuario) || !empty($nombre) || !empty($rol) || !empty($estado)) {
				$count = 0;
				$query .= " WHERE";

				if (!empty($usuario)) {
					$query .= " u.usuario LIKE '%$usuario%'";
					$count++;
				}
	
				if (!empty($nombre)) {
					if ($count > 0) {
						$query .= " AND du.nombres LIKE '%$nombre%'";
					} else {
						$query .= " du.nombres LIKE '%$nombre%'";
					}

					$count++;
				}

				if (!empty($rol)) {
					if ($count > 0) {
						$query .= " AND u.id_rol_fk = $rol";
					} else {
						$query .= " u.id_rol_fk = $rol";
					}

					$count++;
				}
	
				if (!empty($estado)) {
					if ($count > 0) {
						$query .= " AND u.id_estado_usuario_fk = $estado";
					} else {
						$query .= " u.id_estado_usuario_fk = $estado";
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
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Usuarios cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen usuarios', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_usuario ($nombre, $direccion, $ciudad, $telefono, $observacion) {
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

		public function editar_usuario ($id, $nombre, $direccion, $ciudad, $telefono, $observacion) {
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

		public function eliminar_usuario ($id) {
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