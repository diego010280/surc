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
$nombre="consulta sum-pers";
$dia=date('Y-m-d');
$filename=$nombre.$dia.".xls";

// $filename = "Socios.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");





if (isset($_REQUEST['excelpers']) and $_REQUEST['excelpers']=='excelpers') {
  if (empty($_REQUEST['nrosumario_mp']) and empty($_REQUEST['palabra_clave']) and empty($_REQUEST['anio']) and empty($_REQUEST['SURC_TipoSum_Id']) and empty($_REQUEST['SURC_OrigenSumario_Id']) and
      empty($_REQUEST['SURC_CCO_Id']) and empty($_REQUEST['SURC_Sectores_Id']) and empty($_REQUEST['DepPol_Codigo']) and empty($_REQUEST['DepPol_Codigo1']) and
      empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) and empty($_REQUEST['desdecarga']) and empty($_REQUEST['hastacarga']) and
      empty($_REQUEST['SURC_BienJuridico_Id']) and  empty($_REQUEST['SURC_TipoGrDelito_Id']) and empty($_REQUEST['SURC_HechoDelictivo_Id']) and empty($_REQUEST['SURC_Modalidad_Id']) and empty($_REQUEST['UnidadReg_Codigo'])
      and empty($_REQUEST['usuario']) and empty($_REQUEST['num_xml'])) {

        // echo "debe ingresar al menos un valor en el filtro de busquedas";

  } else {
    $palabra_clave   = (empty($_REQUEST['palabra_clave'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['palabra_clave']));
    $nrosumario_mp   = (empty($_REQUEST['nrosumario_mp'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['nrosumario_mp'])); //like
    $anio            = (empty($_REQUEST['anio'])) ? '' : intval($_REQUEST['anio']);
    $SURC_TipoSum_Id = (empty($_REQUEST['SURC_TipoSum_Id'])) ? '' : intval($_REQUEST['SURC_TipoSum_Id']);
    $SURC_OrigenSumario_Id = (empty($_REQUEST['SURC_OrigenSumario_Id'])) ? '' : intval($_REQUEST['SURC_OrigenSumario_Id']);
    $SURC_CCO_Id     = (empty($_REQUEST['SURC_CCO_Id'])) ? '': intval($_REQUEST['SURC_CCO_Id']);
    $SURC_Sectores_Id= (empty($_REQUEST['SURC_Sectores_Id'])) ? '' : intval($_REQUEST['SURC_Sectores_Id']);

    $DepPol_Codigo   = (empty($_REQUEST['DepPol_Codigo'])) ? '' : intval($_REQUEST['DepPol_Codigo']);
    $DepPol_Codigo1   = (empty($_REQUEST['DepPol_Codigo1'])) ? '' : intval($_REQUEST['DepPol_Codigo1']);


    if (!empty($_REQUEST['DepPol_Codigo1'])) {

          $identidad=explode(" ",$_REQUEST['DepPol_Codigo1']);
          $codigo_dep= intval($identidad[0]);

      }else {
          $codigo_dep=$DepPol_Codigo;
      }



/*
Te cambie $hastahecho y $hastacarga,
cuando sean null tomo la fecha de hoy, sino cuando el usuario mande esos campos vacios la consulta no te va ningun resultado
*/

    $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
    $hastahecho = (empty($_REQUEST['hastahecho'])) ? null: $_REQUEST['hastahecho'];

    $desdecarga = (empty($_REQUEST['desdecarga'])) ? null : $_REQUEST['desdecarga'];
    $hastacarga = (empty($_REQUEST['hastacarga'])) ? null : $_REQUEST['hastacarga'];

    $SURC_BienJuridico_Id= (empty($_REQUEST['SURC_BienJuridico_Id']))? '' : intval($_REQUEST['SURC_BienJuridico_Id']);

    $SURC_TipoGrDelito_Id= (empty($_REQUEST['SURC_TipoGrDelito_Id'])) ? '' : intval($_REQUEST['SURC_TipoGrDelito_Id']);



    $SURC_HechoDelictivo_Id = (empty($_REQUEST['SURC_HechoDelictivo_Id'])) ? '' : intval($_REQUEST['SURC_HechoDelictivo_Id']);

    if (empty($_REQUEST['SURC_Modalidad_Id'])) {
        $SURC_Modalidad_Id = '';
    } else {
      $modalidad = explode(" ",$_REQUEST['SURC_Modalidad_Id']);
      $SURC_Modalidad_Id = intval($modalidad[0]);
    }

    $UnidadReg_Codigo=(empty($_REQUEST['UnidadReg_Codigo'])) ? '' : intval($_REQUEST['UnidadReg_Codigo']);
    if (empty($_REQUEST['usuario'])) {
      $usu='';
    }else {
      $usuar=explode("-",$_REQUEST['usuario']);
      $usu=trim($usuar[0]);
    }

    $num_xml   = (empty($_REQUEST['num_xml'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['num_xml'])); //like

    $sumario_excel=mysqli_query($conex_surc,"SELECT  `surc`.`surc_sumario`.`SURC_Sumario_NroSumMP` AS `NroSumario_MP`,
      `surc`.`surc_sumario`.`SURC_Sumario_Anio` AS `Anio`,
      `dbseg`.`ref_dependencias`.`DepPol_Descrip` AS `Dependencia`,
      `surc`.`surc_sectores`.`SURC_Sectores_Descrip` AS `Sector`,
      `dbseg`.`ref_unidadreg`.`UnidadReg_Descrip` AS `Unidad_Regional`,
      `surc`.`surc_tiposum`.`SURC_TipoSum_Descrip` AS `Tipo_Sumario`,
      `surc`.`surc_origensumario`.`SURC_OrigenSumario_Descrip` AS `Origen_Sumario`,
      `dbseg`.`ref_localidad`.`Localidad_Descrip` AS `Localidad`,
      `dbseg`.`ref_barrio`.`Barrio_Descrip` AS `Barrio`,
      `surc`.`surc_sumario`.`SURC_Sumario_NomCalle` AS `Nom_Calle`,
      `surc`.`surc_sumario`.`SURC_Sumario_AltCalle` AS `Alt_Calle`,
      `surc`.`surc_sumario`.`SURC_Sumario_CoordX` AS `Coord_X`,
      `surc`.`surc_sumario`.`SURC_Sumario_CoordY` AS `Coord_Y`,
      `surc`.`surc_cuadriculas`.`SURC_Cuadriculas_Descrip` AS `Cuadricula`,
      `surc`.`surc_hechodelictivo`.`SURC_HechoDelictivo_Descrip` AS `Hecho_Delictivo`,
      `surc`.`surc_sumario`.`SURC_Sumario_Tentativa` AS `Tentativa`,
      `surc`.`surc_tipoactasesclarecido`.`SURC_TipoActasEsclarecidoDes` AS `Actuacion_Esc`,
      `max_ult_act`.`View_TipoAct` AS `Tipo_Actuac`,
      `max_ult_act`.`View_Fech` AS `Fecha_Actuac`,
      `max_ult_act`.`View_Usu` AS `Usuario_Actuac`,
      `max_ult_act`.`View_Dep` AS `Dep_Actuac`,
      if (`surc`.`surc_sumario`.`SURC_Sumario_FechaDel`= '1000-01-01',null,`surc`.`surc_sumario`.`SURC_Sumario_FechaDel`) AS `Fecha_Delito`,
      if (`surc_sumario`.`SURC_Sumario_HoraDel`='1000-01-01 00:00:00',null,time(`surc`.`surc_sumario`.`SURC_Sumario_HoraDel`) ) AS `Hora_Delito`,
      DAYNAME(`surc`.`surc_sumario`.`SURC_Sumario_FechaDel`) AS `Dia_Semana`,
      `surc`.`surc_lugares`.`SURC_Lugar_Descrip` AS `Lugar_Hecho`,
      `surc`.`surc_juzgadofiscalia`.`SURC_JuzgadoFiscalia_Descrip` AS `Fiscalia`,
      `surc`.`surc_modalidad`.`SURC_Modalidad_Descrip` AS `Modalidad`,
      `surc`.`surc_armamecanismo`.`SURC_ArmaMecanismo_Descrip` AS `Arma_Mecanismo`,
      `surc`.`surc_bienjuridico`.`SURC_BienJuridico_Descrip` AS `Bien_Jurídico`,
      `surc`.`surc_sumario`.`SURC_Sumario_TextoRelato` AS `Descrip_Hecho`,
      `surc`.`surc_sumario`.`SURC_HechoDelictivo_VIF` AS `Hecho_VIF`,
      `surc`.`surc_sumario`.`SURC_Sumario_ViolGenero` AS `Violencia_genero`,
      `surc`.`surc_sumario`.`SURC_Sumario_FechaSum` AS `Fecha_Carga`,
      time(`surc`.`surc_sumario`.`SURC_Sumario_HoraSum`) AS `Hora_Carga`,
      `surc`.`surc_sumario`.`SURC_Sumario_CargaUsuario` AS `Usuario`,
      surc.personasumario.Tipo_Persona, surc.personasumario.Clase_Persona, surc.personasumario.Vinculo_Persona,
      surc.personasumario.Documento, surc.personasumario.ApellidoyNombre, surc.personasumario.Sexo,
      surc.personasumario.Fecha_Nac,surc.personasumario.Edad,surc.personasumario.Alias,
      surc.personasumario.Telefono,surc.personasumario.Est_Civil
  FROM
      ((((((((((((((((`surc`.`surc_sumario`
      LEFT JOIN `dbseg`.`ref_dependencias` ON ((`dbseg`.`ref_dependencias`.`DepPol_Codigo` = `surc`.`surc_sumario`.`SURC_Sumario_IdDependencia`)))
      LEFT JOIN `surc`.`surc_sectores` ON (((`surc`.`surc_sectores`.`SURC_Sectores_IdCCO` = `dbseg`.`ref_dependencias`.`SURC_Sectores_IdCCO`)
          AND (`surc`.`surc_sectores`.`SURC_Sectores_Id` = `dbseg`.`ref_dependencias`.`SURC_Sectores_Id`))))
      LEFT JOIN `dbseg`.`ref_unidadreg` ON ((`dbseg`.`ref_unidadreg`.`UnidadReg_Codigo` = `dbseg`.`ref_dependencias`.`UnidadReg_Codigo`)))
      LEFT JOIN `surc`.`surc_tiposum` ON ((`surc`.`surc_tiposum`.`SURC_TipoSum_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdTipoSumario`)))
      LEFT JOIN `surc`.`surc_origensumario` ON ((`surc`.`surc_origensumario`.`SURC_OrigenSumario_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdOrigSum`)))
      LEFT JOIN `dbseg`.`ref_localidad` ON ((`dbseg`.`ref_localidad`.`Localidad_Codigo` = `surc`.`surc_sumario`.`SURC_Sumario_IdLocalidad`)))
      LEFT JOIN `dbseg`.`ref_barrio` ON ((`dbseg`.`ref_barrio`.`Barrio_Codigo` = `surc`.`surc_sumario`.`SURC_Sumario_IdBarrio`)))
      LEFT JOIN `surc`.`surc_cuadriculas` ON ((`surc`.`surc_cuadriculas`.`SURC_Cuadriculas_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdCuadricula`)))
      LEFT JOIN `surc`.`surc_hechodelictivo` ON ((`surc`.`surc_hechodelictivo`.`SURC_HechoDelictivo_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdHechoDel`)))
      LEFT JOIN surc.surc_tipogrdelito ON surc.surc_tipogrdelito.SURC_TipoGrDelito_Id = surc.surc_hechodelictivo.SURC_HechoDelictivo_IdTGrDelit
      LEFT JOIN `surc`.`max_ult_act` ON ((`max_ult_act`.`View_Id_Sum` = `surc`.`surc_sumario`.`SURC_Sumario_Id`)))
      LEFT JOIN `surc`.`surc_tipoactasesclarecido` ON ((`surc`.`surc_tipoactasesclarecido`.`SURC_TipoActasEsclarecidoId` = `surc`.`surc_sumario`.`SURC_Sumario_IdTipoActasEscl`)))
      LEFT JOIN `surc`.`surc_lugares` ON ((`surc`.`surc_lugares`.`SURC_Lugar_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdLugar`)))
      LEFT JOIN `surc`.`surc_juzgadofiscalia` ON ((`surc`.`surc_juzgadofiscalia`.`SURC_JuzgadoFiscalia_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdJuzFis`)))
      LEFT JOIN `surc`.`surc_modalidad` ON ((`surc`.`surc_modalidad`.`SURC_Modalidad_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdModalidad`)))
      LEFT JOIN `surc`.`surc_armamecanismo` ON ((`surc`.`surc_armamecanismo`.`SURC_ArmaMecanismo_Id` = `surc`.`surc_sumario`.`SURC_Sumario_IdArmaMec`)))
      LEFT JOIN `surc`.`surc_bienjuridico` ON ((`surc`.`surc_bienjuridico`.`SURC_BienJuridico_Id` = `surc`.`surc_hechodelictivo`.`SURC_HechoDelictivo_IdBienJuri`)))
      LEFT JOIN surc.personasumario on surc.personasumario.SURC_Sumario_Id=surc.surc_sumario.SURC_Sumario_Id

      WHERE (surc.surc_sumario.SURC_Sumario_NroSumMP LIKE '%$nrosumario_mp%' or '$nrosumario_mp'='')
      AND (surc.surc_sumario.SURC_Sumario_TextoRelato LIKE '%$palabra_clave%' or '$palabra_clave'='')
      AND (surc.surc_sumario.SURC_Sumario_Anio = '$anio' OR '$anio'='')
			AND (surc.surc_tiposum.SURC_TipoSum_Id = '$SURC_TipoSum_Id' OR '$SURC_TipoSum_Id' = '')
			AND (surc.surc_origensumario.SURC_OrigenSumario_Id = '$SURC_OrigenSumario_Id' OR '$SURC_OrigenSumario_Id'='')
			AND (dbseg.ref_dependencias.SURC_Sectores_IdCCO='$SURC_CCO_Id' OR '$SURC_CCO_Id'='')
			AND (dbseg.ref_dependencias.SURC_Sectores_Id='$SURC_Sectores_Id' OR '$SURC_Sectores_Id'='')
			AND (dbseg.ref_dependencias.DepPol_Codigo='$codigo_dep' OR '$codigo_dep'='')
      AND (surc.surc_sumario.SURC_Sumario_FechaDel>='$desdehecho' or '$desdehecho'='')
      AND (surc.surc_sumario.SURC_Sumario_FechaDel<='$hastahecho' or '$hastahecho'='')
      AND (surc.surc_sumario.SURC_Sumario_FechaSum>='$desdecarga' or '$desdecarga'='')
      AND (surc.surc_sumario.SURC_Sumario_FechaSum<='$hastacarga' or '$hastacarga'='')
      AND (surc.surc_bienjuridico.SURC_BienJuridico_Id='$SURC_BienJuridico_Id' or '$SURC_BienJuridico_Id'='')
      AND (surc.surc_tipogrdelito.SURC_TipoGrDelito_Id='$SURC_TipoGrDelito_Id' OR '$SURC_TipoGrDelito_Id'='')
			AND (surc.surc_hechodelictivo.SURC_HechoDelictivo_Id='$SURC_HechoDelictivo_Id' OR '$SURC_HechoDelictivo_Id'='')
			AND (surc.surc_modalidad.SURC_Modalidad_Id='$SURC_Modalidad_Id' OR '$SURC_Modalidad_Id'='')
      AND (dbseg.ref_unidadreg.UnidadReg_Codigo='$UnidadReg_Codigo' or '$UnidadReg_Codigo'='')
      AND (surc.surc_sumario.SURC_Sumario_CargaUsuario like '$usu' or '$usu'='')
      AND (surc.surc_sumario.SURC_Sumario_NroDenunciaMP LIKE '$num_xml' or '$num_xml'='')

      ") or die("Problemas con el select datos personas : ".mysqli_error($conex_surc));;

      // $row_sumarios =  mysqli_fetch_array($sumarios);
      $num_row_sumarios= $sumario_excel->num_rows;
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
			<th style="background-color:#D8D8D8;">Sector</th>
			<th style="background-color:#D8D8D8;">Unidad Regional</th>
			<th style="background-color:#D8D8D8;">Tipo Sumario</th>
			<th style="background-color:#D8D8D8;">Origen Sumario</th>
			<th style="background-color:#D8D8D8;">Localidad</th>
			<th style="background-color:#D8D8D8;">Barrio</th>
			<th style="background-color:#D8D8D8;">Nom.Calle</th>
      <th style="background-color:#D8D8D8;">Alt.Calle</th>
      <th style="background-color:#D8D8D8;">Coord.X</th>
      <th style="background-color:#D8D8D8;">Coord.Y</th>
      <th style="background-color:#D8D8D8;">Cuadrícula</th>
      <th style="background-color:#D8D8D8;">Hecho Delictivo</th>
      <th style="background-color:#D8D8D8;">Tentativa</th>
      <th style="background-color:#D8D8D8;">Actuaciones</th>
      <th style="background-color:#D8D8D8;">Tipo Actuaciones</th>
      <th style="background-color:#D8D8D8;">Fecha Actuaciones</th>
      <th style="background-color:#D8D8D8;">Usuario Actuaciones</th>
      <th style="background-color:#D8D8D8;">Dpcia.Actuaciones</th>
      <th style="background-color:#D8D8D8;">Fecha Delito</th>
      <th style="background-color:#D8D8D8;">Hora Delito</th>
      <th style="background-color:#D8D8D8;">Dia Semana</th>
      <th style="background-color:#D8D8D8;">Lugar Hecho</th>
      <th style="background-color:#D8D8D8;">Fiscalía</th>
      <th style="background-color:#D8D8D8;">Modalidad</th>
      <th style="background-color:#D8D8D8;">Arma o Mecanismo</th>
      <th style="background-color:#D8D8D8;">Bien Jurídico</th>
      <th style="background-color:#D8D8D8;">Descripción Hecho</th>
      <th style="background-color:#D8D8D8;">Hecho VIF</th>
      <th style="background-color:#D8D8D8;">Violencia de Genero</th>
      <th style="background-color:#D8D8D8;">Fecha Carga</th>
      <th style="background-color:#D8D8D8;">Hora Carga</th>
      <th style="background-color:#D8D8D8;">Usuario</th>
      <th style="background-color:#D8D8D8;">Tipo Persona</th>
      <th style="background-color:#D8D8D8;">Clase Persona</th>
      <th style="background-color:#D8D8D8;">Vinculo Persona</th>
      <th style="background-color:#D8D8D8;">Documento</th>
      <th style="background-color:#D8D8D8;">Apellido y Nombre</th>
      <th style="background-color:#D8D8D8;">Sexo</th>
      <th style="background-color:#D8D8D8;">Fecha Nacimiento</th>
      <th style="background-color:#D8D8D8;">Edad</th>
      <th style="background-color:#D8D8D8;">Alias</th>
      <th style="background-color:#D8D8D8;">Telefono</th>
      <th style="background-color:#D8D8D8;">Estado Civil</th>
		</tr>
	   <?php
     $i = 0;
     while ($row_sumarios =  mysqli_fetch_array($sumario_excel)) {
        ++$i; ?>
        <tr height="10px">
          <td><?= $i ?></td>
          <td><?= $row_sumarios['NroSumario_MP'] ?></td>
          <td><?= $row_sumarios['Anio'] ?></td>
          <td><?= utf8_encode($row_sumarios['Dependencia']) ?></td>
          <td><?= utf8_encode($row_sumarios['Sector']) ?></td>
          <td><?= utf8_encode($row_sumarios['Unidad_Regional']) ?></td>
          <td><?= utf8_encode($row_sumarios['Tipo_Sumario']) ?></td>
          <td><?= utf8_encode($row_sumarios['Origen_Sumario']) ?></td>
          <td><?= utf8_encode($row_sumarios['Localidad']) ?></td>
          <td><?= utf8_encode($row_sumarios['Barrio']) ?></td>
          <td><?= utf8_encode($row_sumarios['Nom_Calle']) ?></td>
          <td><?= $row_sumarios['Alt_Calle'] ?></td>
          <td><?= $row_sumarios['Coord_X'] ?></td>
          <td><?= $row_sumarios['Coord_Y'] ?></td>
          <td><?= utf8_encode($row_sumarios['Cuadricula']) ?></td>
          <td><?= utf8_encode($row_sumarios['Hecho_Delictivo']) ?></td>
          <td><?= utf8_encode($row_sumarios['Tentativa']) ?></td>
          <td><?= utf8_encode($row_sumarios['Actuacion_Esc']) ?></td>
          <td><?= utf8_encode($row_sumarios['Tipo_Actuac']) ?></td>
          <td><?= $row_sumarios['Fecha_Actuac'] ?></td>
          <td><?= $row_sumarios['Usuario_Actuac'] ?></td>
          <td><?= utf8_encode($row_sumarios['Dep_Actuac']) ?></td>
          <td><?= $row_sumarios['Fecha_Delito'] ?>  </td>
          <td>
            <?php if (!empty($row_sumarios['Hora_Delito'])) {
                echo date('H:i:s',strtotime("$row_sumarios[Hora_Delito] - 3 hours"));}?>

           </td>
          <td>
            <?php
            if (!empty($row_sumarios['Fecha_Delito'])) {
              switch ($row_sumarios['Dia_Semana']) {
                case 'Monday':
                  echo "Lunes";
                  break;

                case 'Tuesday':
                    echo "Martes";
                    break;

                case 'Wednesday':
                    echo "Miércoles";
                    break;

                case 'Thursday':
                        echo "Jueves";
                        break;

                case 'Friday':
                    echo "Viernes";
                    break;

                case 'Saturday':
                    echo "Sábado";
                    break;

                case 'Sunday':
                    echo "Domingo";
                    break;
              } {
                // code...
              }
            }
             ?>
          </td>
          <td><?= utf8_encode($row_sumarios['Lugar_Hecho']) ?></td>
          <td><?= utf8_encode($row_sumarios['Fiscalia']) ?></td>
          <td><?= utf8_encode($row_sumarios['Modalidad']) ?></td>
          <td><?= utf8_encode($row_sumarios['Arma_Mecanismo']) ?></td>
          <td><?= utf8_encode($row_sumarios['Bien_Jurídico']) ?></td>
          <td nowrap><?= utf8_encode($row_sumarios['Descrip_Hecho']) ?></td>
          <td><?= $row_sumarios['Hecho_VIF'] ?></td>
          <td><?= $row_sumarios['Violencia_genero'] ?></td>
          <td><?= $row_sumarios['Fecha_Carga'] ?></td>
          <td>
            <?php if (!empty($row_sumarios['Hora_Carga'])) {
                echo date('H:i:s',strtotime("$row_sumarios[Hora_Carga] - 3 hours"));}?>


          </td>

          <td><?= utf8_encode($row_sumarios['Usuario']) ?></td>
          <td><?= utf8_encode($row_sumarios['Tipo_Persona']) ?></td>
          <td><?= utf8_encode($row_sumarios['Clase_Persona']) ?></td>
          <td><?= utf8_encode($row_sumarios['Vinculo_Persona']) ?></td>
          <td><?= utf8_encode($row_sumarios['Documento']) ?></td>
          <td><?= utf8_encode($row_sumarios['ApellidoyNombre']) ?></td>
          <td><?= utf8_encode($row_sumarios['Sexo']) ?></td>
          <td><?= utf8_encode($row_sumarios['Fecha_Nac']) ?></td>
          <td><?= utf8_encode($row_sumarios['Edad']) ?></td>
          <td><?= utf8_encode($row_sumarios['Alias']) ?></td>
          <td><?= utf8_encode($row_sumarios['Telefono']) ?></td>
          <td><?= utf8_encode($row_sumarios['Est_Civil']) ?></td>
        </tr>

<?php
}
 ?>


	</table>
</body>
</html>
