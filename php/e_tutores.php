<?php
include ('connection.php');
if(isset($_POST['id_tutor'])){
    $id_tutor = $_POST['id_tutor'];
    $query = "DELETE FROM `tutores` WHERE `identificacion` = '$id_tutor';";
    $result = mysqli_query($connection, $query);
    if (!$result){
        echo $query;
        die('Fallo al eliminar el tutor');
    }
    echo "Tutor eliminado exitosamente!";
}