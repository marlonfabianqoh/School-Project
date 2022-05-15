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
	} 
?>