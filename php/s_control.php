<?php
include('connection.php');
$dateT = date('Y-m-d');
$query = "SELECT * FROM `control` WHERE `creacion_caja` = '$dateT';";
$result = mysqli_query($connection, $query);
if (!$result) {
    die('Error de seleccion ' . mysqli_error($connection));
}
$response = array();
while ($row = mysqli_fetch_array($result)) {
    $response[] = array(
        'codigo_control' => $row['codigo_control'],
        'fecha_corte' => $row['fecha_corte'],
        'creacion_caja' => $row['creacion_caja'],
        'entrada' => $row['entrada'],
        'salida' => $row['salida'],
        'caja' => $row['caja']
    );
};
$res = json_encode($response[0]);
echo $res;

