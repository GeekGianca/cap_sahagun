<?php
include ('connection.php');
if(isset($_POST['cod_materia']) && isset($_POST['n_materia']) && isset($_POST['e_materia'])){
    $cod_materia = $_POST['cod_materia'];
    $n_materia = $_POST['n_materia'];
    $e_materia = $_POST['e_materia'];

    $query = "INSERT INTO `materias`(`codigo_materia`, `nombre_materia`, `identificacion_estudiante`) VALUES ('$cod_materia','$n_materia','$e_materia');";
    $result = mysqli_query($connection, $query);
    if (!$result){
        echo $query;
        die('Fallo al registrar la materia');
    }
    echo "Materia registrada exitosamente.";
}