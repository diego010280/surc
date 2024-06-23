<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');



if (!empty($_REQUEST['SURC_Sumario_Id'])) {
	$_SESSION['SURC_Sumario_Id']=$_REQUEST['SURC_Sumario_Id'];
	$_SESSION['nrosumario_mp'] = $_REQUEST['nrosumario_mp'];
	$_SESSION['palabra_clave'] = $_REQUEST['palabra_clave'];
	$_SESSION['anio'] = $_REQUEST['anio'];
	$_SESSION['SURC_TipoSum_Id'] = $_REQUEST['SURC_TipoSum_Id'];
	$_SESSION['SURC_OrigenSumario_Id'] = $_REQUEST['SURC_OrigenSumario_Id'];
	$_SESSION['SURC_CCO_Id'] = $_REQUEST['SURC_CCO_Id'];
	$_SESSION['SURC_Sectores_Id'] = $_REQUEST['SURC_Sectores_Id'];
	$_SESSION['DepPol_Codigo'] = $_REQUEST['DepPol_Codigo'];
	$_SESSION['DepPol_Codigo1'] = $_REQUEST['DepPol_Codigo1'];
	$_SESSION['desdehecho'] = $_REQUEST['desdehecho'];
	$_SESSION['hastahecho'] = $_REQUEST['hastahecho'];
	$_SESSION['desdecarga'] = $_REQUEST['desdecarga'];
	$_SESSION['hastacarga'] = $_REQUEST['hastacarga'];
	$_SESSION['SURC_TipoGrDelito_Id'] = $_REQUEST['SURC_TipoGrDelito_Id'];
	$_SESSION['SURC_HechoDelictivo_Id'] = $_REQUEST['SURC_HechoDelictivo_Id'];
	$_SESSION['SURC_Modalidad_Id'] = $_REQUEST['SURC_Modalidad_Id'];
	$_SESSION['UnidadReg_Codigo'] = $_REQUEST['UnidadReg_Codigo'];
	$_SESSION['go_back'] = $_REQUEST['go_back'];
	$_SESSION['UnidadReg_Codigo'] = $_REQUEST['UnidadReg_Codigo'];
	$_SESSION['posi'] = $_REQUEST['posi'];
	$_SESSION['total_registros'] = $_REQUEST['total_registros'];
	$_SESSION['usuario']=$_REQUEST['usuario'];
	$_SESSION['num_xml']=$_REQUEST['num_xml'];

}

/////*****Recuperar la pestaña elegida******////

if (isset($_REQUEST['tab'])) {
	$activo = $_REQUEST['tab'];
} else {
	$activo = 0;
}

///********************************************///


///********Busqueda del Sumario***************///

$sumarios= mysqli_query($conex_surc,"SELECT SURC_Sumario_Id,SURC_Sumario_ViolGenero,SURC_Sumario_NroDenunciaMP as 'xml', SURC_Sumario_NroSumMP AS 'NroSumario_MP',
SURC_Sumario_Anio AS 'Anio', SURC_TipoDelito_Descripc as 'Caratula',dbseg.ref_dependencias.DepPol_Descrip AS 'Dependencia', surc.surc_tiposum.SURC_TipoSum_Descrip AS 'Tipo_Sumario',		surc.surc_origensumario.SURC_OrigenSumario_Descrip AS 'Origen_Sumario',	dbseg.ref_localidad.Localidad_Descrip AS Localidad,	dbseg.ref_barrio.Barrio_Descrip AS 'Barrio',
SURC_Sumario_NomCalle AS 'Nom_Calle', SURC_Sumario_AltCalle AS 'Alt_Calle',
SURC_Sumario_Piso as 'Piso', SURC_Sumario_Dpto as 'Dpto', SURC_Sumario_Mza as 'Mza', SURC_Sumario_CasaLote as 'lote', SURC_Sumario_CoordX AS 'Coord_X', SURC_Sumario_CoordY AS 'Coord_Y', surc.surc_cuadriculas.SURC_Cuadriculas_Descrip AS 'Cuadricula',
if (SURC_Sumario_FechaDel= '1000-01-01',null, SURC_Sumario_FechaDel) AS 'Fecha_Delito',
if (SURC_Sumario_HoraDel='1000-01-01 00:00:00',null,time(SURC_Sumario_HoraDel)) AS 'Hora_Delito',
surc.surc_lugares.SURC_Lugar_Descrip AS 'Lugar_Hecho',
surc.surc_juzgadofiscalia.SURC_JuzgadoFiscalia_Descrip AS 'Fiscalia',
SURC_Sumario_FechaSum AS 'Fecha_Carga',
time(SURC_Sumario_HoraSum) AS 'Hora_Carga',
SURC_Sumario_TextoRelato AS 'Descrip_Hecho', SURC_Sumario_IdHechoDel as 'Id_Hechodelictivo', surc.surc_hechodelictivo.SURC_HechoDelictivo_Descrip as 'Tipo_hechodelictivo', surc.surc_sumario.SURC_Sumario_Tentativa as 'tentativa', surc.surc_sumario.SURC_HechoDelictivo_VIF as 'hechodelictivo_vif', surc.surc_sumario.SURC_Sumario_IdArmaMec as 'Id_armamec', surc.surc_armamecanismo.SURC_ArmaMecanismo_Descrip as 'desc_armamec', surc.surc_sumario.SURC_Sumario_IdFormaAcc as 'Id_formaacc', surc.surc_formaaccion.SURC_FormaAccion_Descrip as 'desc_formaacc', surc.surc_sumario.SURC_Sumario_IdModalidad as 'Id_modalidad', surc.surc_modalidad.SURC_Modalidad_Descrip as 'desc_modalidad', surc.surc_sumario.SURC_Sumario_IdModoProd as 'Id_modoprod', surc.surc_modoproduccion.SURC_ModoProduccion_Descrip as 'desc_modoprod', surc.surc_sumario.SURC_Sumario_IdCondClim as 'Id_condclim', surc.surc_condclimatica.SURC_CondClimatica_Descrip as 'desc_condclim', surc.surc_sumario.SURC_Sumario_IdVehicHecho as 'Id_vehichecho', surc.surc_vehiculohecho.SURC_VehiculoHecho_Descrip as 'desc_vehichecho' FROM	surc.surc_sumario

LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo = surc.surc_sumario.SURC_Sumario_IdDependencia
LEFT JOIN surc.surc_tipodelito on surc.surc_tipodelito.SURC_TipoDelito_Id=surc.surc_sumario.SURC_Sumario_IdTipoDelitoMP
LEFT JOIN surc.surc_tiposum ON surc.surc_tiposum.SURC_TipoSum_Id = surc.surc_sumario.SURC_Sumario_IdTipoSumario
LEFT JOIN surc.surc_origensumario ON surc.surc_origensumario.SURC_OrigenSumario_Id = surc.surc_sumario.SURC_Sumario_IdOrigSum
LEFT JOIN dbseg.ref_localidad ON dbseg.ref_localidad.Localidad_Codigo = surc.surc_sumario.SURC_Sumario_IdLocalidad
LEFT JOIN dbseg.ref_barrio ON dbseg.ref_barrio.Barrio_Codigo = surc.surc_sumario.SURC_Sumario_IdBarrio
LEFT JOIN surc.surc_cuadriculas ON surc.surc_cuadriculas.SURC_Cuadriculas_Id = surc.surc_sumario.SURC_Sumario_IdCuadricula
LEFT JOIN surc.surc_lugares ON surc.surc_lugares.SURC_Lugar_Id = surc.surc_sumario.SURC_Sumario_IdLugar
LEFT JOIN surc.surc_juzgadofiscalia ON surc.surc_juzgadofiscalia.SURC_JuzgadoFiscalia_Id = surc.surc_sumario.SURC_Sumario_IdJuzFis
LEFT JOIN surc.surc_hechodelictivo ON surc.surc_hechodelictivo.SURC_HechoDelictivo_Id = surc.surc_sumario.SURC_Sumario_IdHechoDel
LEFT JOIN surc.surc_armamecanismo ON surc.surc_armamecanismo.SURC_ArmaMecanismo_Id= surc.surc_sumario.SURC_Sumario_IdArmaMec
LEFT JOIN surc.surc_formaaccion on surc.surc_formaaccion.SURC_FormaAccion_Id = surc.surc_sumario.SURC_Sumario_IdFormaAcc
LEFT JOIN surc.surc_modalidad on surc.surc_modalidad.SURC_Modalidad_Id = surc.surc_sumario.SURC_Sumario_IdModalidad
LEFT JOIN surc.surc_modoproduccion on surc.surc_modoproduccion.SURC_ModoProduccion_Id= surc.surc_sumario.SURC_Sumario_IdModoProd
LEFT JOIN surc.surc_condclimatica on surc.surc_condclimatica.SURC_CondClimatica_Id=surc.surc_sumario.SURC_Sumario_IdCondClim
LEFT JOIN surc.surc_vehiculohecho on surc.surc_vehiculohecho.SURC_VehiculoHecho_Id=surc.surc_sumario.SURC_Sumario_IdVehicHecho

where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or die("Problemas con la consulta sumarios : ".mysqli_error($conex_surc));

	$row_sumarios =  mysqli_fetch_array($sumarios);

$personas=mysqli_query($conex_surc,"SELECT * FROM surc.personasumario
								where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or die("Problemas con la consulta personas sumarios : ".mysqli_error($conex_surc));

$num_row_personas= $personas->num_rows;

$elementos=mysqli_query($conex_surc,"SELECT
        surc.surc_sumarioelemento.SURC_Sumario_Id AS 'SURC_Sumario_Id', surc.surc_sumarioelemento.SURC_SumarioElemento_Id AS 'SURC_SumarioElemento_Id',surc.surc_formaelemento.SURC_FormaElemento_Descrip as 'forma',surc.surc_tipoelemento.SURC_TipoElemento_Descrip AS 'Tipo_Elemento',
 surc.surc_sumarioelemento.SURC_SumarioElemento_CantElem AS 'Cantidad', surc.surc_sumarioelemento.SURC_SumarioElemento_NroSerieE AS 'Numero_de_Serie', surc.surc_sumarioelemento.SURC_SumarioElemento_Obs AS 'Observaciones', surc.surc_formaelemento.SURC_FormaElemento_Descrip AS 'Condicion'  FROM surc.surc_sumarioelemento

 LEFT JOIN surc.surc_tipoelemento ON surc.surc_tipoelemento.SURC_TipoElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle
 LEFT JOIN surc.surc_formaelemento ON surc.surc_formaelemento.SURC_FormaElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma

 where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or die("Problemas con la consulta elemento sumarios : ".mysqli_error($conex_surc));

 $num_row_elementos=$elementos ->num_rows;

 $ampliacion=mysqli_query($conex_surc,"SELECT * FROM surc.surc_sumarioampl
	 			where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'")or die("Problemas con la consulta ampliacion sumarios : ".mysqli_error($conex_surc));

	$num_row_ampliacion=$ampliacion ->num_rows;

	$caratula=mysqli_query($conex_surc,"SELECT * FROM surc.surc_caratulas
						where surc_caratulas_id_sum='$_SESSION[SURC_Sumario_Id]';")or die("Problemas con la consulta caratula de sumarios : ".mysqli_error($conex_surc));
	$row_caratula =  mysqli_fetch_array($caratula);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <link rel="stylesheet" type="text/css" href="css/abm.css?v=2.033">

</head>
<body>
  <header>
		<div id="main">
			<div id="logo"><?php include 'logotipo.php' ?></div>
			<div id="opt-usuario"><?php include 'datoscuenta.php' ?></div>
        </div>
	</header>

	<nav id="nav">
		<?php include 'menu.php' ?>
	</nav>
  <section>
    <article id="artwo">
        <div class="titulo">
            <img src="imagenes/administrador.png" height="32px" width="33px">
            <div class="postitulo">Sumario del Ministerio Público Fiscal</div>
        </div>

				<div class="pos_buscar">
					<form action="consulta_sum.php" method="post">
							<input type="hidden" name="nrosumario_mp" value="<?php echo $_SESSION['nrosumario_mp']; ?>">
							<input type="hidden" name="go_back" value="<?php echo $_SESSION['go_back']; ?>">
							<input type="hidden" name="palabra_clave" value="<?php echo $_SESSION['palabra_clave']; ?>">
							<input type="hidden" name="anio" value="<?php echo $_SESSION['anio']; ?>">
							<input type="hidden" name="SURC_TipoSum_Id" value="<?php echo $_SESSION['SURC_TipoSum_Id']; ?>">
							<input type="hidden" name="SURC_OrigenSumario_Id" value="<?php echo $_SESSION['SURC_OrigenSumario_Id']; ?>">
							<input type="hidden" name="SURC_CCO_Id" value="<?php echo $_SESSION['SURC_CCO_Id']; ?>">
							<input type="hidden" name="SURC_Sectores_Id" value="<?php echo $_SESSION['SURC_Sectores_Id']; ?>">
							<input type="hidden" name="DepPol_Codigo" value="<?php echo $_SESSION['DepPol_Codigo']; ?>">
							<input type="hidden" name="DepPol_Codigo1" value="<?php echo $_SESSION['DepPol_Codigo1']; ?>">
							<input type="hidden" name="desdehecho" value="<?php echo $_SESSION['desdehecho']; ?>">
							<input type="hidden" name="hastahecho" value="<?php echo $_SESSION['hastahecho']; ?>">
							<input type="hidden" name="desdecarga" value="<?php echo $_SESSION['desdecarga']; ?>">
							<input type="hidden" name="hastacarga" value="<?php echo $_SESSION['hastacarga']; ?>">
							<input type="hidden" name="SURC_TipoGrDelito_Id" value="<?php echo $_SESSION['SURC_TipoGrDelito_Id']; ?>">
							<input type="hidden" name="SURC_HechoDelictivo_Id" value="<?php echo $_SESSION['SURC_HechoDelictivo_Id']; ?>">
							<input type="hidden" name="SURC_Modalidad_Id" value="<?php echo $_SESSION['SURC_Modalidad_Id']; ?>">
							<input type="hidden" name="UnidadReg_Codigo" value="<?php echo $_SESSION['UnidadReg_Codigo']; ?>">
							<input type="hidden" name="posi" value="<?php echo $_SESSION['posi']; ?>">
							<input type="hidden" name="total_registros" value="<?php echo $_SESSION['total_registros']; ?>">
							<input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">
							<input type="hidden" name="num_xml" value="<?php echo $_SESSION['num_xml']; ?>">

							<button type="submit"  class="btnGyC" >VOLVER A LA CONSULTA</button>

					</form>

				</div>

        <ul class="tabs group">
          <li <?php if ($activo==0) echo 'class="active"' ?>> <a href="sum_d.php?tab=0">General</a></li>
          <li <?php if ($activo==1) echo 'class="active"' ?> ><a href="sum_d.php?tab=1">Hecho</a> </li>
          <li <?php if ($activo==2) echo 'class="active"' ?>> <a href="sum_d.php?tab=2">Personas</a> </li>
          <li <?php if ($activo==3) echo 'class="active"' ?>> <a href="sum_d.php?tab=3">Elementos</a> </li>
          <!-- <li <?php //if ($activo==4) echo 'class="active"' ?>> <a href="sum_d.php?tab=4">Ampliaciones</a> </li> -->

        </ul>

    		<div id="content">
					<?php
						if ($activo==0) {
							include 'sum_d_gral_dsp.php';
						} elseif ($activo == 1) {
								include 'sum_d_hecho_dsp.php';
						} elseif ($activo==2) {
								include 'sum_d_pers_dsp.php';
						} elseif ($activo==3) {
							include 'sum_d_elem_dsp.php';
						} //elseif ($activo==4) {
							//include 'sum_d_ampl_dsp.php';
						//}
					?>

        </div>

        </div>

    </article>


  </section>
  <div id="footer"><?php include ('footer.php');?></div>


  </script>

</body>
</html>
