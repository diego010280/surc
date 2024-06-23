<?php
include('connections/connsurc.php');
$ano = $_POST['ano'];
$ur = $_POST['ur'];
$json =  array();


if($ur != 0){
    $consulta = "SELECT COUNT(*) as cantidad, SURC_HechoDelictivo_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc.surc_hechodelictivo ON SURC_HechoDelictivo_Id = SURC_Sumario_IdHechoDel
    WHERE SURC_HechoDelictivo_IdBienJuri <> 12 AND SURC_HechoDelictivo_IdBienJuri <> 9 AND EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' AND SURC_Sumario_Tentativa <> 'S' AND UnidadReg_Codigo = '$ur'
    GROUP BY SURC_Sumario_IdHechoDel
    ORDER BY cantidad DESC
    LIMIT 10";
     
   
}else{
    $consulta = "SELECT COUNT(*) as cantidad, SURC_HechoDelictivo_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc.surc_hechodelictivo ON SURC_HechoDelictivo_Id = SURC_Sumario_IdHechoDel
    WHERE SURC_HechoDelictivo_IdBienJuri <> 12 AND SURC_HechoDelictivo_IdBienJuri <> 9 AND EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' AND SURC_Sumario_Tentativa <> 'S'
    GROUP BY SURC_Sumario_IdHechoDel
    ORDER BY cantidad DESC
    LIMIT 10";
   
}

$resultado = mysqli_query($conex_surc, $consulta);
    
if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

 

    while($row1= mysqli_fetch_array($resultado)){

        $json[] = array(
            "cant"=>$row1['cantidad'],
            "delito"=>utf8_encode($row1['SURC_HechoDelictivo_Descrip'])
        );
       
    }

$jsonstring=json_encode($json);

 echo $jsonstring;

?>