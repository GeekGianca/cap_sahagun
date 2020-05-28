<?php
include('connection.php');
if (isset($_POST['cod_materia']) && isset($_POST['n_materia']) && isset($_POST['e_materia'])) {
    $cod_materia = $_POST['cod_materia'];
    $n_materia = $_POST['n_materia'];
    $e_materia = $_POST['e_materia'];

    $query = "UPDATE `materias` SET `nombre_materia`='$n_materia',`identificacion_estudiante`='$e_materia' WHERE `codigo_materia` = '$cod_materia';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo $query;
        die('Fallo al actualizar la materia');
    }
    echo "Materia actualizada exitosamente!";
}