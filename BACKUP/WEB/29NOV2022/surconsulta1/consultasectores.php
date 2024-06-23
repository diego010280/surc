<?php
include('connections/connsurc.php');


if(isset($_POST['valor'])){

$valor=$_POST['valor'];

    $consulta = " SELECT * FROM surc_sectores WHERE SURC_Sectores_IdCCO = '$valor'";

    $resultado = mysqli_query($conex_surc, $consulta);
    
    if(!$resultado){
    
        die('consulta ERROR' . mysqli_error($conex_surc));
    
    }
    
    $json =  array(); 
    while($row1= mysqli_fetch_array($resultado)){
    
        $json[] = array(
            "nombre"=> utf8_encode($row1['SURC_Sectores_Descrip']),
            "valor" => $row1['SURC_Sectores_Id'], 
            'area'=> $row1['SURC_Sectores_IdCCO']
        );
       
    }
    $jsonstring=json_encode($json);
    
     echo $jsonstring;
}else{


$consulta = "SELECT * FROM surc_cco";
    
$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

$json =  array();
while($row= mysqli_fetch_array($resultado)){

    $json[] = array(
        "valor"=> $row['SURC_CCO_Id'],
        "nombre"=> $row['SURC_CCO_Descrip']
    );
   
}$jsonstring=json_encode($json);

 echo $jsonstring;

}

?>