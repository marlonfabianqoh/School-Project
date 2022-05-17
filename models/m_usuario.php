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
			$query = "SELECT u.usuario, u.id_rol_fk, u.id_estado_usuario_fk, du.documento, du.id_tipo_documento_fk, du.nombres, du.apellidos, du.correo, du.direccion, du.id_ciudad_fk, du.telefono, du.celular, DATE_FORMAT(du.fecha_nacimiento, '%Y-%m-%d') as fecha_nacimiento, du.id_genero_fk, du.id_preferencia_fk, du.id_tipo_sangre_fk, du.observacion, d.id AS id_departamento_fk FROM usuario u INNER JOIN detalle_usuario du ON u.id = du.id_usuario_fk INNER JOIN ciudad c ON du.id_ciudad_fk = c.id INNER JOIN departamento d ON c.id_departamento_fk = d.id WHERE u.id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Usuario cargado con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe el usuario', 'DATA' => array());
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
						$query .= " AND CONCAT(du.nombres, ' ', du.apellidos) LIKE '%$nombre%'";
					} else {
						$query .= " CONCAT(du.nombres, ' ', du.apellidos) LIKE '%$nombre%'";
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

		public function crear_usuario ($usuario, $clave, $rol, $estado, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion) {
			$query = "INSERT INTO usuario (usuario, clave, id_rol_fk, id_estado_usuario_fk) VALUES ('$usuario', '".sha1($clave)."', $rol, '$estado');";
			$result = $this->mysqli->query($query);

			$last_id = $this->mysqli->insert_id;

			$query = "INSERT INTO detalle_usuario (documento, id_tipo_documento_fk, nombres, apellidos, correo, direccion, id_ciudad_fk, telefono, celular, fecha_nacimiento, id_genero_fk, id_preferencia_fk, id_tipo_sangre_fk, id_usuario_fk, observacion) VALUES ('$documento', $tipo_documento, '$nombres', '$apellidos', '$correo', '$direccion', $ciudad, '$telefono', '$celular', '$fecha_nacimiento', $genero, $preferencia, $tipo_sangre, $last_id, '$observacion');";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Usuario creado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear el usuario', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_usuario ($id, $usuario, $clave, $rol, $estado, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion) {
			$query = "UPDATE usuario SET usuario = '$usuario', id_rol_fk = $rol, id_estado_usuario_fk = $estado";
			
			if (!empty($clave)) {
				$query .= ", clave = '".sha1($clave)."'";
			}

			$query .= " WHERE id = $id"; 
			$result = $this->mysqli->query($query);

			$query = "UPDATE detalle_usuario SET documento = '$documento', id_tipo_documento_fk = $tipo_documento, nombres = '$nombres', apellidos = '$apellidos', correo = '$correo', direccion = '$direccion', id_ciudad_fk = $ciudad, telefono = '$telefono', celular = '$celular', fecha_nacimiento = '$fecha_nacimiento', id_genero_fk = $genero, id_preferencia_fk = $preferencia, id_tipo_sangre_fk = $tipo_sangre, observacion = '$observacion' WHERE id_usuario_fk = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Usuario actualizado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al actualizar el usuario', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function eliminar_usuario ($id) {
			$query = "DELETE FROM detalle_usuario WHERE id_usuario_fk = $id;";
			$result = $this->mysqli->query($query);

			$query = "DELETE FROM usuario WHERE id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Usuario eliminado con éxito', 'DATA' => array());
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al eliminar el usuario', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>