<?php
include('connection.php');
if (isset($_POST['id_inscripcion']) && isset($_POST['a_de_pago'])
    && isset($_POST['h_disponible']) && isset($_POST['g_estudiante'])
    && isset($_POST['c_mensual']) && isset($_POST['prox_fecha_pago'])
    && isset($_POST['n_acudiente']) && isset($_POST['tel_acudiente'])
    && isset($_POST['colegio']) && isset($_POST['c_registro'])) {

    $id_inscripcion = $_POST['id_inscripcion'];
    $a_de_pago = $_POST['a_de_pago'];
    $h_disponible = $_POST['h_disponible'];
    $g_estudiante = $_POST['g_estudiante'];
    $c_mensual = $_POST['c_mensual'];
    $prox_fecha_pago = $_POST['prox_fecha_pago'];
    $n_acudiente = $_POST['n_acudiente'];
    $tel_acudiente = $_POST['tel_acudiente'];
    $colegio = $_POST['colegio'];

    $query = "UPDATE `inscripcion` SET `acuerdo_pago`='$a_de_pago',`horario`='$h_disponible',`grado`='$g_estudiante',`costo`='$c_mensual',`fecha_pago`='$prox_fecha_pago',`acudiente_nombre`='$n_acudiente',`acudiente_telefono`='$tel_acudiente',`colegio`='$colegio' WHERE `codigo_registro` = '$id_inscripcion';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo $query;
        die('Fallo al actualizar la inscripcion.');
    }
    echo "Inscripcion actualizada exitosamente!";
}