<?php
include('connections/connsurc.php');


$consulta = "SELECT  id_hecho_delic, id_modalidad FROM surc_reportes_relev ";

$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

$json =  array(); 
while($row1= mysqli_fetch_array($resultado)){

    $json[] = array(
        "delictivo"=> $row1['id_hecho_delic'],
        "modalidad" => $row1['id_modalidad']
    );
   
}
$jsonstring=json_encode($json);

 echo $jsonstring;
?>
