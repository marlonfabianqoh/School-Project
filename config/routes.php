<?php
	function cargar_controlador ($controlador) {
		$archivo = 'controllers/'.$controlador.'.php';
		require_once $archivo;
		$control = new $controlador();
		return $control;
	}
	
	function cargar_accion($controlador, $accion){
		if(isset($accion) && method_exists($controlador, $accion)){
			$controlador->$accion();
		}	
	}
?>