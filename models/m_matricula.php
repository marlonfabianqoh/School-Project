<?php
	class M_matricula {
		private $mysqli;
		
		public function __construct () {
			$this->mysqli = Database::connection();
		}

		public function crear_matricula ($nombresAcudiente, $apellidosAcudiente, $correoAcudiente, $direccionAcudiente, $ciudadAcudiente, $telefonoAcudiente, $celularAcudiente, $usuario, $clave, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion, $anio, $grado, $documentos) {
			$query = "SELECT id FROM usuario WHERE usuario = '$usuario';";
			$result = $this->mysqli->query($query);

			if ($result->num_rows) {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'El usuario ingresado no se encuentra disponible', 'DATA' => array());
				return json_encode($response);	
			}
			
			$query = "SELECT m.id, m.id_estado_matricula_fk FROM matricula m INNER JOIN detalle_usuario du ON m.id_detalle_usuario_fk = du.id WHERE m.anio = $anio AND du.documento = '$documento';";
			$result = $this->mysqli->query($query);

			if ($result->num_rows) {
				while ($row = mysqli_fetch_assoc($result)) {
					if ($row['id_estado_matricula_fk'] != 4) {
						$response = array('CODE' => 2, 'DESCRIPTION' => 'El aspirante tiene una preinscripción en curso', 'DATA' => array());
						return json_encode($response);
					}
				}
			}

			$query = "INSERT INTO usuario (usuario, clave, id_rol_fk, id_estado_usuario_fk) VALUES ('$usuario', '".sha1($clave)."', 6, 1);";
			$result1 = $this->mysqli->query($query);

			$id_usuario = $this->mysqli->insert_id;

			$query = "INSERT INTO acudiente (nombres, apellidos, correo, direccion, id_ciudad_fk, telefono, celular) VALUES ('$nombresAcudiente', '$apellidosAcudiente', '$correoAcudiente', '$direccionAcudiente', $ciudadAcudiente, '$telefonoAcudiente', '$celularAcudiente');";
			$result2 = $this->mysqli->query($query);

			$id_acudiente = $this->mysqli->insert_id;

			$query = "INSERT INTO detalle_usuario (documento, id_tipo_documento_fk, nombres, apellidos, correo, direccion, id_ciudad_fk, telefono, celular, fecha_nacimiento, id_genero_fk, id_preferencia_fk, id_tipo_sangre_fk, id_usuario_fk, observacion) VALUES ('$documento', $tipo_documento, '$nombres', '$apellidos', '$correo', '$direccion', $ciudad, '$telefono', '$celular', '$fecha_nacimiento', $genero, $preferencia, $tipo_sangre, $id_usuario, '$observacion');";
			$result3 = $this->mysqli->query($query);

			$id_detalle_usuario = $this->mysqli->insert_id;

			$query = "INSERT INTO detalle_usuario_acudiente (id_detalle_usuario_fk, id_acudiente_fk) VALUES ($id_detalle_usuario, $id_acudiente);";
			$result4 = $this->mysqli->query($query);

			$query = "INSERT INTO matricula (anio, id_grado_fk, id_detalle_usuario_fk, id_estado_matricula_fk) VALUES ($anio, $grado, $id_detalle_usuario, 1);";
			$result5 = $this->mysqli->query($query);

			$id_matricula = $this->mysqli->insert_id;
			
			if (count($documentos)) {
				$query = "INSERT INTO documento_matricula (nombre, id_matricula_fk) VALUES";

				foreach ($documentos as $key => $value) {
					$query .= " ('$value', $id_matricula),";
				}

				$query = rtrim($query, ',');
				$query .= ";";
				$result6 = $this->mysqli->query($query);
			}
			
			if ($result1 && $result2 && $result3 && $result4 && $result5) {
				$response = array('CODE' => 1, 'DESCRIPTION' => 'Preinscripción creada con éxito', 'DATA' => array());
				return json_encode($response);
			} else {
				$response = array('CODE' => 2, 'DESCRIPTION' => 'Fallo al crear la preinscripción', 'DATA' => array());
				return json_encode($response);
			}
		}

		public function consultar_matricula ($anio, $documento) {
			$query = "SELECT m.id, m.id_estado_matricula_fk, em.nombre, m.observacion FROM matricula m INNER JOIN estado_matricula em ON m.id_estado_matricula_fk = em.id INNER JOIN detalle_usuario du ON m.id_detalle_usuario_fk = du.id WHERE m.anio = $anio AND du.documento = '$documento';";
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

		function subir_archivo ($archivo) {
			if ($archivo['name'] != "") {
				$target_dir = "files/";
				$file = $archivo['name'];
				$path = pathinfo($file);
				$filename = '';
				$keys = array_merge(range(0, 9), range('a', 'z'));

				for ($i = 0; $i < 20; $i++) {
					$filename .= $keys[array_rand($keys)];
				}

				$ext = $path['extension'];
				$temp_name = $archivo['tmp_name'];
				$path_filename_ext = $target_dir.$filename.".".$ext;
				 
				if (!file_exists($path_filename_ext)) {
					move_uploaded_file($temp_name,$path_filename_ext);
					return $filename.".".$ext;
				}
			}
		}
	} 
?>