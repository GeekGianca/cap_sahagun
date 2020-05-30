<?php
include('connection.php');
if (isset($_POST['id_horario'])) {
    $id = $_POST['id_horario'];
    $query = "SELECT horario.codigo, horario.fecha, horario.hora, horario.semana, tutores.nombre, tutores.apellidos, estudiante.nombre, estudiante.apellidos, horario.asistencia FROM ((horario INNER JOIN tutores ON tutores.identificacion = horario.identificacion_tutor_horario) INNER JOIN estudiante ON estudiante.identificacion = horario.est_identificacion) WHERE horario.codigo = '$id';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Error de seleccion ' . mysqli_error($connection));
    }
    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array(
            'codigo' => $row['codigo'],
            'fecha' => $row['fecha'],
            'hora' => $row['hora'],
            't_nombre' => $row['t_nombre'],
            't_apellidos	' => $row['t_apellidos	'],
            'e_nombre' => $row['e_nombre'],
            'e_apellidos' => $row['e_apellidos'],
            'asistencia' => $row['asistencia'],
            'semana' => $row['semana'],
        );
    }
    $res = json_encode($response[0]);
    echo $res;
}