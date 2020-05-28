<?php
include ('connection.php');
$query = "SELECT * FROM `horario`;";
$result = mysqli_query($connection, $query);
if (!$result){
    die('Query error!'.mysqli_error($connection));
}
$response = array();
while($row = mysqli_fetch_array($result)){
    $response[] = array(
        'codigo' => $row['codigo'],
        'fecha' => $row['fecha'],
        'hora' => $row['hora'],
        'id_tutor' => $row['identificacion_tutor_horario'],
        'semana' => $row['semana'],
        'asistencia' => $row['asistencia'],
        'id_estudiante' => $row['est_identificacion']
    );
}
$jsonString = json_encode($response);
echo $jsonString;