<?php
	class C_parametro {
		public function __construct(){
			require_once "models/m_parametro.php";
		}

		public function buscar () {
			$anio = $_POST['anio'];

			$parametro = new M_parametro();
			$response = $parametro->obtener_parametro($anio);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$cursos = $_POST['txtCourse'];
			$estudiantes = $_POST['txtStudent'];
			$anio = $_POST['anio'];

			$parametro = new M_parametro();

			if (empty($id)) {
				$response = $parametro->crear_parametro($cursos, $estudiantes, $anio);
			} else {
				$response = $parametro->editar_parametro($id, $cursos, $estudiantes, $anio);
			}

			echo $response;
		}

		public function guardar_anualidad () {
			$anio = $_POST['txtYear'];

			$parametro = new M_parametro();
			$response = $parametro->crear_anualidad($anio);
			echo $response;
		}
	}
?>