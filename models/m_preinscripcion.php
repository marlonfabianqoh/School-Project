<?php
	class M_preinscripcion {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}

		public function crear_preinscripcion ($nombresAcudiente, $apellidosAcudiente, $correoAcudiente, $direccionAcudiente, $ciudadAcudiente, $telefonoAcudiente, $celularAcudiente, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion, $anio, $grado) {
			$query = "SELECT i.id, i.id_estado_inscripcion_fk FROM inscripcion i INNER JOIN detalle_usuario du ON i.id_detalle_usuario_fk = du.id WHERE du.documento = '$documento';";
			$result = $this->mysqli->query($query);

			if ($result->num_rows) {
				if ($result['id_estado_inscripcion_fk'] != 4) {
					$response = array('CODE' => 2, 'DESCRIPTION' => 'El aspirante tiene una preinscripción en curso', 'DATA' => array());
					return json_encode($response);
				}
			}

			$query = "INSERT INTO acudiente (nombres, apellidos, correo, direccion, id_ciudad_fk, telefono, celular) VALUES ('$nombresAcudiente', '$apellidosAcudiente', '$correoAcudiente', '$direccionAcudiente', $ciudadAcudiente, '$telefonoAcudiente', '$celularAcudiente');";
			$result1 = $this->mysqli->query($query);

			$id_acudiente = $this->mysqli->insert_id;

			$query = "INSERT INTO detalle_usuario (documento, id_tipo_documento_fk, nombres, apellidos, correo, direccion, id_ciudad_fk, telefono, celular, fecha_nacimiento, id_genero_fk, id_preferencia_fk, id_tipo_sangre_fk, observacion) VALUES ('$documento', $tipo_documento, '$nombres', '$apellidos', '$correo', '$direccion', $ciudad, '$telefono', '$celular', '$fecha_nacimiento', $genero, $preferencia, $tipo_sangre, '$observacion');";
			$result2 = $this->mysqli->query($query);

			$id_detalle_usuario = $this->mysqli->insert_id;

			$query = "INSERT INTO detalle_usuario_acudiente (id_detalle_usuario_fk, id_acudiente_fk) VALUES ($id_detalle_usuario, $id_acudiente);";
			$result3 = $this->mysqli->query($query);

			$query = "INSERT INTO inscripcion (id_detalle_usuario_fk, id_grado_fk, id_estado_inscripcion_fk, anio) VALUES ($id_detalle_usuario, $grado, 1, $anio);";
			$result4 = $this->mysqli->query($query);
			
			if ($result1 && $result2 && $result3 && $result4) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Preinscripción creada con éxito', 'DATA' => array());
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear la preinscripción', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function consultar_preinscripcion ($anio, $documento) {
			$query = "SELECT i.id, i.id_estado_inscripcion_fk, ei.nombre, i.observacion FROM inscripcion i INNER JOIN estado_inscripcion ei ON i.id_estado_inscripcion_fk = ei.id INNER JOIN detalle_usuario du ON i.id_detalle_usuario_fk = du.id WHERE i.anio = $anio AND du.documento = '$documento';";
			$result = $this->mysqli->query($query);
			
			if ($result->num_rows) {
				$data = array();
	
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = $row;
				}
	
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Preinscripción cargada con éxito', 'DATA' => $data);
				echo json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'No existe preinscripción', 'DATA' => array());
				echo json_encode($response);
			}
		}
	} 
?>