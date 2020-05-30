<?php
include ('connection.php');
$query = "SELECT * FROM `estudiante`;";
$result = mysqli_query($connection, $query);
if (!$result){
    die('Query error!'.mysqli_error($connection));
}
$response = array();
while($row = mysqli_fetch_array($result)){
    $response[] = array(
        'id' => $row['identificacion'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'f_nacimiento' => $row['fecha_nacimiento']
    );
}
$jsonString = json_encode($response);
echo $jsonString;