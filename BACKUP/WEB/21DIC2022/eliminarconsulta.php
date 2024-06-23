<?php
include('connections/connsurc.php');

if(isset($_POST['id'])){

    $id=$_POST['id'];

    $consulta = "DELETE FROM `surc_reportes_relev` WHERE id_surc_reportes = '$id'";

    $resultado = mysqli_query($conex_surc, $consulta);

    if(!$resultado){

        die('consulta ERROR ' . mysqli_error($conex_surc));

    }

    echo 'eliminado correctamente';

}

?>