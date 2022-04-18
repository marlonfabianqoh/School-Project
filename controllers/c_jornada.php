<?php
    require "connection.php";

    if (isset($_POST)) {
        $array = $_POST;
        $keys = array_keys($array);

        if (is_array($keys)) {
            for ($i = 0; $i < count($keys); $i++) {
                $name = $keys[$i];
                $command = "$" . $name . " = \$_POST['$name'];";
                eval($command);
            }
        }
    }

    if (isset($option) && $option == "jornadas-listar") {
        $query = "SELECT id, nombre, IFNULL(observacion, '') as observacion FROM jornada";
        
        if (!empty($id)) {
            $query .= " WHERE id = $id";
        }

        $query .= ";";
        $result = $mysqli->query($query);
        
        if ($result->num_rows) {
            $data = array();

            if ($result->num_rows) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }

            $response = array('STATUS' => true, 'MESSAGE' => 'Jornada(s) cargada(s) con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existe(n) jornada(s)', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "jornadas-buscar") {
        $query = "SELECT id, nombre, IFNULL(observacion, '') as observacion FROM jornada";
        
        if (!empty($nombre)) {
            $query .= " WHERE nombre LIKE '%$nombre%'";
        }

        $query .= ";";
        $result = $mysqli->query($query);
        
        if ($result->num_rows) {
            $data = array();

            if ($result->num_rows) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }

            $response = array('STATUS' => true, 'MESSAGE' => 'Jornada(s) cargada(s) con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existe(n) jornada(s)', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "jornadas-crear") {
        $query = "INSERT INTO jornada (nombre, observacion) VALUES ('$txtName', '$txtObservation');";
        $result = $mysqli->query($query);
        
        if ($result) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Jornada creada con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al crear la jornada', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "jornadas-editar") {
        $query = "UPDATE jornada SET nombre = '$txtName', observacion = '$txtObservation' WHERE id = $id";
        $result = $mysqli->query($query);
        
        if ($result) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Jornada actualizada con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al actualizar la jornada', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "jornadas-eliminar") {
        $query = "DELETE FROM jornada WHERE id = $id;";
        $result = $mysqli->query($query);
        
        if ($result) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Jornada eliminada con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al eliminar la jornada', 'DATA' => array());
            echo json_encode($response);
        }
    }
?>