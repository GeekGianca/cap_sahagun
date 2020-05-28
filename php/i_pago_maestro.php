<?php
include ('connection.php');
if(isset($_POST['cod_tutor_pago']) && isset($_POST['cod_caja_pago'])
    && isset($_POST['val_tutor_pago'])){

    $cod_tutor_pago = $_POST['cod_tutor_pago'];
    $cod_caja_pago = $_POST['cod_caja_pago'];
    $val_tutor_pago = $_POST['val_tutor_pago'];

    $query = "INSERT INTO `pagos_tutores`(`control_codigo_control`, `tutor_identificacion`, `valor_pagado`) VALUES ('$cod_caja_pago','$cod_tutor_pago','$val_tutor_pago');";
    $result = mysqli_query($connection, $query);
    if (!$result){
        echo $query;
        die('Fallo al registrar el pago');
    }
    echo "Pago registrado exitosamente!";
}