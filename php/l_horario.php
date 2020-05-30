<?php
include ('connection.php');
$query = "SELECT horario.codigo, horario.fecha, horario.hora, tutores.nombre as t_nombre, tutores.apellidos as t_apellidos, estudiante.nombre as e_nombre, estudiante.apellidos as e_apellidos, horario.asistencia FROM ((horario INNER JOIN tutores ON tutores.identificacion = horario.identificacion_tutor_horario) INNER JOIN estudiante ON estudiante.identificacion = horario.est_identificacion);";
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
        't_nombre' => $row['t_nombre'],
        't_apellidos	' => $row['t_apellidos	'],
        'e_nombre' => $row['e_nombre'],
        'e_apellidos' => $row['e_apellidos'],
        'asistencia' => $row['asistencia']
    );
}
$jsonString = json_encode($response);
echo $jsonString;