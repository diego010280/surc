<?php
include('connections/connsurc.php');


$consulta = " SELECT * FROM surc_hechodelictivo ";

$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

$json =  array(); 
while($row1= mysqli_fetch_array($resultado)){

    $json[] = array(
        "nombre"=> utf8_encode($row1['SURC_HechoDelictivo_Descrip']),
        "valor" => $row1['SURC_HechoDelictivo_Id']
    );
   
}
$jsonstring=json_encode($json);

 echo $jsonstring;
?>