<?php
include('connection.php');
if (isset($_POST['id_estudiante']) && isset($_POST['n_estudiante'])
    && isset($_POST['a_estudiante']) && isset($_POST['f_nacimiento'])
    && isset($_POST['f_horario']) && isset($_POST['a_de_pago'])
    && isset($_POST['h_disponible']) && isset($_POST['g_estudiante'])
    && isset($_POST['c_mensual']) && isset($_POST['prox_fecha_pago'])
    && isset($_POST['n_acudiente']) && isset($_POST['tel_acudiente'])
    && isset($_POST['colegio']) && isset($_POST['c_registro'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $n_estudiante = $_POST['n_estudiante'];
    $a_estudiante = $_POST['a_estudiante'];
    $f_nacimiento = $_POST['f_nacimiento'];

    $c_registro = $_POST['c_registro'];
    $f_horario = $_POST['f_horario'];
    $a_de_pago = $_POST['a_de_pago'];
    $h_disponible = $_POST['h_disponible'];
    $g_estudiante = $_POST['g_estudiante'];
    $c_mensual = $_POST['c_mensual'];
    $prox_fecha_pago = $_POST['prox_fecha_pago'];
    $n_acudiente = $_POST['n_acudiente'];
    $tel_acudiente = $_POST['tel_acudiente'];
    $colegio = $_POST['colegio'];


    $query = "INSERT INTO `estudiante`(`identificacion`, `nombre`, `apellidos`, `fecha_nacimiento`) VALUES ('$id_estudiante','$n_estudiante','$a_estudiante','$f_nacimiento');";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo $query;
        die('Fallo al registrar el estudiante');
    } else {
        $subQuery = "INSERT INTO `inscripcion`(`codigo_registro`, `fecha_ingreso`, `acuerdo_pago`, `horario`, `grado`, `costo`, `fecha_pago`, `acudiente_nombre`, `acudiente_telefono`, `colegio`, `estudiante_identificacion`) VALUES ('$c_registro','$f_horario','$a_de_pago','$h_disponible','$g_estudiante','$c_mensual','$prox_fecha_pago','$n_acudiente','$tel_acudiente','$colegio','$id_estudiante');";
        $subResult = mysqli_query($connection, $subQuery);
        if (!$subResult){
            echo $subQuery;
            die('Fallo al registrar la inscricion');
        }
        echo "Inscripcion registrada exitosamente.";
    }
}