<?php
	class M_login {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function iniciar_sesion ($usuario, $clave) {
			$query = "SELECT u.id, u.clave, u.id_rol_fk, u.id_estado_usuario_fk, CONCAT(du.nombres, ' ', du.apellidos) AS nombre, du.documento FROM usuario u INNER JOIN detalle_usuario du ON u.id = du.id_usuario_fk WHERE u.usuario = '$usuario';";
			$result = $this->mysqli->query($query);

			if ($result->num_rows) {
				$row = $result->fetch_assoc();

				if ($row['id_estado_usuario_fk'] == 1) {
					if (sha1($clave) == $row['clave']) {
						session_start();
						$_SESSION['id'] = $row['id'];
						$_SESSION['usuario'] = $usuario;
						$_SESSION['rol'] = $row['id_rol_fk'];
						$_SESSION['nombre'] = $row['nombre'];
						$_SESSION['documento'] = $row['documento'];

						$response = array('CODE' => 1, 'DESCRIPTION' => 'Inicio de sesión éxitoso', 'DATA' => array());
						return json_encode($response);
					} else {
						$response = array('CODE' => 2, 'DESCRIPTION' => 'Contraseña incorrecta', 'DATA' => array());
						return json_encode($response);
					}
				} else {
					$response = array('CODE' => 2, 'DESCRIPTION' => 'El usuario se encuentra inactivo', 'DATA' => array());
					return json_encode($response);
				}
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'El usuario no existe', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function cerrar_sesion () {
			session_start();
			session_destroy();
			header('Location: login.php');
		}
	} 
?>