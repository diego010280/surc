<?php 
include('connections/connsurc.php');

$consulta = "SELECT * FROM surc_modalidad";
    
$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

$json =  array();
while($row= mysqli_fetch_array($resultado)){

    $json[] = array(
        "valor"=> $row['SURC_Modalidad_Id'],
        "nombre"=> utf8_encode($row['SURC_Modalidad_Descrip'])
    );
   
}
$jsonstring=json_encode($json);

 echo $jsonstring;

?>