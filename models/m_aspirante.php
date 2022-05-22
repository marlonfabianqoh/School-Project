<?php
	class M_aspirante {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}
		
		public function obtener_aspirantes_secretaria () {
			$query = "SELECT du.id, CONCAT(du.nombres, ' ', du.apellidos) AS nombre_aspirante, s.nombre AS nombre_sede, j.nombre AS nombre_jornada, 
					g.nombre AS nombre_grado, DATE_FORMAT(du.fecha_creacion, '%Y-%m-%d') AS fecha, em.nombre AS nombre_estado 
				FROM detalle_usuario du 
				INNER JOIN usuario u ON du.id_usuario_fk = u.id 
				INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
				INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id 
				INNER JOIN grado g ON m.id_grado_fk = g.id 
				INNER JOIN jornada j ON g.id_jornada_fk = j.id 
				INNER JOIN sede s ON j.id_sede_fk = s.id 
				WHERE u.id_rol_fk = 6 AND m.id_estado_matricula_fk IN (1, 2, 3, 4);";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Aspirantes cargados con éxito', 'DATA' => $data);
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen aspirantes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_aspirantes_psicoorientador () {
			$query = "SELECT du.id, CONCAT(du.nombres, ' ', du.apellidos) AS nombre_aspirante, s.nombre AS nombre_sede, j.nombre AS nombre_jornada, 
					g.nombre AS nombre_grado, DATE_FORMAT(du.fecha_creacion, '%Y-%m-%d') AS fecha, em.nombre AS nombre_estado 
				FROM detalle_usuario du 
				INNER JOIN usuario u ON du.id_usuario_fk = u.id 
				INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
				INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id 
				INNER JOIN grado g ON m.id_grado_fk = g.id 
				INNER JOIN jornada j ON g.id_jornada_fk = j.id 
				INNER JOIN sede s ON j.id_sede_fk = s.id 
				WHERE u.id_rol_fk = 6 AND m.id_estado_matricula_fk IN (1, 2, 4);";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();

				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}

				$response = array('CODE' => 1, 'DESCRIPTION' => 'Aspirantes cargados con éxito', 'DATA' => $data);
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen aspirantes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_aspirante_secretaria ($id) {
			$query = "SELECT u.id_estado_usuario_fk, du.documento, du.id_tipo_documento_fk, du.nombres, du.apellidos, du.correo, du.direccion, du.id_ciudad_fk, 
					IFNULL(du.telefono, '') AS telefono, du.celular, DATE_FORMAT(du.fecha_nacimiento, '%Y-%m-%d') as fecha_nacimiento, du.id_genero_fk, 
					du.id_preferencia_fk, du.id_tipo_sangre_fk, IFNULL(du.observacion, '') AS observacionn, d.id AS id_departamento_fk, m.anio, s.id AS id_sede_fk, 
					j.id AS id_jornada_fk, g.id AS id_grado_fk, m.observacion, m.id_estado_matricula_fk,  IFNULL(m.id_curso_fk, '') AS id_curso_fk
				FROM detalle_usuario du 
				INNER JOIN usuario u ON du.id_usuario_fk = u.id 
				INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
				INNER JOIN grado g ON m.id_grado_fk = g.id 
				INNER JOIN jornada j ON g.id_jornada_fk = j.id 
				INNER JOIN sede s ON j.id_sede_fk = s.id 
				INNER JOIN ciudad c ON du.id_ciudad_fk = c.id 
				INNER JOIN departamento d ON c.id_departamento_fk = d.id 
				WHERE u.id_rol_fk = 6 AND m.id_estado_matricula_fk IN (1, 2, 3, 4) AND du.id = $id;";
			$result1 = $this->mysqli->query($query);

			$query = "SELECT dm.nombre FROM documento_matricula dm INNER JOIN matricula m ON dm.id_matricula_fk = m.id WHERE m.id_detalle_usuario_fk = $id;";
			$result2 = $this->mysqli->query($query);
			
			if ($result1->num_rows) {
				$data1 = array();

				while ($row = mysqli_fetch_assoc($result1)) {
					$data1[] = $row;
				}

				if ($result2->num_rows) {
					$data2 = array();
	
					while ($row = mysqli_fetch_assoc($result2)) {
						array_push($data2, $row['nombre']);
					}

					$data1[0]['documentos'] = implode(',', $data2);
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Aspirante cargado con éxito', 'DATA' => $data1);
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe el aspirante', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function obtener_aspirante_psicoorientador ($id) {
			$query = "SELECT u.id_estado_usuario_fk, du.documento, du.id_tipo_documento_fk, du.nombres, du.apellidos, du.correo, du.direccion, du.id_ciudad_fk, 
					IFNULL(du.telefono, '') AS telefono, du.celular, DATE_FORMAT(du.fecha_nacimiento, '%Y-%m-%d') as fecha_nacimiento, du.id_genero_fk, 
					du.id_preferencia_fk, du.id_tipo_sangre_fk, IFNULL(du.observacion, '') AS observacionn, d.id AS id_departamento_fk, m.anio, s.id AS id_sede_fk, 
					j.id AS id_jornada_fk, g.id AS id_grado_fk, m.observacion, m.id_estado_matricula_fk, IFNULL(m.id_curso_fk, '') AS id_curso_fk 
				FROM detalle_usuario du 
				INNER JOIN usuario u ON du.id_usuario_fk = u.id 
				INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
				INNER JOIN grado g ON m.id_grado_fk = g.id 
				INNER JOIN jornada j ON g.id_jornada_fk = j.id 
				INNER JOIN sede s ON j.id_sede_fk = s.id 
				INNER JOIN ciudad c ON du.id_ciudad_fk = c.id 
				INNER JOIN departamento d ON c.id_departamento_fk = d.id 
				WHERE u.id_rol_fk = 6 AND m.id_estado_matricula_fk IN (1, 2, 4) AND du.id = $id;";
			$result1 = $this->mysqli->query($query);

			$query = "SELECT dm.nombre FROM documento_matricula dm INNER JOIN matricula m ON dm.id_matricula_fk = m.id WHERE m.id_detalle_usuario_fk = $id;";
			$result2 = $this->mysqli->query($query);
			
			if ($result1->num_rows) {
				$data1 = array();

				while ($row = mysqli_fetch_assoc($result1)) {
					$data1[] = $row;
				}

				if ($result2->num_rows) {
					$data2 = array();
	
					while ($row = mysqli_fetch_assoc($result2)) {
						array_push($data2, $row['nombre']);
					}

					$data1[0]['documentos'] = implode(',', $data2);
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Aspirante cargado con éxito', 'DATA' => $data1);
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe el aspirante', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_aspirantes_secretaria ($anio, $sede, $jornada, $grado, $estado) {
			$query = "SELECT du.id, CONCAT(du.nombres, ' ', du.apellidos) AS nombre_aspirante, s.nombre AS nombre_sede, j.nombre AS nombre_jornada, 
					g.nombre AS nombre_grado, DATE_FORMAT(du.fecha_creacion, '%Y-%m-%d') AS fecha, em.nombre AS nombre_estado 
				FROM detalle_usuario du 
				INNER JOIN usuario u ON du.id_usuario_fk = u.id 
				INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
				INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id 
				INNER JOIN grado g ON m.id_grado_fk = g.id 
				INNER JOIN jornada j ON g.id_jornada_fk = j.id 
				INNER JOIN sede s ON j.id_sede_fk = s.id 
				WHERE u.id_rol_fk = 6";
        
			if (!empty($anio) || !empty($sede) || !empty($jornada) || !empty($grado) || !empty($estado)) {
				$count = 0;

				if (!empty($anio)) {
					$query .= " AND m.anio = $anio";
					$count++;
				}

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

				if (!empty($estado)) {
					$query .= " AND m.id_estado_matricula_fk = $estado";
				} else {
					$query .= " AND m.id_estado_matricula_fk IN (1, 2)";
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
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Aspirantes cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen aspirantes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function filtrar_aspirantes_psicoorientador ($anio, $sede, $jornada, $grado, $estado) {
			$query = "SELECT du.id, CONCAT(du.nombres, ' ', du.apellidos) AS nombre_aspirante, s.nombre AS nombre_sede, j.nombre AS nombre_jornada, 
					g.nombre AS nombre_grado, DATE_FORMAT(du.fecha_creacion, '%Y-%m-%d') AS fecha, em.nombre AS nombre_estado 
				FROM detalle_usuario du 
				INNER JOIN usuario u ON du.id_usuario_fk = u.id 
				INNER JOIN matricula m ON du.id = m.id_detalle_usuario_fk 
				INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id 
				INNER JOIN grado g ON m.id_grado_fk = g.id 
				INNER JOIN jornada j ON g.id_jornada_fk = j.id 
				INNER JOIN sede s ON j.id_sede_fk = s.id 
				WHERE u.id_rol_fk = 6";
        
			if (!empty($anio) || !empty($sede) || !empty($jornada) || !empty($grado) || !empty($estado)) {
				$count = 0;

				if (!empty($anio)) {
					$query .= " AND m.anio = $anio";
					$count++;
				}

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

				if (!empty($estado)) {
					$query .= " AND m.id_estado_matricula_fk = $estado";
				} else {
					$query .= " AND m.id_estado_matricula_fk IN (1, 2)";
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
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Aspirantes cargados con éxito', 'DATA' => $data);
				return json_encode($response);
	
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existen aspirantes', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function observar_aspirante_secretaria ($id, $observacion, $estado, $curso) {
			if (!empty($curso)) {
				$query = "SELECT COUNT(m.id) AS cantidad, IFNULL((SELECT p.cantidad_estudiantes FROM parametro p WHERE p.anio = (SELECT c.anio FROM curso c WHERE c.id = $curso)), 0) AS cantidad_estudiantes FROM matricula m WHERE m.id_curso_fk = $curso AND m.id_estado_matricula_fk = 3;";
				$result = $this->mysqli->query($query);

				if ($result->num_rows) {
					while ($row = mysqli_fetch_assoc($result)) {
						if ($row['cantidad'] >= $row['cantidad_estudiantes']) {
							$response = array('CODE' => 2, 'DESCRIPTION' => 'Ha llegado al límite de estudiantes permitidos por curso ('.$row['cantidad_estudiantes'].')', 'DATA' => array());
							return json_encode($response);
						}
					}
				}

				$query = "UPDATE matricula SET id_curso_fk = $curso, observacion = '$observacion', id_estado_matricula_fk = $estado WHERE id_detalle_usuario_fk = $id;";
				$result = $this->mysqli->query($query);
			} else {
				$query = "UPDATE matricula SET observacion = '$observacion', id_estado_matricula_fk = $estado WHERE id_detalle_usuario_fk = $id;";
				$result = $this->mysqli->query($query);
			}
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Observación realizada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al realizar la observación', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function observar_aspirante_psicoorientador ($id, $observacion, $estado) {
			$query = "UPDATE matricula SET observacion = '$observacion', id_estado_matricula_fk = $estado WHERE id_detalle_usuario_fk = $id;";
			$result = $this->mysqli->query($query);
			
			if ($result) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Observación realizada con éxito', 'DATA' => array());
				return json_encode($response);

			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al realizar la observación', 'DATA' => array());
				return json_encode($response);
			}
		}
	} 
?>