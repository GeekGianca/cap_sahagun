<?php
include ('connection.php');
$query = "SELECT inscripcion.codigo_registro, estudiante.nombre, estudiante.apellidos, inscripcion.fecha_pago,inscripcion.fecha_ingreso, inscripcion.acudiente_telefono, inscripcion.colegio FROM inscripcion INNER JOIN estudiante ON estudiante.identificacion = inscripcion.estudiante_identificacion;";
$result = mysqli_query($connection, $query);
if (!$result){
    die('Query error!'.mysqli_error($connection));
}
$response = array();
while($row = mysqli_fetch_array($result)){
    $response[] = array(
        'id' => $row['codigo_registro'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'fecha_pago' => $row['fecha_pago'],
        'fecha_ingreso' => $row['fecha_ingreso'],
        'a_telefono' => $row['acudiente_telefono'],
        'colegio' => $row['colegio'],
    );
}
$jsonString = json_encode($response);
echo $jsonString;