<?php
include('connections/connsurc.php');
$con = $_POST['valor'];
$json =  array();

$consulta = "SELECT surc.surc_sumario.SURC_Sumario_NroSumMP,dbseg.ref_dependencias.DepPol_Descrip,surc.surc_hechodelictivo.SURC_HechoDelictivo_Descrip,surc.surc_modalidad.SURC_Modalidad_Descrip, surc.surc_sumario.SURC_Sumario_FechaDel, surc.surc_sumario.SURC_Sumario_FechaSum, SURC_Sumario_HoraSum
FROM surc.surc_sumario
INNER JOIN surc.surc_hechodelictivo ON surc.surc_hechodelictivo.SURC_HechoDelictivo_Id=surc.surc_sumario.SURC_Sumario_IdHechoDel
LEFT JOIN surc.surc_modalidad on surc.surc_modalidad.SURC_Modalidad_Id=surc.surc_sumario.SURC_Sumario_IdModalidad
LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo = surc.surc_sumario.SURC_Sumario_IdDependencia
LEFT JOIN dbseg.ref_unidadreg on dbseg.ref_unidadreg.UnidadReg_Codigo = dbseg.ref_dependencias.UnidadReg_Codigo
WHERE $con ORDER BY surc.surc_sumario.SURC_Sumario_FechaDel  DESC";
$resultado = mysqli_query($conex_surc, $consulta);

if(!$resultado){

    die('consulta ERROR' . mysqli_error($conex_surc));

}

    while($row1= mysqli_fetch_array($resultado)){

        $json[] = array(
            "numero"=>$row1['SURC_Sumario_NroSumMP'],
            "dependencia"=>utf8_encode($row1['DepPol_Descrip']),
            "delictivo"=>utf8_encode($row1['SURC_HechoDelictivo_Descrip']),
            "modalidad"=>utf8_encode($row1['SURC_Modalidad_Descrip']),
            "fechadel" => $row1['SURC_Sumario_FechaDel'],
            "fechasum" => $row1['SURC_Sumario_FechaSum'],
            "horasum" => $row1['SURC_Sumario_HoraSum']
        );

    }



$jsonstring=json_encode($json);
//echo $con;
echo $jsonstring;
?>