<?php
include('connections/connsurc.php');
$valor = $_POST['valor'];
$json =  array();
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM surc.vista_estadistica.SURC_Sumario_FechaDel) mes, surc_modalidad.SURC_Modalidad_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.vista_estadistica.SURC_Sumario_IdModalidad
    where $valor  
    GROUP BY surc.vista_estadistica.SURC_Sumario_IdModalidad,EXTRACT(MONTH FROM surc.vista_estadistica.SURC_Sumario_FechaDel) ";

$resultado = mysqli_query($conex_surc, $consulta);
    
if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

 

    while($row1= mysqli_fetch_array($resultado)){

        $json[] = array(
            "cant"=>$row1['cantidad'],
            "modalidad"=>utf8_encode($row1['SURC_Modalidad_Descrip']),
            "mes" => $row1['mes']
        );
       
    }

$jsonstring=json_encode($json);

 echo $jsonstring;





?>