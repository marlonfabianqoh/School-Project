<?php
	require_once "config.php";

	class Database {
		public static function connection () {
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if ($mysqli -> connect_errno) {
				echo "Fallo la conexión a la base de datos: " . $mysqli -> connect_error;
				exit();
			} else {
				return $mysqli;
			}
		}
	}
?>