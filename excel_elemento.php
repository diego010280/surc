<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');


date_default_timezone_set('America/Argentina/Salta');

header("Pragma: public");
header("Expires: 0");
$nombre="consulta_sum_elemento";
$dia=date('Y-m-d');
$filename=$nombre.$dia.".xls";

// $filename = "Socios.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");





if (isset($_REQUEST['excel_elem']) and $_REQUEST['excel_elem']=='excel_elem') {
  if (empty($_REQUEST['SURC_TipoElemento_Id']) and empty($_REQUEST['SURC_FormaElemento_Id']) AND
      empty($_REQUEST['palabra_clave_elemen']) and empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) ) {

        $elementos=mysqli_query($conex_surc,"SELECT
                surc.surc_sumarioelemento.SURC_Sumario_Id AS 'SURC_Sumario_Id',
                surc.surc_sumario.SURC_Sumario_NroSumMP AS 'Nro_sum_mp',
                surc.surc_sumario.SURC_Sumario_Anio as 'Anio_sum',
                surc.surc_sumario.SURC_Sumario_IdDependencia as 'Id_dependencia',
                dbseg.ref_dependencias.DepPol_Descrip as 'desc_dependencia',
                surc.surc_sumario.SURC_Sumario_FechaDel as 'fecha_Delito',
                surc.surc_sumario.SURC_Sumario_CoordX AS 'Coord_X',
                surc.surc_sumario.SURC_Sumario_CoordY AS 'Coord_Y',
                surc.surc_sumarioelemento.SURC_SumarioElemento_Id AS 'SURC_SumarioElemento_Id',
                surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma as 'Id_forma',
                surc.surc_formaelemento.SURC_FormaElemento_Descrip as 'forma',
                surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle as 'id_tipoelemento',
                surc.surc_tipoelemento.SURC_TipoElemento_Descrip AS 'Tipo_Elemento',
                surc.surc_sumarioelemento.SURC_SumarioElemento_CantElem AS 'Cantidad',
                surc.surc_sumarioelemento.SURC_SumarioElemento_NroSerieE AS 'Numero_de_Serie',
                surc.surc_sumarioelemento.SURC_SumarioElemento_Obs AS 'Observaciones', surc.surc_formaelemento.SURC_FormaElemento_Descrip AS 'Condicion' FROM surc.surc_sumarioelemento

                LEFT JOIN surc.surc_tipoelemento ON surc.surc_tipoelemento.SURC_TipoElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle
                LEFT JOIN surc.surc_formaelemento ON surc.surc_formaelemento.SURC_FormaElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma
                LEFT JOIN surc.surc_sumario ON surc.surc_sumario.SURC_Sumario_Id=surc.surc_sumarioelemento.SURC_Sumario_Id
                LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo = surc.surc_sumario.SURC_Sumario_IdDependencia

                ORDER BY surc.surc_sumario.SURC_Sumario_NroSumMP desc,surc.surc_sumario.SURC_Sumario_Anio DESC,surc.surc_sumario.SURC_Sumario_FechaDel DESC
                ") or die("Problemas con el select consulta datos consulta_excel_elemento.php : ".mysqli_error($conex_surc));

                $num_row_elementos=$elementos ->num_rows;


  } else {

    $palabra_clave_elemen   = (empty($_REQUEST['palabra_clave_elemen'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['palabra_clave_elemen']));
    $SURC_TipoElemento_Id = (empty($_REQUEST['SURC_TipoElemento_Id'])) ? '' : intval($_REQUEST['SURC_TipoElemento_Id']);
    $SURC_FormaElemento_Id = (empty($_REQUEST['SURC_FormaElemento_Id'])) ? '' : intval($_REQUEST['SURC_FormaElemento_Id']);

    $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
    // $hastahecho = (empty($_REQUEST['hastahecho'])) ? date('Y-m-d') : $_REQUEST['hastahecho'];
    $hastahecho = (empty($_REQUEST['hastahecho'])) ? NULL : $_REQUEST['hastahecho'];

    $elementos=mysqli_query($conex_surc,"SELECT
            surc.surc_sumarioelemento.SURC_Sumario_Id AS 'SURC_Sumario_Id',
            surc.surc_sumario.SURC_Sumario_NroSumMP AS 'Nro_sum_mp',
            surc.surc_sumario.SURC_Sumario_Anio as 'Anio_sum',
            surc.surc_sumario.SURC_Sumario_IdDependencia as 'Id_dependencia',
            dbseg.ref_dependencias.DepPol_Descrip as 'desc_dependencia',
            dbseg.ref_localidad.Localidad_Descrip AS 'Localidad',
            dbseg.ref_unidadreg.UnidadReg_Descrip AS 'Unidad_Regional',
            surc.surc_sumario.SURC_Sumario_CoordX AS 'Coord_X',
            surc.surc_sumario.SURC_Sumario_CoordY AS 'Coord_Y',
            surc.surc_sumario.SURC_Sumario_FechaDel as 'fecha_Delito',
            surc.surc_sumarioelemento.SURC_SumarioElemento_Id AS 'SURC_SumarioElemento_Id',
            surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma as 'Id_forma',
            surc.surc_formaelemento.SURC_FormaElemento_Descrip as 'forma',
            surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle as 'id_tipoelemento',
            surc.surc_tipoelemento.SURC_TipoElemento_Descrip AS 'Tipo_Elemento',
            surc.surc_sumarioelemento.SURC_SumarioElemento_CantElem AS 'Cantidad',
            surc.surc_sumarioelemento.SURC_SumarioElemento_NroSerieE AS 'Numero_de_Serie',
            surc.surc_sumarioelemento.SURC_SumarioElemento_Obs AS 'Observaciones', surc.surc_formaelemento.SURC_FormaElemento_Descrip AS 'Condicion' FROM surc.surc_sumarioelemento

            LEFT JOIN surc.surc_tipoelemento ON surc.surc_tipoelemento.SURC_TipoElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle
            LEFT JOIN surc.surc_formaelemento ON surc.surc_formaelemento.SURC_FormaElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma
            LEFT JOIN surc.surc_sumario ON surc.surc_sumario.SURC_Sumario_Id=surc.surc_sumarioelemento.SURC_Sumario_Id
            LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo = surc.surc_sumario.SURC_Sumario_IdDependencia
            LEFT JOIN dbseg.ref_unidadreg ON dbseg.ref_unidadreg.UnidadReg_Codigo = dbseg.ref_dependencias.UnidadReg_Codigo
            LEFT JOIN dbseg.ref_localidad ON dbseg.ref_localidad.Localidad_Codigo = surc.surc_sumario.SURC_Sumario_IdLocalidad

            WHERE (surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle = '$SURC_TipoElemento_Id' or '$SURC_TipoElemento_Id'='')
            AND (surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma = '$SURC_FormaElemento_Id' OR '$SURC_FormaElemento_Id' = '')
            AND (concat_ws(' ',surc.surc_sumarioelemento.SURC_SumarioElemento_NroSerieE,surc.surc_sumarioelemento.SURC_SumarioElemento_Obs) LIKE '%$palabra_clave_elemen%' or '$palabra_clave_elemen'='')
            AND (surc.surc_sumario.SURC_Sumario_FechaDel>='$desdehecho' or '$desdehecho'='')
            AND (surc.surc_sumario.SURC_Sumario_FechaDel<= '$hastahecho' or '$hastahecho'='')

            ORDER BY surc.surc_sumario.SURC_Sumario_NroSumMP desc,surc.surc_sumario.SURC_Sumario_Anio DESC,surc.surc_sumario.SURC_Sumario_FechaDel DESC

            ") or die("Problemas con el select consulta datos consulta_elemento.php : ".mysqli_error($conex_surc));

            $num_row_elementos=$elementos ->num_rows;
}

}



?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<table style="border: 1px solid #000">
		<tr>
	<th style="background-color:#D8D8D8; height:35px;">Nro</th>
      <th style="background-color:#D8D8D8; height:35px;">Nro.Sumario M.P.</th>
			<th style="background-color:#D8D8D8; height:35px;">Año</th>
			<th style="background-color:#D8D8D8;">Dependencia</th>
      <th style="background-color:#D8D8D8;">Localidad</th>
      <th style="background-color:#D8D8D8;">Unidad Regional</th>
      <th style="background-color:#D8D8D8;">Coordenada X</th>
      <th style="background-color:#D8D8D8;">Coordenada Y</th>
			<th style="background-color:#D8D8D8;">Fecha Delito</th>
      <th style="background-color:#D8D8D8;">Forma</th>
      <th style="background-color:#D8D8D8;">Elemento</th>
      <th style="background-color:#D8D8D8;">Nro. de Serie</th>
      <!-- <th style="background-color:#D8D8D8;">Cantidad</th> -->
      <th style="background-color:#D8D8D8;">Observaciones</th>
      <th style="background-color:#D8D8D8;">Condicion</th>

		</tr>


	   <?php
     $i = 0;

     while ($row_elementos = mysqli_fetch_array($elementos)) {
        ++$i; ?>
        <tr height="10px">
          <td><?= $i ?></td>
          <td><?= $row_elementos['Nro_sum_mp'] ?></td>
          <td><?= $row_elementos['Anio_sum'] ?></td>
          <td><?= utf8_encode($row_elementos['desc_dependencia']) ?></td>
          <td><?= utf8_encode($row_elementos['Localidad']) ?></td>
          <td><?= utf8_encode($row_elementos['Unidad_Regional']) ?></td>
          <td><?= utf8_encode($row_elementos['Coord_X']) ?></td>
            <td><?= utf8_encode($row_elementos['Coord_Y']) ?></td>
          <td><?= $row_elementos['fecha_Delito'] ?></td>
          <td><?= utf8_encode($row_elementos['forma']) ?></td>
          <td><?= utf8_encode($row_elementos['Tipo_Elemento']) ?></td>
                    <td><?= utf8_encode($row_elementos['Numero_de_Serie']) ?></td>
          <!-- <td><?= $row_elementos['Cantidad'] ?></td> -->
          <td><?= utf8_encode($row_elementos['Observaciones']) ?></td>
          <td><?= utf8_encode($row_elementos['Condicion']) ?></td>

        </tr>

<?php
}
 ?>


	</table>
</body>
</html>
