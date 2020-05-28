<?php
include('connection.php');
if (isset($_POST['c_horario']) && isset($_POST['f_horarios']) && isset($_POST['h_horario'])
    && isset($_POST['t_horario']) && isset($_POST['s_horario'])
    && isset($_POST['est_horario']) && isset($_POST['as_horario'])) {

    $f_horarios = $_POST['f_horarios'];
    $h_horario = $_POST['h_horario'];
    $t_horario = $_POST['t_horario'];
    $s_horario = $_POST['s_horario'];
    $est_horario = $_POST['est_horario'];
    $as_horario = $_POST['as_horario'];
    $c_horario = $_POST['c_horario'];

    $query = "UPDATE `horario` SET `fecha`='$f_horarios',`hora`='$h_horario',`identificacion_tutor_horario`='$t_horario',`semana`='$s_horario',`asistencia`='$as_horario',`est_identificacion`='$est_horario' WHERE `codigo` = '$c_horario';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo $query;
        die('Fallo al actualizar el horario');
    }
    echo "Horario actualizado exitosamente!";
}