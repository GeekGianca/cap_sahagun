<?php
include('connection.php');
if (isset($_POST['id_tutor'])) {
    $id = $_POST['id_tutor'];
    $query = "SELECT * FROM `tutores` WHERE `identificacion` = '$id' LIMIT 1;";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Error de seleccion ' . mysqli_error($connection));
    }
    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array(
            'id_tutor' => $row['identificacion'],
            'n_tutor' => $row['nombre'],
            'a_tutor' => $row['apellidos'],
            'c_tutor' => $row['correo'],
            't_tutor' => $row['telefono'],
            'd_tutor' => $row['direccion']
        );
    };
    $res = json_encode($response[0]);
    echo $res;
}