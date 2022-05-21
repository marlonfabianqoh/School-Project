<?php
	class C_curso {
		public function __construct(){
			require_once "models/m_curso.php";
		}
		
		public function listar () {
			$curso = new M_curso();
			$response = $curso->obtener_cursos();
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$curso = new M_curso();
			$response = $curso->obtener_curso($id);
			echo $response;
		}

		public function filtrar () {
			$nombre = $_POST['nombre'];
			$anio = $_POST['anio'];
			$sede = $_POST['sede'];
			$jornada = $_POST['jornada'];
			$grado = $_POST['grado'];

			$curso = new M_curso();
			$response = $curso->filtrar_cursos($anio, $nombre, $sede, $jornada, $grado);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$nombre = $_POST['txtName'];
			$grado = $_POST['selGrade'];
			$observacion = $_POST['txtObservation'];
			$anio = $_POST['selYear'];

			$curso = new M_curso();

			if (empty($id)) {
				$response = $curso->crear_curso($nombre, $grado, $observacion, $anio);
			} else {
				$response = $curso->editar_curso($id, $nombre, $grado, $observacion, $anio);
			}

			echo $response;
		}

		public function eliminar () {
			$id = $_POST['id'];

			$curso = new M_curso();
			$response = $curso->eliminar_curso($id);
			echo $response;
		}
	}
?>