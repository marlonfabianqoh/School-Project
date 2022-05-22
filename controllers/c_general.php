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

		public function listar_estados_usuario () {
			$general = new M_general();
			$response = $general->obtener_estados_usuario();
			echo $response;
		}

		public function listar_roles () {
			$general = new M_general();
			$response = $general->obtener_roles();
			echo $response;
		}

		public function listar_tipos_documento () {
			$general = new M_general();
			$response = $general->obtener_tipos_documento();
			echo $response;
		}

		public function listar_generos () {
			$general = new M_general();
			$response = $general->obtener_generos();
			echo $response;
		}

		public function listar_tipos_sangre () {
			$general = new M_general();
			$response = $general->obtener_tipos_sangre();
			echo $response;
		}

		public function listar_preferencias () {
			$general = new M_general();
			$response = $general->obtener_preferencias();
			echo $response;
		}

		public function listar_anualidades () {
			$general = new M_general();
			$response = $general->obtener_anualidades();
			echo $response;
		}

		public function listar_estados_matricula () {
			$general = new M_general();
			$response = $general->obtener_estados_matricula();
			echo $response;
		}
	}
?>