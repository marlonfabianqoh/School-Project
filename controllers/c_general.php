<?php
	class C_general {
		public function __construct(){
			require_once "models/m_general.php";
		}
		
		public function listar_departamentos () {
			$general = new M_general();
			$response = $general->obtener_departamentos();
			echo $response;
		}

		public function listar_ciudades () {
			$departamento = $_POST['departamento'];

			$general = new M_general();
			$response = $general->obtener_ciudades($departamento);
			echo $response;
		}
	}
?>