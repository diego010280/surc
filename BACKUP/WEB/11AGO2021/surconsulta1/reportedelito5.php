<?php
include('connections/connsurc.php');
$ano = $_POST['ano'];
$ur = $_POST['ur'];
$json =  array();


if($ur != 0){
    $consulta = "SELECT COUNT(*) as cantidad, SURC_Modalidad_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc_modalidad ON SURC_Modalidad_Id=SURC_Sumario_IdModalidad
    WHERE EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' AND SURC_Modalidad_Id != 80 AND SURC_Modalidad_Id != 2 AND SURC_Modalidad_Id != 126 AND SURC_Modalidad_Id != 123 AND UnidadReg_Codigo = '$ur'
    GROUP BY SURC_Sumario_IdModalidad
    ORDER BY cantidad DESC
    LIMIT 10";
     
   
}else{
    $consulta = "SELECT COUNT(*) as cantidad, SURC_Modalidad_Descrip
    FROM surc.vista_estadistica
    INNER JOIN surc_modalidad ON SURC_Modalidad_Id=SURC_Sumario_IdModalidad
    WHERE EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '$ano' AND SURC_Modalidad_Id != 80 AND SURC_Modalidad_Id != 2 AND SURC_Modalidad_Id != 126 AND SURC_Modalidad_Id != 123
    GROUP BY SURC_Sumario_IdModalidad
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
            "delito"=>utf8_encode($row1['SURC_Modalidad_Descrip'])
        );
       
    }

$jsonstring=json_encode($json);

 echo $jsonstring;

?>