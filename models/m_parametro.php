<?php
	class M_parametro {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}

		public function obtener_parametro ($anio) {
			$query = "SELECT id, cantidad_cursos, cantidad_estudiantes FROM parametro WHERE anio = $anio;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Parámetros cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen los parámetros', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_parametro ($cursos, $estudiantes, $anio) {
			$query = "INSERT INTO parametro (cantidad_cursos, cantidad_estudiantes, anio) VALUES ($cursos, $estudiantes, $anio);";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Parámetros guardados con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al guardar los parámetros', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_parametro ($id, $cursos, $estudiantes, $anio) {
			$query = "UPDATE parametro SET cantidad_cursos = $cursos, cantidad_estudiantes = $estudiantes, anio = $anio WHERE id = $id";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Parámetros guardados con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al guardar los parámetros', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_anualidad ($anio) {
			$query = "SELECT id FROM anualidad WHERE anio = '$anio';";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Ya existe la anualidad', 'DATA' => array());
				return json_encode($response);
			}

			$query = "INSERT INTO anualidad (anio) VALUES ('$anio');";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Anualidad guardada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al guardar la anualidad', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>