<?php
include('connections/connsurc.php');


$consulta = "SELECT id_surc_reportes, SURC_HechoDelictivo_Descrip,SURC_Modalidad_Descrip
FROM surc_reportes_relev 
INNER JOIN surc_hechodelictivo ON SURC_HechoDelictivo_Id=id_hecho_delic
LEFT JOIN surc_modalidad on SURC_Modalidad_Id=id_modalidad";

$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

$json =  array(); 
while($row1= mysqli_fetch_array($resultado)){

    $json[] = array(
        "id"=> $row1['id_surc_reportes'],
        "delictivo"=> utf8_encode($row1['SURC_HechoDelictivo_Descrip']),
        "modalidad" => utf8_encode($row1['SURC_Modalidad_Descrip'])
    );
   
}
$jsonstring=json_encode($json);

 echo $jsonstring;
?>
