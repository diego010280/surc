<?php
include('connections/connsurc.php');
$ano = $_POST['ano'];
$ur = $_POST['ur'];
$json =  array();


if($ur != 0){
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM SURC_Sumario_FechaDel) mes, SURC_HechoDelictivo_Descrip 
    FROM surc.vista_estadistica
    INNER JOIN surc_hechodelictivo ON SURC_HechoDelictivo_Id = SURC_Sumario_IdHechoDel 
    where EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' and UnidadReg_Codigo = '$ur' AND (SURC_Sumario_IdHechoDel = 1 OR SURC_Sumario_IdHechoDel = 2 OR SURC_Sumario_IdHechoDel = 3 OR SURC_Sumario_IdHechoDel = 6 OR SURC_Sumario_IdHechoDel = 7 OR SURC_Sumario_IdHechoDel = 23 OR SURC_Sumario_IdHechoDel = 24 OR SURC_Sumario_IdHechoDel = 34 OR SURC_Sumario_IdHechoDel = 35 OR SURC_Sumario_IdHechoDel = 36 OR SURC_Sumario_IdHechoDel = 37 OR SURC_Sumario_IdHechoDel = 43 OR SURC_Sumario_IdHechoDel = 44 OR SURC_Sumario_IdHechoDel = 94 OR SURC_Sumario_IdHechoDel = 100) AND SURC_Sumario_Tentativa <> 'S'
    GROUP BY SURC_Sumario_IdHechoDel,EXTRACT(MONTH FROM SURC_Sumario_FechaDel)";
    
   
}else{
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM SURC_Sumario_FechaDel) mes, SURC_HechoDelictivo_Descrip 
    FROM surc.vista_estadistica
    INNER JOIN surc_hechodelictivo ON SURC_HechoDelictivo_Id = SURC_Sumario_IdHechoDel 
    where EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' AND (SURC_Sumario_IdHechoDel = 1 OR SURC_Sumario_IdHechoDel = 2 OR SURC_Sumario_IdHechoDel = 3 OR SURC_Sumario_IdHechoDel = 6 OR SURC_Sumario_IdHechoDel = 7 OR SURC_Sumario_IdHechoDel = 23 OR SURC_Sumario_IdHechoDel = 24 OR SURC_Sumario_IdHechoDel = 34 OR SURC_Sumario_IdHechoDel = 35 OR SURC_Sumario_IdHechoDel = 36 OR SURC_Sumario_IdHechoDel = 37 OR SURC_Sumario_IdHechoDel = 43 OR SURC_Sumario_IdHechoDel = 44 OR SURC_Sumario_IdHechoDel = 94 OR SURC_Sumario_IdHechoDel = 100) AND SURC_Sumario_Tentativa <> 'S'
    GROUP BY SURC_Sumario_IdHechoDel,EXTRACT(MONTH FROM SURC_Sumario_FechaDel)";
   
}

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