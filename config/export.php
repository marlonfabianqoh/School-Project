<?php
    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Content-Disposition: filename=usuarios.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    if (isset($_POST['data_to_send']) && $_POST['data_to_send'] != '') {
        echo $_POST['data_to_send'];
    }
?>