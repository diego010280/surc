<?php
include('connections/connsurc.php');
$valor = $_POST['modalidad'];
$ano = $_POST['ano'];
$ur = $_POST['ur'];
$json =  array();


 
if($ur != 0){
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM surc_sumario.SURC_Sumario_FechaDel) mes,
    surc_modalidad.SURC_Modalidad_Descrip 
    FROM surc.surc_sumario
    LEFT JOIN  surc.surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc_sumario.SURC_Sumario_IdModalidad
    INNER JOIN surc.sumarios on sumarios.NroSumario_Id=surc_sumario.SURC_Sumario_Id
    where EXTRACT(YEAR FROM surc_sumario.SURC_Sumario_FechaDel) = '$ano' AND sumarios.UURR_Codigo = '$ur' AND surc_sumario.SURC_Sumario_IdModalidad = '$valor'
    GROUP BY EXTRACT(MONTH FROM surc_sumario.SURC_Sumario_FechaDel), surc_sumario.SURC_Sumario_IdModalidad
    order by EXTRACT(MONTH FROM surc_sumario.SURC_Sumario_FechaDel) ASC";
    
  
}else{
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM surc_sumario.SURC_Sumario_FechaDel) mes,
    surc_modalidad.SURC_Modalidad_Descrip 
    FROM surc.surc_sumario
    LEFT JOIN  surc.surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc_sumario.SURC_Sumario_IdModalidad
    INNER JOIN surc.sumarios on sumarios.NroSumario_Id=surc_sumario.SURC_Sumario_Id
    where EXTRACT(YEAR FROM surc_sumario.SURC_Sumario_FechaDel) = '$ano' AND surc_sumario.SURC_Sumario_IdModalidad = '$valor'
    GROUP BY EXTRACT(MONTH FROM surc_sumario.SURC_Sumario_FechaDel), surc_sumario.SURC_Sumario_IdModalidad
    order by EXTRACT(MONTH FROM surc_sumario.SURC_Sumario_FechaDel) ASC";
    
    
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