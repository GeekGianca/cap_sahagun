<?php
include('connection.php');
if (isset($_POST['id_est_reg'])) {
    $id = $_POST['id_est_reg'];
    $query = "SELECT inscripcion.codigo_registro, inscripcion.costo FROM inscripcion INNER JOIN estudiante ON estudiante.identificacion = inscripcion.estudiante_identificacion WHERE inscripcion.codigo_registro = '$id';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die('Error de seleccion ' . mysqli_error($connection));
    }
    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array(
            'codigo_registro' => $row['codigo_registro'],
            'costo' => $row['costo']
        );
    };
    $res = json_encode($response[0]);
    echo $res;
}