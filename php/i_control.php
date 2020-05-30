<?php
include('connection.php');
$id_cod = rand(1, 900000);
$dateT = date('Y-m-d');
$query = "INSERT INTO `control`(`codigo_control`, `fecha_corte`, `creacion_caja`, `entrada`, `salida`, `caja`) VALUES ('$id_cod', null, '$dateT',0,0,0);";
$result = mysqli_query($connection, $query);
if (!$result){
    echo $query;
    die('Fallo al registrar el control de pago'.$result);
}
echo "Control de pago registrado exitosamente!";