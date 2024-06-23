<?php
include('connections/connsurc.php');
$ano = $_POST['ano'];
$ur = $_POST['ur'];
$json =  array();


if($ur != 0){
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM surc.vista_estadistica.SURC_Sumario_FechaDel) mes, surc_modalidad.SURC_Modalidad_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.vista_estadistica.SURC_Sumario_IdModalidad
    where EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' and UnidadReg_Codigo = '$ur' AND (SURC_Sumario_IdModalidad = 1 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 17 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 35 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 49 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 50 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 58 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 68 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 71 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 79 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 96 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 100 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 101 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 107 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 121 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 122)  
    GROUP BY surc.vista_estadistica.SURC_Sumario_IdModalidad,EXTRACT(MONTH FROM surc.vista_estadistica.SURC_Sumario_FechaDel) ";
    
   
}else{
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM surc.vista_estadistica.SURC_Sumario_FechaDel) mes, surc_modalidad.SURC_Modalidad_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.vista_estadistica.SURC_Sumario_IdModalidad
    where EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' AND (SURC_Sumario_IdModalidad = 1 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 17 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 35 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 49 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 50 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 58 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 68 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 71 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 79 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 96 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 100 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 101 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 107 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 121 OR surc.vista_estadistica.SURC_Sumario_IdModalidad = 122)  
    GROUP BY surc.vista_estadistica.SURC_Sumario_IdModalidad,EXTRACT(MONTH FROM surc.vista_estadistica.SURC_Sumario_FechaDel) ";
   
}

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