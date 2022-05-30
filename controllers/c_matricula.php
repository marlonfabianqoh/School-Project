<?php
	class C_matricula {
		public function __construct(){
			require_once "models/m_matricula.php";
		}

		public function guardar () {
			$nombresAcudiente = $_POST['txtNameAttendant'];
			$apellidosAcudiente = $_POST['txtLastNameAttendant'];
			$correoAcudiente = $_POST['txtEmailAttendant'];
			$direccionAcudiente = $_POST['txtAddressAttendant'];
			$ciudadAcudiente = $_POST['selCityAttendant'];
			$telefonoAcudiente = $_POST['txtPhoneAttendant'];
			$celularAcudiente = $_POST['txtMobileAttendant'];
			
			$usuario = $_POST['txtUser'];
			$clave = $_POST['txtPass'];

			$documento = $_POST['txtId'];
			$tipo_documento = $_POST['selTypeId'];
			$nombres = $_POST['txtName'];
			$apellidos = $_POST['txtLastName'];
			$correo = $_POST['txtEmail'];
			$direccion = $_POST['txtAddress'];
			$ciudad = $_POST['selCity'];
			$telefono = $_POST['txtPhone'];
			$celular = $_POST['txtMobile'];
			$fecha_nacimiento = $_POST['txtDate'];
			$genero = $_POST['selGender'];
			$preferencia = $_POST['selPreference'];
			$tipo_sangre = $_POST['selTypeBlood'];
			$observacion = $_POST['txtObservation'];
			$anio = $_POST['selYear'];
			$grado = $_POST['selGrade'];

			$matricula = new M_matricula();

			$bool = true;
			$count = 0;
			$documentos = array();
			
			$tipo_documentos = array();

			if (!empty($_POST['tipo_documentos'])) {
				$tipo_documentos = explode(',', $_POST['tipo_documentos']);
			}
			
			while ($bool) {
				if (isset($_FILES['txtFile'.$count])) {
					$documentos[] = $matricula->subir_archivo($_FILES['txtFile'.$count]);
					$count++;
				} else {
					$bool = false;
				}
			}

			$response = $matricula->crear_matricula($nombresAcudiente, $apellidosAcudiente, $correoAcudiente, $direccionAcudiente, $ciudadAcudiente, $telefonoAcudiente, $celularAcudiente, $usuario, $clave, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion, $anio, $grado, $documentos, $tipo_documentos);
			echo $response;
		}

		public function consultar () {
			$anio = $_POST['selYear'];
			$documento = $_POST['txtId'];

			$matricula = new M_matricula();
			$response = $matricula->consultar_matricula($anio, $documento);
			echo $response;
		}
	}
?>