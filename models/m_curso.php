<?php
	class M_curso {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_cursos () {
			$query = "SELECT c.id, c.nombre, c.id_grado_fk, j.id AS id_jornada_fk, s.id AS id_sede_fk, IFNULL(c.observacion, '') as observacion, c.anio FROM curso c INNER JOIN grado g ON c.id_grado_fk = g.id INNER JOIN jornada j ON g.id_jornada_fk = j.id INNER JOIN sede s ON j.id_sede_fk = s.id;";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
				
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Cursos cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen cursos', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_curso ($id) {
			$query = "SELECT c.id, c.nombre, c.id_grado_fk, j.id AS id_jornada_fk, s.id AS id_sede_fk, IFNULL(c.observacion, '') as observacion, c.anio FROM curso c INNER JOIN grado g ON c.id_grado_fk = g.id INNER JOIN jornada j ON g.id_jornada_fk = j.id INNER JOIN sede s ON j.id_sede_fk = s.id WHERE c.id = ".$id.";";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Curso cargado con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe el curso', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_cursos ($anio, $nombre, $sede, $jornada, $grado) {
			$query = "SELECT c.id, c.nombre, c.id_grado_fk, j.id AS id_jornada_fk, s.id AS id_sede_fk, IFNULL(c.observacion, '') as observacion, c.anio FROM curso c INNER JOIN grado g ON c.id_grado_fk = g.id INNER JOIN jornada j ON g.id_jornada_fk = j.id INNER JOIN sede s ON j.id_sede_fk = s.id";
        
			if (!empty($anio) || !empty($nombre) || !empty($sede) || !empty($jornada) || !empty($grado)) {
				$count = 0;
				$query .= " WHERE";

				if (!empty($anio)) {
					$query .= " c.anio = $anio";
					$count++;
				}
	
				if (!empty($nombre) && !empty($sede) && empty($jornada) && empty($grado)) {
					if ($count > 0) {
						$query .= " AND c.nombre LIKE '%$nombre%'";
					} else {
						$query .= " c.nombre LIKE '%$nombre%'";
					}

					$count++;
				}

				if (!empty($sede) && empty($jornada) && empty($grado)) {
					if ($count > 0) {
						$query .= " AND s.id = $sede";
					} else {
						$query .= " s.id = $sede";
					}

					$count++;
				}
	
				if (!empty($jornada) && empty($grado)) {
					if ($count > 0) {
						$query .= " AND j.id = $jornada";
					} else {
						$query .= " j.id = $jornada";
					}

					$count++;
				}

				if (!empty($grado)) {
					if ($count > 0) {
						$query .= " AND c.id_grado_fk = $grado";
					} else {
						$query .= " c.id_grado_fk = $grado";
					}
				}
	
				$query .= ";";
			}

			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Cursos cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen cursos', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function crear_curso ($nombre, $grado, $observacion, $anio) {
			$query = "SELECT COUNT(c.id) AS cantidad, (SELECT p.cantidad_cursos FROM parametro p WHERE p.anio = $anio) AS cantidad_cursos FROM curso c WHERE c.id_grado_fk = $grado AND c.anio = $anio;";
			$result = $this->mysqli->query($query);

			if ($result->num_rows) {
				while ($row = mysqli_fetch_assoc($result)) {
					if ($row['cantidad'] >= $row['cantidad_cursos']) {
						$response = array('CODE' => 2, 'DESCRIPTION' => 'Ha llegado al límite de cursos permitidos por grado ('.$row['cantidad_cursos'].')', 'DATA' => array());
						return json_encode($response);
					}
				}
			}

			$query = "INSERT INTO curso (nombre, id_grado_fk, observacion, anio) VALUES ('$nombre', $grado, '$observacion', $anio);";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Curso creado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear el curso', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function editar_curso ($id, $nombre, $grado, $observacion, $anio) {
			$query = "UPDATE curso SET nombre = '$nombre', id_grado_fk =  $grado, observacion = '$observacion', anio = $anio WHERE id = $id";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Curso actualizado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al actualizar el curso', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function eliminar_curso ($id) {
			$query = "DELETE FROM curso WHERE id = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Curso eliminado con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al eliminar el curso', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>