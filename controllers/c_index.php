<?php
    require "connection.php";

    if(isset($_POST)) {
        $array = $_POST;
        $keys = array_keys($array);

        if(is_array($keys)){
            for($i = 0; $i < count($keys); $i++){
                $nombre = $keys[$i];
                $comando = "$" . $nombre . " = \$_POST['$nombre'];";
                eval($comando);
            }
        }
    }

    if(isset($form) && $form == "form-login"){
        $query = "SELECT id, usuario, id_rol_fk FROM usuario WHERE usuario = '$txtUser' AND clave = '".sha1($txtPassword)."';";
        $result = $mysqli->query($query);
        
        if($result->num_rows){
            $row = $result->fetch_assoc();

            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['rol'] = $row['id_rol_fk'];

            $response = array('STATUS' => true, 'MESSAGE' => 'Inicio de sesión éxitoso');
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Usuario y/o contraseña incorrecto(s)');
            echo json_encode($response);
        }
    }
?>