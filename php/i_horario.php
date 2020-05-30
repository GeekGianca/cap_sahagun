<?php
include ('connection.php');
if(isset($_POST['f_horarios']) && isset($_POST['h_horario'])
    && isset($_POST['t_horario']) && isset($_POST['s_horario'])
    && isset($_POST['est_horario']) && isset($_POST['as_horario'])){

    $f_horarios = $_POST['f_horarios'];
    $h_horario = $_POST['h_horario'];
    $t_horario = $_POST['t_horario'];
    $s_horario = $_POST['s_horario'];
    $est_horario = $_POST['est_horario'];
    $as_horario = $_POST['as_horario'];

    $query = "INSERT INTO `horario`(`fecha`, `hora`, `identificacion_tutor_horario`, `semana`, `asistencia`, `est_identificacion`) VALUES ('$f_horarios','$h_horario','$t_horario','$s_horario','$as_horario','$est_horario');";
    $result = mysqli_query($connection, $query);
    if (!$result){
        die('Fallo al registrar el horario' . mysqli_error($connection));
    }
    echo "Horario registrado exitosamente.";
}