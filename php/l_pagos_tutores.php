<?php
include('connection.php');
$dateT = date('Y-m-d');
$query = "SELECT pagos_tutores.control_codigo_control, tutores.nombre, tutores.apellidos, control.creacion_caja, pagos_tutores.valor_pagado FROM ((pagos_tutores INNER JOIN tutores ON tutores.identificacion = pagos_tutores.tutor_identificacion) INNER JOIN control ON control.codigo_control = pagos_tutores.control_codigo_control);";
$result = mysqli_query($connection, $query);
if (!$result) {
    die('Error de seleccion ' . mysqli_error($connection));
}
$response = array();
while ($row = mysqli_fetch_array($result)) {
    $response[] = array(
        'c_control' => $row['control_codigo_control'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'cre_caja' => $row['creacion_caja'],
        'val_pagado' => $row['valor_pagado']
    );
};
$res = json_encode($response);
echo $res;