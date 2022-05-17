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

    if (isset($option) && $option == "usuarios-listar") {
        $query = "SELECT ud.id, ud.nombres, ud.apellidos, ud.correo, ud.direccion, 
        (SELECT d.id FROM departamento d INNER JOIN ciudad c ON c.id_departamento_fk = d.id WHERE c.id = ud.id_ciudad_fk) AS id_departamento_fk,
        ud.id_ciudad_fk, ud.telefono, ud.celular, ud.fecha_nacimiento, ud.id_genero_fk, ud.id_estado_fk, ud.id_preferencia_fk, ud.id_tipo_sangre_fk, ud.observacion, u.id_rol_fk, 
        (SELECT r.nombre FROM rol r WHERE r.id = u.id_rol_fk) AS nombre_rol, IFNULL(u.fecha_conexion, '') as fecha_conexion FROM usuario_detalle ud JOIN usuario u ON ud.id_usuario_fk = u.id";

        if (!empty($id)) {
            $query .= " WHERE ud.id = $id";
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

            $response = array('STATUS' => true, 'MESSAGE' => 'Usuario(s) cargada(s) con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existe(n) usuario(s)', 'DATA' => array());
            echo json_encode($response);
        }
    }

    if (isset($option) && $option == "usuarios-buscar") {
        $query = "SELECT ud.id, ud.nombres, ud.apellidos, ud.correo, ud.direccion, 
        (SELECT d.id FROM departamento d INNER JOIN ciudad c ON c.id_departamento_fk = d.id WHERE c.id = ud.id_ciudad_fk) AS id_departamento_fk,
        ud.id_ciudad_fk, ud.telefono, ud.celular, ud.fecha_nacimiento, ud.id_genero_fk, ud.id_estado_fk, ud.id_preferencia_fk, ud.id_tipo_sangre_fk, ud.observacion, u.id_rol_fk, 
        (SELECT r.nombre FROM rol r WHERE r.id = u.id_rol_fk) AS nombre_rol, IFNULL(u.fecha_conexion, '') as fecha_conexion FROM usuario_detalle ud JOIN usuario u ON ud.id_usuario_fk = u.id";
        
        if (!empty($nombres) || !empty($apellidos) || !empty($documento) || !empty($correo)) {
            $count = 0;
            $query .= " WHERE";

            if (!empty($nombres)) {
                $count++;
                $query .= " ud.nombres LIKE '%$nombres%'";
            }

            if (!empty($apellidos)) {
                $count++;
                if ($count > 0) {
                    $query .= " OR ud.apellidos LIKE '%$apellidos%'";
                } else {
                    $query .= " ud.apellidos LIKE '%$apellidos%'";
                }
            }

            if (!empty($documento)) {
                $count++;

                if ($count > 0) {
                    $query .= " OR ud.documento LIKE '%$documento%'";
                } else {
                    $query .= " ud.documento LIKE '%$documento%'";
                }
            }

            if (!empty($correo)) {
                $count++;

                if ($count > 0) {
                    $query .= " OR ud.correo LIKE '%$correo%'";
                } else {
                    $query .= " ud.correo LIKE '%$correo%'";
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

            $response = array('STATUS' => true, 'MESSAGE' => 'Usuario(s) cargada(s) con éxito', 'DATA' => $data);
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'No existe(n) usuario(s)', 'DATA' => array());
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

    if (isset($option) && $option == "usuarios-eliminar") {
        $query = "SELECT id_usuario_fk FROM usuario_detalle WHERE id = $id;";
        $result = $mysqli->query($query);
        $row = mysqli_fetch_assoc($result);

        $query1 = "DELETE FROM usuario_detalle WHERE id = $id;";
        $result1 = $mysqli->query($query);

        $query2 = "DELETE FROM usuario WHERE id = ".$row['id_usuario_fk'].";";
        $result2 = $mysqli->query($query);
        
        if ($result1 && $result2) {
            $response = array('STATUS' => true, 'MESSAGE' => 'Usuario eliminado con éxito', 'DATA' => array());
            echo json_encode($response);

        } else {
            $response = array('STATUS' => false, 'MESSAGE' => 'Fallo al eliminar el usuario', 'DATA' => array());
            echo json_encode($response);
        }
    }
?>