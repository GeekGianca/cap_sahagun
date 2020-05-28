<?php
$query = "SELECT * FROM `pagos_tutores` ;";
$result = mysqli_query($connection, $query);
if (!$result){
    die('Query error!'.mysqli_error($connection));
}
$response = array();
while($row = mysqli_fetch_array($result)){
    $response[] = array(
        'codigo' => $row['control_codigo_control'],
        'fecha' => $row[''],
        'id_tutor' => $row['tutor_identificacion'],
        'valor_pagado' => $row['valor_pagado']
    );
}
$jsonString = json_encode($response);
echo $jsonString;