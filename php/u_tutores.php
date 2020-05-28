<?php
include('connection.php');
if (isset($_POST['id_tutor']) && isset($_POST['n_tutor']) && isset($_POST['a_tutor']) && isset($_POST['c_tutor'])) {
    $id_tutor = $_POST['id_tutor'];
    $n_tutor = $_POST['n_tutor'];
    $a_tutor = $_POST['a_tutor'];
    $c_tutor = $_POST['c_tutor'];
    $t_tutor = $_POST['t_tutor'];
    $d_tutor = $_POST['d_tutor'];
    $query = "UPDATE `tutores` SET `correo`='$c_tutor',`telefono`='$t_tutor', `direccion` = '$d_tutor' WHERE `identificacion`= '$id_tutor';";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        echo $query;
        die('Fallo al actualizar el tutor');
    }
    echo "Tutor actualizado exitosamente!";
}