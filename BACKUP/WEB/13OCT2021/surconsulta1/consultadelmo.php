<?php
include('connections/connsurc.php');
$json =  array(); 
if($_POST['val'] == 0){

    $consulta = "SELECT  id_hecho_delic FROM surc_reportes_relev ";

$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}
while($row1= mysqli_fetch_array($resultado)){

    $json[] = array(
        "delictivo"=> $row1['id_hecho_delic']
    );
   
}

}elseif($_POST['val'] == 1){
    $consulta = "SELECT id_modalidad FROM surc_reportes_relev ";

    $resultado = mysqli_query($conex_surc, $consulta);
    
    if(!$resultado){
    
        die('consulta ERROR' . mysqli_error($conex_surc));
    
    }
    while($row1= mysqli_fetch_array($resultado)){
    
        $json[] = array(
            "modalidad" => $row1['id_modalidad']
        );
       
    }


}


$jsonstring=json_encode($json);

 echo $jsonstring;
?>
