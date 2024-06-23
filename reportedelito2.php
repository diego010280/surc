<?php
include('connections/connsurc.php');
$valor = $_POST['valor'];
$json =  array();
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM SURC_Sumario_FechaDel) mes, SURC_HechoDelictivo_Descrip 
    FROM surc.vista_estadistica
    INNER JOIN surc_hechodelictivo ON SURC_HechoDelictivo_Id = SURC_Sumario_IdHechoDel 
    where $valor
    GROUP BY SURC_Sumario_IdHechoDel,EXTRACT(MONTH FROM SURC_Sumario_FechaDel)";
$resultado = mysqli_query($conex_surc, $consulta);
    
if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

  

    while($row1= mysqli_fetch_array($resultado)){

        $json[] = array(
            "cant"=>$row1['cantidad'],
            "delito"=>utf8_encode($row1['SURC_HechoDelictivo_Descrip']),
            "mes" => $row1['mes']
        );
       
    }

$jsonstring=json_encode($json);

 echo $jsonstring;





?>