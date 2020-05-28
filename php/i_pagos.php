<?php
include ('connection.php');
if(isset($_POST['cod_pago']) && isset($_POST['fec_pago'])
    && isset($_POST['hor_pago']) && isset($_POST['val_pagar'])
    && isset($_POST['val_restante']) && isset($_POST['cod_registro'])){

    $cod_pago = $_POST['cod_pago'];
    $fec_pago = $_POST['fec_pago'];
    $hor_pago= $_POST['hor_pago'];
    $val_pagar = $_POST['val_pagar'];
    $val_restante = $_POST['val_restante'];
    $cod_registro = $_POST['cod_registro'];

    $query = "INSERT INTO `pagos`(`codigo_pago`, `fecha_pago`, `hora_pago`, `valor_pagado`, `valor_restante`, `codigo_registro_inscripcion`) VALUES ('$cod_pago','$fec_pago','$hor_pago','$val_pagar','$val_restante','$cod_registro');";
    $result = mysqli_query($connection, $query);
    if (!$result){
        echo $query;
        die('Fallo al registrar el pago');
    }
    echo "Pago registrado exitosamente!";
}