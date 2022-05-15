<?php
	class C_login {
		public function __construct(){
			require_once "models/m_login.php";
		}
		
		public function ingresar () {
			$usuario = $_POST['txtUser'];
			$clave = $_POST['txtPassword'];
			
			$login = new M_login();
			$response = $login->iniciar_sesion($usuario, $clave);
			echo $response;
		}

		public function salir () {
			$login = new M_login();
			$login->cerrar_sesion();
		}
	}
?>