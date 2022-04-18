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

    if (isset($option) && $option == "sedes-listar") {
        $query = "SELECT s.id, s.nombre, s.direccion, (SELECT d.id FROM departamento d INNER JOIN ciudad c ON c.id_departamento_fk = d.id WHERE c.id = s.id_ciudad_fk) AS id_departamento_fk, s.id_ciudad_fk, s.telefono, IFNULL(s.observacion, '') as observacion FROM sede s";
        
        if (!empty($id)) {
            $query .= " WHERE s.id = $id";
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

            $response = array('STATUS' => true, 'MESSAGE' => 'Sede(s) cargada(s) con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existe(n) sede(s)', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "sedes-buscar") {
        $query = "SELECT s.id, s.nombre, s.direccion, (SELECT d.id FROM departamento d INNER JOIN ciudad c ON c.id_departamento_fk = d.id WHERE c.id = s.id_ciudad_fk) AS id_departamento_fk, s.id_ciudad_fk, s.telefono, IFNULL(s.observacion, '') as observacion FROM sede s";
        
        if (!empty($nombre) || !empty($ciudad)) {
            $count = 0;
            $query .= " WHERE";

            if (!empty($nombre)) {
                $count++;
                $query .= " s.nombre LIKE '%$nombre%'";
            }

            if (!empty($ciudad)) {
                if ($count > 0) {
                    $query .= " OR s.id_ciudad_fk = $ciudad";
                } else {
                    $query .= " s.id_ciudad_fk = $ciudad";
                }
            }

            $query .= ";";
        }

        $result = $mysqli->query($query);
        
        if ($result->num_rows) {
            $data = array();

            if ($result->num_rows) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }

            $response = array('STATUS' => true, 'MESSAGE' => 'Sedes cargadas con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existen sedes', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "sedes-crear") {
        $query = "INSERT INTO sede (nombre, direccion, id_ciudad_fk, telefono, observacion) VALUES ('$txtName', '$txtAddress', $selCity, '$txtPhone', '$txtObservation');";
        $result = $mysqli->query($query);
        
        if ($result) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Sede creada con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al crear la sede', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "sedes-editar") {
        $query = "UPDATE sede SET nombre = '$txtName', direccion = '$txtAddress', id_ciudad_fk =  $selCity, telefono = '$txtPhone', observacion = '$txtObservation' WHERE id = $id";
        $result = $mysqli->query($query);
        
        if ($result) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Sede creada con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al crear la sede', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "sedes-eliminar") {
        $query = "DELETE FROM sede WHERE id = $id;";
        $result = $mysqli->query($query);
        
        if ($result) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Sede eliminada con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al eliminar la sede', 'DATA' => array());
            echo json_encode($response);
        }
    }
?>