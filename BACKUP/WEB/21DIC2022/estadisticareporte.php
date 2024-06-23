<?php
include('connections/connsurc.php');
$valor = $_POST['delito'];
$ano = $_POST['ano'];
$ur = $_POST['ur'];
$json =  array();


if($ur != 0){
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM Fecha_Delito) mes,
    SURC_HechoDelictivo_Descrip 
    FROM sumarios
    INNER JOIN surc_hechodelictivo ON SURC_HechoDelictivo_Id = IdHechoDel 
    where EXTRACT(YEAR FROM Fecha_Delito) = '$ano' and UURR_Codigo = '$ur' AND IdHechoDel = '$valor' AND Tentativa <> 'S'
    GROUP BY EXTRACT(MONTH FROM Fecha_Delito), IdHechoDel
    order by EXTRACT(MONTH FROM Fecha_Delito) ASC";
    
   
}else{
    $consulta = "SELECT count(*) cantidad, EXTRACT(MONTH FROM Fecha_Delito) mes,
    SURC_HechoDelictivo_Descrip 
    FROM sumarios
    INNER JOIN surc_hechodelictivo ON SURC_HechoDelictivo_Id = IdHechoDel 
    where EXTRACT(YEAR FROM Fecha_Delito) = '$ano' AND IdHechoDel = '$valor' AND Tentativa <> 'S' 
    GROUP BY EXTRACT(MONTH FROM Fecha_Delito), IdHechoDel
    order by EXTRACT(MONTH FROM Fecha_Delito) ASC";
   
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