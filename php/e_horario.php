<?php
include('connection.php');
if(isset($_POST['cod_horario'])){
    $cod_horario = $_POST['cod_horario'];
    $query = "DELETE FROM `horario` WHERE `codigo` = '$cod_horario';";
    $result = mysqli_query($connection, $query);
    if (!$result){
        echo $query;
        die('Fallo al eliminar el horario');
    }
    echo "Horario eliminado exitosamente!";
}