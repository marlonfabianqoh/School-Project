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

    if (isset($option) && $option == "departamentos-listar") {
        $query = "SELECT id, nombre, codigo FROM departamento;";
        $result = $mysqli->query($query);
        
        if ($result->num_rows) {
            $data = array();

            if ($result->num_rows) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }

            $response = array('STATUS' => true, 'MESSAGE' => 'Departamentos cargados con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existen sedes', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "ciudades-listar") {
        $query = "SELECT id, nombre, codigo, id_departamento_fk FROM ciudad";

        if (!empty($departamento)) {
            $query .= " WHERE id_departamento_fk = $departamento";
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

            $response = array('STATUS' => true, 'MESSAGE' => 'Ciudades cargadas con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existen sedes', 'DATA' => array());
            echo json_encode($response);
        }
    }
?>