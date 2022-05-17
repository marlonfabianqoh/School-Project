<?php
	class M_general {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_departamentos () {
			$query = "SELECT id, nombre, codigo FROM departamento ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Departamentos cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen departamentos', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_ciudades ($departamento) {
			$query = "SELECT id, nombre, codigo, id_departamento_fk FROM ciudad WHERE id_departamento_fk = ".$departamento." ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Ciudades cargadas con éxito', 'DATA' => $data);
				echo json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen ciudades', 'DATA' => array());
				echo json_encode($response);
			}
		}

		public function obtener_roles () {
			$query = "SELECT id, nombre FROM rol ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Roles cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen roles', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_estados_usuario () {
			$query = "SELECT id, nombre FROM estado_usuario ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Estados cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen estados', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_tipos_documento () {
			$query = "SELECT id, nombre FROM tipo_documento ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Tipos de documento cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen tipos de documento', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_generos () {
			$query = "SELECT id, nombre FROM genero ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Géneros cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen géneros', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_tipos_sangre () {
			$query = "SELECT id, nombre FROM tipo_sangre ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Tipos de sangre cargados con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen tipos de sangre', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_preferencias() {
			$query = "SELECT id, nombre FROM preferencia ORDER BY nombre ASC;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						$data[] = $row;
					}
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Preferencias cargadas con éxito', 'DATA' => $data);
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen preferencias', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>