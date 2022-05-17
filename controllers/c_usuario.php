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
			$usuarion = $_POST['usuario'];
			$nombre = $_POST['nombre'];
			$rol = $_POST['rol'];
			$estado = $_POST['estado'];
			
			$usuario = new M_usuario();
			$response = $usuario->filtrar_usuarios($usuarion, $nombre, $rol, $estado);
			echo $response;
		}

		public function guardar () {
			$id = $_POST['id'];
			$nombre = $_POST['txtName'];
			$direccion = $_POST['txtAddress'];
			$ciudad = $_POST['selCity'];
			$telefono = $_POST['txtPhone'];
			$observacion = $_POST['txtObservation'];

			$usuario = new M_usuario();

			if (empty($id)) {
				$response = $usuario->crear_usuario($nombre, $direccion, $ciudad, $telefono, $observacion);
			} else {
				$response = $usuario->editar_usuario($id, $nombre, $direccion, $ciudad, $telefono, $observacion);
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