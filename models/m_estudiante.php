<?php
	class M_estudiante {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_estudiantes_secretaria () {
			$query = "SELECT du.id, CONCAT(du.nombres, ' ', du.apellidos) AS nombre_aspirante, s.nombre AS nombre_sede, j.nombre AS nombre_jornada, 
				g.nombre AS nombre_grado, c.nombre AS nombre_curso
					FROM detalle_usuario du 
					INNER JOIN usuario u ON du.id_usuario_fk = u.id 
					INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
					INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id
					INNER JOIN curso c ON m.id_curso_fk = c.id
					INNER JOIN grado g ON m.id_grado_fk = g.id 
					INNER JOIN jornada j ON g.id_jornada_fk = j.id 
					INNER JOIN sede s ON j.id_sede_fk = s.id
					WHERE u.id_rol_fk IN (5);";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Estudiantes cargados con éxito', 'DATA' => $data);
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen estudiantes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_estudiantes_secretaria ($sede, $jornada, $grado) {
			$query = "SELECT du.id, CONCAT(du.nombres, ' ', du.apellidos) AS nombre_aspirante, s.nombre AS nombre_sede, j.nombre AS nombre_jornada, 
				g.nombre AS nombre_grado, c.nombre AS nombre_curso
					FROM detalle_usuario du 
					INNER JOIN usuario u ON du.id_usuario_fk = u.id 
					INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
					INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id
					INNER JOIN curso c ON m.id_curso_fk = c.id
					INNER JOIN grado g ON m.id_grado_fk = g.id 
					INNER JOIN jornada j ON g.id_jornada_fk = j.id 
					INNER JOIN sede s ON j.id_sede_fk = s.id
					WHERE u.id_rol_fk IN (5)";
			if (!empty($sede) || !empty($jornada) || !empty($grado)) {
				$count = 0;

				if (!empty($sede) && empty($jornada) && empty($grado)) {
					$query .= " AND s.id = $sede";
					$count++;
				}
	
				if (!empty($jornada) && empty($grado)) {
					$query .= " AND j.id = $jornada";
					$count++;
				}

				if (!empty($grado)) {
					$query .= " AND m.id_grado_fk = $grado";
					$count++;
				}
	
				$query .= ";";
			} else {
				$query .= " AND m.id_estado_matricula_fk IN (1, 2)";
			}

			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Estudiantes cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen estudiantes', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>