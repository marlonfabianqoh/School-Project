<?php
	class M_login {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function iniciar_sesion ($usuario, $clave) {
			$query = "SELECT id, clave, id_rol_fk FROM usuario WHERE usuario = '$usuario';";
			$result = $this->mysqli->query($query);

			if ($result->num_rows) {
				$row = $result->fetch_assoc();

				if (sha1($clave) == $row['clave']) {
					session_start();
					$_SESSION['id'] = $row['id'];
					$_SESSION['usuario'] = $usuario;
					$_SESSION['rol'] = $row['id_rol_fk'];

					$response = array('CODE' => 1, 'DESCRIPTION' => 'Inicio de sesión éxitoso', 'DATA' => array());
					return json_encode($response);
				} else {
					$response = array('CODE' => 2, 'DESCRIPTION' => 'Contraseña incorrecta', 'DATA' => array());
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