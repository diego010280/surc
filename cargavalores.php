<?php
include('connections/connsurc.php');

if(isset($_POST['comprobar'])){

    $delito=$_POST['delito'];
    $modalidad=$_POST['modalidad'];
    
   
    $consulta = "INSERT INTO surc_reportes_relev (id_hecho_delic, id_modalidad) VALUES ('$delito','$modalidad')";

    $resultado = mysqli_query($conex_surc, $consulta);

    if(!$resultado){

        die('consulta ERROR ' . mysqli_error($conex_surc));

    }

    echo "Cargada correctamente";

}


?>