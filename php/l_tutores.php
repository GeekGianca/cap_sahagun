<?php
include ('connection.php');
$query = "SELECT * FROM `tutores`;";
$result = mysqli_query($connection, $query);
if (!$result){
    die('Query error!'.mysqli_error($connection));
}
$response = array();
while($row = mysqli_fetch_array($result)){
    $response[] = array(
        'id_tutor' => $row['identificacion'],
        'n_tutor' => $row['nombre'],
        'a_tutor' => $row['apellidos'],
        'c_tutor' => $row['correo'],
        't_tutor' => $row['telefono'],
        'd_tutor' => $row['direccion']
    );
}
$jsonString = json_encode($response);
echo $jsonString;