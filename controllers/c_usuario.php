<?php
	class C_usuario {
		public function __construct(){
			require_once "models/m_usuario.php";
		}
		
		public function listar () {
			$usuario = new M_usuario();
			$response = $usuario->obtener_usuarios();
			echo $response;
		}

		public function buscar () {
			$id = $_POST['id'];

			$usuario = new M_usuario();
			$response = $usuario->obtener_usuario($id);
			echo $response;
		}

		public function filtrar () {
			$user = $_POST['usuario'];
			$nombre = $_POST['nombre'];
			$rol = $_POST['rol'];
			$estado = $_POST['estado'];
			
			$usuario = new M_usuario();
			$response = $usuario->filtrar_usuarios($user, $nombre, $rol, $estado);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$user = $_POST['txtUser'];
			$clave = $_POST['txtPass'];
			$rol = $_POST['selRole'];
			$estado = $_POST['selStatus'];
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

			$usuario = new M_usuario();

			if (empty($id)) {
				$response = $usuario->crear_usuario($user, $clave, $rol, $estado, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion);
			} else {
				$response = $usuario->editar_usuario($id, $user, $clave, $rol, $estado, $documento, $tipo_documento, $nombres, $apellidos, $correo, $direccion, $ciudad, $telefono, $celular, $fecha_nacimiento, $genero, $preferencia, $tipo_sangre, $observacion);
			}

			echo $response;
		}

		public function eliminar () {
			$id = $_POST['id'];

			$usuario = new M_usuario();
			$response = $usuario->eliminar_usuario($id);
			echo $response;
		}
	}
?>