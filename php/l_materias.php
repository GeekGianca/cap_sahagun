<?php
include ('connection.php');
$query = "SELECT estudiante.identificacion, CONCAT(estudiante.nombre, ' ', estudiante.apellidos) as nombre, materias.codigo_materia, materias.nombre_materia FROM materias INNER JOIN estudiante ON estudiante.identificacion = materias.identificacion_estudiante;";
$result = mysqli_query($connection, $query);
if (!$result){
    die('Query error!'.mysqli_error($connection));
}
$response = array();
while($row = mysqli_fetch_array($result)){
    $response[] = array(
        'identificacion' => $row['identificacion'],
        'nombre' => $row['nombre'],
        'codigo_materia' => $row['codigo_materia'],
        'nombre_materia' => $row['nombre_materia']
    );
}
$jsonString = json_encode($response);
echo $jsonString;