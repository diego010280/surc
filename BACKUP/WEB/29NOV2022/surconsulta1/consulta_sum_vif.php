<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');



$foco=0;
$foco1=0;

$foco2=0;

if (!empty($_REQUEST['SURC_CCO_Id'])) {
  $foco=1;
}

$vacio=false;

if (!empty($_REQUEST['DepPol_Codigo1'])) {
  $foco1=1;
}
// if (!empty($_REQUEST['SURC_TipoGrDelito_Id'])) {
//   $foco2=1;
// }

if (isset($_REQUEST['total_registros'])){
  $total_registros=$_REQUEST['total_registros'];

}


// Paginacion de Grilla

$tamano_pagina=10;

if (isset($_REQUEST['posi'])) {
  $inicio= $_REQUEST['posi'];
  $anterior=$_REQUEST['posi'];
}else {
  $inicio=0;
  $anterior=0;
}

// if (empty($anterior)) {
//     $anterior=0;
// }

// BOTON BUSCAR ..................................//
if (isset($_REQUEST['buscador']) or isset($_REQUEST['go_back'])) {

    if (empty($_REQUEST['nrosumario_mp']) and empty($_REQUEST['palabra_clave']) and empty($_REQUEST['anio']) and
        empty($_REQUEST['SURC_CCO_Id']) and empty($_REQUEST['SURC_Sectores_Id']) and empty($_REQUEST['DepPol_Codigo']) and empty($_REQUEST['DepPol_Codigo1']) and
        empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) ) {

        $vacio=true;

    } else {

      $palabra_clave   = (empty($_REQUEST['palabra_clave'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['palabra_clave']));
      $nrosumario_mp   = (empty($_REQUEST['nrosumario_mp'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['nrosumario_mp'])); //like
      $anio            = (empty($_REQUEST['anio'])) ? '' : intval($_REQUEST['anio']);
      // $SURC_TipoSum_Id = (empty($_REQUEST['SURC_TipoSum_Id'])) ? '' : intval($_REQUEST['SURC_TipoSum_Id']);
      // $SURC_OrigenSumario_Id = (empty($_REQUEST['SURC_OrigenSumario_Id'])) ? '' : intval($_REQUEST['SURC_OrigenSumario_Id']);
      $SURC_CCO_Id     = (empty($_REQUEST['SURC_CCO_Id'])) ? '': intval($_REQUEST['SURC_CCO_Id']);
      $SURC_Sectores_Id= (empty($_REQUEST['SURC_Sectores_Id'])) ? '' : intval($_REQUEST['SURC_Sectores_Id']);

      $DepPol_Codigo   = (empty($_REQUEST['DepPol_Codigo'])) ? '' : intval($_REQUEST['DepPol_Codigo']);
      $DepPol_Codigo1   = (empty($_REQUEST['DepPol_Codigo1'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['DepPol_Codigo1']));


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
      // $hastahecho = (empty($_REQUEST['hastahecho'])) ? date('Y-m-d') : $_REQUEST['hastahecho'];
      $hastahecho = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'];

      // $desdecarga = (empty($_REQUEST['desdecarga'])) ? null : $_REQUEST['desdecarga'];
      // $hastacarga = (empty($_REQUEST['hastacarga'])) ? date('Y-m-d') : $_REQUEST['hastacarga'];
      // $hastacarga = (empty($_REQUEST['hastacarga'])) ? null : $_REQUEST['hastacarga'];

      // $SURC_TipoGrDelito_Id= (empty($_REQUEST['SURC_TipoGrDelito_Id'])) ? '' : intval($_REQUEST['SURC_TipoGrDelito_Id']);


      // if (empty($_REQUEST['SURC_HechoDelictivo_Id'])) {
      //     $SURC_HechoDelictivo_Id= '';
      // } else {
      //   $hechodelictivo = explode(" ", $_REQUEST['SURC_HechoDelictivo_Id']);
      //   $SURC_HechoDelictivo_Id = intval($hechodelictivo[0]);
      // }
      //
      // if (empty($_REQUEST['SURC_Modalidad_Id'])) {
      //     $SURC_Modalidad_Id = '';
      // } else {
      //   $modalidad = explode(" ",$_REQUEST['SURC_Modalidad_Id']);
      //   $SURC_Modalidad_Id = intval($modalidad[0]);
      // }
      //
      //
      // if (empty($_REQUEST['UnidadReg_Codigo'])) {
      //         $UnidadReg_Codigo= '';
      // } else {
      //   $unidad = explode(" ",$_REQUEST['UnidadReg_Codigo']);
      //   $UnidadReg_Codigo = intval($unidad[0]);
      // }
      //
      // if (empty($_REQUEST['usuario'])) {
      //   $usu='';
      // }else {
      //   $usuar=explode("-",$_REQUEST['usuario']);
      //   $usu=trim($usuar[0]);
      // }
      //
      // $num_xml   = (empty($_REQUEST['num_xml'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['num_xml'])); //like


      $sumarios= mysqli_query($conex_surc,"SELECT
        Id_sumario,NroSumario_MPsdt as 'NroSumario_MP',
        Aniosdt as 'Anio', Id_dependenciasdt,Dependenciasdt,
        Unidad_Regionalsdt as 'Unidad_Regional',
        Tipo_Sumariosdt as 'Tipo_Sumario',
			  Origen_Sumariosdt as 'Origen_Sumario',
        Grupo_Delictivosdt as'Agrupamiento_Delictivo',
        Fecha_Delito_sdt as 'Fecha_Delito'

			FROM surc.sumariovif
			LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo= surc.sumariovif.Id_dependenciasdt
			LEFT JOIN surc.surc_sectores ON (surc.surc_sectores.SURC_Sectores_IdCCO=dbseg.ref_dependencias.SURC_Sectores_IdCCO)and(surc.surc_sectores.SURC_Sectores_Id=dbseg.ref_dependencias.SURC_Sectores_Id)

			WHERE (surc.sumariovif.NroSumario_MPsdt LIKE '%$nrosumario_mp%' or '$nrosumario_mp'='')
      AND (surc.sumariovif.textosdt LIKE '%$palabra_clave%' or '$palabra_clave'='')
      AND (surc.sumariovif.Aniosdt = '$anio' OR '$anio'='')
			AND (dbseg.ref_dependencias.SURC_Sectores_IdCCO='$SURC_CCO_Id' OR '$SURC_CCO_Id'='')
			AND (dbseg.ref_dependencias.SURC_Sectores_Id='$SURC_Sectores_Id' OR '$SURC_Sectores_Id'='')
			AND (dbseg.ref_dependencias.DepPol_Codigo='$codigo_dep' OR '$codigo_dep'='')
      AND (surc.sumariovif.Fecha_Delito_sdt >= '$desdehecho' OR '$desdehecho'='')
      AND (surc.sumariovif.Fecha_Delito_sdt <= '$hastahecho' or '$hastahecho'='')

		  LIMIT $inicio, $tamano_pagina ") or die("Problemas con el select consulta datos script consulta_sum_vif.php : ".mysqli_error($conex_surc));;

	  //En la consulta te faltó LEFT JOIN surc.surc_modalidad ON ..
      //En el WHERE tenes que considerar cuando las variables vienen vacias -> surc.campo = '$variable' or '$variable'=''
	  //La lectura del conjunto de resultados $sumarios se realiza en consulta_sum_grid.php. Aqui estas leyendo solo el primer registro

	   $row_sumarios =  mysqli_fetch_array($sumarios);
     $num_row_sumarios= $sumarios->num_rows;

    //echo $num_row_sumarios;
      //TOTAL Registros

		if (!isset($_REQUEST['go_back'])) {


        $total = mysqli_query($conex_surc,"SELECT count(*) as totalregistros FROM surc.sumariovif
        LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo= surc.sumariovif.Id_dependenciasdt
        LEFT JOIN surc.surc_sectores ON (surc.surc_sectores.SURC_Sectores_IdCCO=dbseg.ref_dependencias.SURC_Sectores_IdCCO)and(surc.surc_sectores.SURC_Sectores_Id=dbseg.ref_dependencias.SURC_Sectores_Id)
        WHERE (surc.sumariovif.NroSumario_MPsdt LIKE '%$nrosumario_mp%' or '$nrosumario_mp'='')
        AND (surc.sumariovif.textosdt LIKE '%$palabra_clave%' or '$palabra_clave'='')
        AND (surc.sumariovif.Aniosdt = '$anio' OR '$anio'='')
        AND (dbseg.ref_dependencias.SURC_Sectores_IdCCO='$SURC_CCO_Id' OR '$SURC_CCO_Id'='')
        AND (dbseg.ref_dependencias.SURC_Sectores_Id='$SURC_Sectores_Id' OR '$SURC_Sectores_Id'='')
        AND (dbseg.ref_dependencias.DepPol_Codigo='$codigo_dep' OR '$codigo_dep'='')
        AND (surc.sumariovif.Fecha_Delito_sdt >= '$desdehecho' OR '$desdehecho'='')
        AND (surc.sumariovif.Fecha_Delito_sdt <= '$hastahecho' or '$hastahecho'='')
			  ") or die("Problemas con el select datos txt : ".mysqli_error($conex_surc));;

		$num_total_reg = mysqli_fetch_array($total);

		$total_registros = $num_total_reg['totalregistros'];
		}
    }

    }

    // Modulo vif
$modVif = mysqli_query($conexion, "SELECT modulo_id FROM segusuario.modulos WHERE modulo_descrip = 'VIF'")
  or die('Problemas con mod VIF');
$row_modVif = mysqli_fetch_array($modVif);

	//echo"valor de legajo vif  ".$_SESSION['vif_legajo_id'];
  //BOTON GENERAR EXCEL...................................///
  // mysqli_close($conex_surc);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <script type="text/javascript" defer src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" defer src="js/JFunciones.js?v=1.02"></script>
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
    <div class="mensaje">
					<div id="mensaje"> <?php
            if ($vacio) {
              	echo '<span class="naranja">Debe elegir o rellenar uno o mas campos del filtro para realizar la busqueda</span>';
            }
           ?>
					</div>
		</div>



    <article id="artUno">
        <section id='buscador'>
              <h1>Buscador Sumarios VIF</h1>

              <div id="find">

                  <div id="cpanel1">

                    <form action="consulta_sum_vif.php" method="post" autocomplete="off">

                        <table class="plus conmargen">
                          <thead>
                            <tr>
                              <td>Nro.Sum.MP.</td>
                              <td>Año</td>
                              <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
                              <td>Buscar por Palabra Clave Texto Relato</td>

                            </tr>

                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <input type="text" name="nrosumario_mp" value="<?php if (isset($_REQUEST['nrosumario_mp'])) {
                                  echo $_REQUEST['nrosumario_mp'];
                                }else {
                                  echo "";
                                } ?>" maxlength="40">
                              </td>
                              <td>
                                <input type="number" name="anio" value="<?php if(isset($_REQUEST['anio'])){
                                  echo $_REQUEST['anio'];
                                } else {
                                  echo "";
                                } ?>" maxlength="4" style="width:60px;">
                              </td>

                              <td>&nbsp; &nbsp; </td>
                              <td>
                                <input type="text" style="width:200px;" name="palabra_clave" value="<?php if (isset($_REQUEST['palabra_clave'])) {
                                  echo $_REQUEST['palabra_clave'];
                                }else {
                                  echo "";
                                } ?>" maxlength="60">


                              </td>

                            </tr>
                          </tbody>
                        </table>

                        <table class="plus conmargen">
                            <thead>
                              <tr>
                                <td>Área Geográfica</td>
                                <td>Sectores</td>
                                <td>Dependencia Policial</td>
                                <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
                                <td>Otras Entidades o Dependencias(No sectorizada)</td>

                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <select name="SURC_CCO_Id" onchange="submit()" <?php if ($foco1==0) {echo 'autofocus';} else {
                                    echo 'disabled';} ?> >

                                        <option value="">Seleccionar</option>

                                        <?php
                                          $cco=mysqli_query($conex_surc,"SELECT * FROM `surc_cco`")
                                          or  die("Problemas con el select área geográfica : ".mysqli_error($conex_surc));
                                          $row_cco=mysqli_fetch_array($cco);

                                          do {?>
                                            <option value="<?php echo $row_cco['SURC_CCO_Id'] ?>" <?php if (isset($_REQUEST['SURC_CCO_Id']) and $_REQUEST['SURC_CCO_Id']==$row_cco['SURC_CCO_Id']) {
                                              echo 'selected';
                                            } ?>>
                                            <?php echo utf8_encode($row_cco['SURC_CCO_Descrip']); ?>

                                            </option>
                                        <?php  } while ($row_cco=mysqli_fetch_array($cco)); ?>

                                    </select>
                                </td>
                                <td>
                                  <select type="text" class="select" name="SURC_Sectores_Id" onchange="submit()" <?php if (($foco==0) || ($foco1==1)) {
                                          echo 'disabled';
                                        } else {
                                          echo 'autofocus';
                                        } ?> >
                                        <option value="<?php if (isset($_REQUEST['SURC_Sectores_Id'])) {
                                          echo $SURC_Sectores_Id;
                                        }else {
                                          echo "";
                                        } ?>">Seleccionar</option>
                                          <?php

                                          if (!empty($_REQUEST['SURC_CCO_Id'])) {


                                          $sectores=mysqli_query($conex_surc,"SELECT * FROM `surc_sectores` WHERE `SURC_Sectores_IdCCO`= '$_REQUEST[SURC_CCO_Id]'")
                                          or  die("Problemas con el select de sectores : ".mysqli_error($conex_surc));

                                          $row_sectores=mysqli_fetch_array($sectores);

                                          do {?>
                                              <option value="<?php echo $row_sectores['SURC_Sectores_Id']?>" <?php if (isset($_REQUEST['SURC_Sectores_Id']) and $_REQUEST['SURC_Sectores_Id']==$row_sectores['SURC_Sectores_Id']) {
                                                echo 'selected';
                                              } ?>>
                                              <?php echo utf8_encode($row_sectores['SURC_Sectores_Descrip']); ?>
                                              </option>
                                        <?php } while ($row_sectores=mysqli_fetch_array($sectores));
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                  <select type="text" class="select" name="DepPol_Codigo" <?php if (($foco==0) || ($foco1==1)) {
                                            echo 'disabled';
                                          } else {
                                            echo 'autofocus';
                                          } ?>>

                                          <option value="<?php if (isset($_REQUEST['DepPol_Codigo'])) {
                                            echo $_REQUEST['DepPol_Codigo'];
                                          } else {
                                            echo "";
                                          } ?>">Seleccionar</option>
                                            <?php
                                            if (!empty($_REQUEST['SURC_CCO_Id']) and !empty($_REQUEST['SURC_Sectores_Id'])) {

                                              $dependencia=mysqli_query($conex_dbseg,"SELECT * FROM ref_dependencias WHERE SURC_Sectores_IdCCO='$_REQUEST[SURC_CCO_Id]' and SURC_Sectores_Id='$_REQUEST[SURC_Sectores_Id]'")
                                              or  die("Problemas con el select de dependencia : ".mysqli_error($conex_dbseg));
                                              $row_depen=mysqli_fetch_array($dependencia);

                                              do {?>
                                                <option value="<?php echo $row_depen['DepPol_Codigo']; ?>" <?php if (isset($_REQUEST['SURC_CCO_Id']) and isset($_REQUEST['SURC_Sectores_Id']) and
                                                $_REQUEST['SURC_CCO_Id']==$row_depen['SURC_Sectores_IdCCO'] and
                                                $_REQUEST['SURC_Sectores_Id']==$row_depen['SURC_Sectores_Id'] and
                                                $_REQUEST['DepPol_Codigo']==$row_depen['DepPol_Codigo']) {
                                                  echo 'selected';
                                                } ?>>
                                                <?php echo utf8_encode($row_depen['DepPol_Descrip']); ?>
                                          </option>
                                          <?php } while ($row_depen=mysqli_fetch_array($dependencia));
                                          }
                                          ?>
                                          </select>
                                </td>
                                <td>&nbsp; &nbsp; </td>
                                <td>
                                  <input type="text" list="otraentidad" value="<?php if (isset($_REQUEST['DepPol_Codigo1'])) {
                                    echo $_REQUEST['DepPol_Codigo1'];} else {
                                    echo "";
                                  } ?>" name="DepPol_Codigo1" onclick="this.select()" size="45" placeholder="Seleccionar Dependencia" onchange="submit()"
                                          <?php if ($foco==1) {
                                            echo 'disabled';
                                          } else {
                                            echo 'autofocus';
                                          } ?>>

                                          <?php

                                          echo '<datalist id="otraentidad">';
                                          $otradepen=mysqli_query($conex_dbseg,"SELECT * FROM ref_dependencias WHERE SURC_Sectores_IdCCO is null or SURC_Sectores_Id is null")
                                          or  die("Problemas con el select de otras entidades o dependencia(no sectorizada) : ".mysqli_error($conex_dbseg));

                                          $row_entidad=mysqli_fetch_array($otradepen);

                                          do {?>
                                            <option value="<?php echo $row_entidad['DepPol_Codigo']." ".utf8_encode($row_entidad['DepPol_Descrip']); ?>"></option>
                                          <?php  } while ($row_entidad=mysqli_fetch_array($otradepen));

                                          echo '</datalist>';


                                  ?>

                                </td>

                              </tr>
                            </tbody>
                        </table>

                        <table class="plus conmargen">
                          <thead>
                            <tr>
                              <td><h4>Fecha del Hecho</h4></td>
                            </tr>
                            <tr>
                              <td>Desde</td>
                              <td>Hasta</td>

                            </tr>
                          </thead>
                          <tbody>

                            <tr>

                              <td>
                                <input type="date" name="desdehecho" style="width:132px" value="<?php if (isset($_REQUEST['desdehecho'])) {
                                              echo $_REQUEST['desdehecho'];
                                      } ?>">
                              </td>
                              <td>
								          <input type="date" name="hastahecho" style="width:132px" value="<?php if (isset($_REQUEST['hastahecho'])) {
                                               echo $_REQUEST['hastahecho'];
                                             } ?>">
                              </td>

                            </tr>
                          </tbody>
                        </table>



                            <div class="pos_buscar">
                 				         <button name="buscador" type="submit" value="buscar" class="btncel"><span class="soloimagen">Buscar</span></button>
                 			       </div>

                             <?php
                             $pgname = 'excel.php';
                             include 'administracion/autorizaciones_objeto_perfil.php';
                             if ($abm_consulta_obj) {  ?>
                               <div class="pos_buscar">
                                   <button type="submit" name="excel" value="excel" class="btncel" formaction="excel.php"><span class="soloimagen">Excel Sum.</span></button>
                               </div>
                          <?php }?>

                          <?php
                              $pgname = 'excelpers.php';
                              include 'administracion/autorizaciones_objeto_perfil.php';
                              if ($abm_consulta_obj) {  ?>
                                <div class="pos_buscar">
                                    <button type="submit" name="excelpers" value="excelpers" class="btncel" formaction="excelpers.php"><span class="soloimagen">Excel Pers.</span></button>
                              </div>
                           <?php }?>

                          <?php
                           $pgname = 'excelozu.php';
                           include 'administracion/autorizaciones_objeto_perfil.php';
                           if ($abm_consulta_obj) {  ?>
                             <div class="pos_buscar">
                                 <button type="submit" name="excelozu" value="excelozu" class="btncel" formaction="excelozu.php"><span class="soloimagen">Excel Agenc.</span></button>
                             </div>
                        <?php }?>

                        <div class="pos_buscar">
                             <button type="submit" class="btncel" form="limpiar"><span class="soloimagen">Limpiar Filtro</span></button>
                         </div>

               
                    </form>

                   <form action="consulta_sum_vif.php" method="post" id="limpiar"></form>


                  </div>
              </div>

        </section>
		
<!-----------------------------------------------BOTON VOLVER A VIF------------------------------------------------------------------------------->		
                    
					
					<?php if (!empty($_SESSION['vif_legajo_id']) ) { ?>
      
                        <form action="../vif/segacceso/checks_intermod_volver.php" method="post">
                          <button class="btnVolveraVif" width="200" name="boton_surc_vif">VOLVER A VIF</button>
                          <input type="hidden" name="usuarioid" value="<?= $_SESSION['usuario_id'] ?> "> 
                          <input type="hidden" name="usuariochar" value="usu"> 
                          <input type="hidden" name="moduloid" value="<?= $row_modVif['modulo_id'] ?>">
                          <input type="hidden" name="vif_legajo_id" value="<?= $_SESSION['vif_legajo_id'] ?>">       
                        </form>
                    
                    <?php
                    }
                    ?><br>


        <section id='grilla'>

            <table id="tabla_abm">
                              <thead>
                                <tr>
                                  <th>Num.MP</th>
                                  <th>Año</th>
                                  <th>Dependencia</th>
                                  <th>UU.RR</th>
                                  <th>Tipo Sumario</th>
                                  <th>Origen Sumario</th>
                                  <th>Grupo Delictivo</th>
                                  <th>Fecha Delito</th>

                                  <th colspan="2"></th>
                                </tr>
                              </thead>
                              <tbody>
                            	<?php
                              $impresos=0;
                            	if (!empty($num_row_sumarios)) {
                                mysqli_data_seek($sumarios,0);
                                while ($row_sumarios = mysqli_fetch_array($sumarios)) {
                                  ++$impresos;?>
                            			<tr>
                                    <td><?= $row_sumarios['NroSumario_MP'] ?></td>
                            				<td><?= $row_sumarios['Anio'] ?></td>
                            				<td><?= utf8_encode($row_sumarios['Dependenciasdt']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Unidad_Regional']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Tipo_Sumario']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Origen_Sumario']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Agrupamiento_Delictivo']) ?></td>
                            				<td><?= $row_sumarios['Fecha_Delito'] ?></td>


                                    <td>
                                          <form action="sum_d_vif.php" method="post">

                                              <input type="image" name="boton" src="imagenes/iconos/lupa.png" width="16" title="Ver" value="">
											  <!--<input ype="hidden" name="vif_legajo_id" value="<?php echo ($vif_legajo_id) ?>">-->
                                              <input type="hidden" name="nrosumario_mp" value="<?= $nrosumario_mp ?>">
                                              <input type="hidden" name="anio" value="<?= $anio ?>">

                                              <input type="hidden" name="SURC_CCO_Id" value="<?= $SURC_CCO_Id ?>">
                                              <input type="hidden" name="SURC_Sectores_Id" value="<?= $SURC_Sectores_Id ?>">
                                              <input type="hidden" name="DepPol_Codigo" value="<?= $DepPol_Codigo ?>">
                                              <input type="hidden" name="DepPol_Codigo1" value="<?= $DepPol_Codigo1 ?>">
                                              <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                                              <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">


                                              <input type="hidden" name="go_back" value="si">
                                              <input type="hidden" name="posi" value="<?= $anterior ?>">
                                							<input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                                              <input type="hidden" name="SURC_Sumario_Id" value="<?= $row_sumarios['Id_sumario'] ?>">
                                              <input type="hidden" name="palabra_clave" value="<?= $palabra_clave ?>">



                                          </form>
                                    </td>

                                      <?php if ($modif) {?>
                                            <td>
                                              <form class="" action="sum_d_upd_vif.php" method="post">
                                                  <input type="image" name="boton" src="imagenes/iconos/pencil.png" width="16" title="Modificar" value="">
												  
                                                  <input type="hidden" name="nrosumario_mp" value="<?= $nrosumario_mp ?>">
                                                  <input type="hidden" name="anio" value="<?= $anio ?>">

                                                  <input type="hidden" name="SURC_CCO_Id" value="<?= $SURC_CCO_Id ?>">
                                                  <input type="hidden" name="SURC_Sectores_Id" value="<?= $SURC_Sectores_Id ?>">
                                                  <input type="hidden" name="DepPol_Codigo" value="<?= $DepPol_Codigo ?>">
                                                  <input type="hidden" name="DepPol_Codigo1" value="<?= $DepPol_Codigo1 ?>">
                                                  <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                                                  <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">


                                                  <input type="hidden" name="go_back" value="si">
                                                  <input type="hidden" name="posi" value="<?= $anterior ?>">
                                    							<input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                                                  <input type="hidden" name="SURC_Sumario_Id" value="<?= $row_sumarios['Id_sumario'] ?>">
                                                  <input type="hidden" name="palabra_clave" value="<?= $palabra_clave ?>">

                                              </form>
                                            </td>
                                      <?php } ?>


                            			</tr>
                                </tbody>
                          <?php  }
                        } else {?>
                          <table >
                            <tr>
                              <td>
                                    <?php
                                      if (isset($_REQUEST['buscador']) or isset($_REQUEST['go_back'])) {?>
                                        <h4 style="color:red;">SIN REGISTROS PARA VISUALIZAR</h4>
                                    <?php  }?>


                              </td>
                            </tr>
                          </table>

                      <?php } ?>

                            </table>


						<!--Paginación  -->


            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px; margin-bottom:-10px; font-family: 'Roboto', sans-serif;font-size:0.813rem">
                  <tr>
                    <td align="right" width="92%" valign="middle">
                      <?php
                            if (isset($_REQUEST['total_registros'])) {
                            $total_registros= $_REQUEST['total_registros'];
                            }

                            if (isset($num_row_sumarios) && ($num_row_sumarios>0)) {

                                              $desde= $inicio+1;

                                        } else {
                                          $desde= $inicio;

                                        }

                                        if (isset($total_registros)) {

                                          if (($inicio + $tamano_pagina)>= $total_registros) {
                                              $hasta=$total_registros;
                                          } else {
                                              $hasta=$inicio+$tamano_pagina;
                                          }

                                        echo "Registros: ".$desde.'-'.$hasta.' de '. $total_registros;

                                        }
                                         else {
                                         echo "Registros: ".$desde.'-'.'0'.' de '. '0';
                                        }

                                        ?>

                            </td>

                  	<td align="right">
                					<?php
                					if ($inicio == 0) {
                						echo '<img src="imagenes/iconos/anterior-claro.png"/> ';

                					} else {
                						$anterior = $inicio - $tamano_pagina;
                					?>
                						<form action="consulta_sum_vif.php" method="post">

                              <input type="hidden" name="nrosumario_mp" value="<?= $nrosumario_mp ?>">
                              <input type="hidden" name="anio" value="<?= $anio ?>">

                              <input type="hidden" name="SURC_CCO_Id" value="<?= $SURC_CCO_Id ?>">
                              <input type="hidden" name="SURC_Sectores_Id" value="<?= $SURC_Sectores_Id ?>">
                              <input type="hidden" name="DepPol_Codigo" value="<?= $DepPol_Codigo ?>">
                              <input type="hidden" name="DepPol_Codigo1" value="<?= $DepPol_Codigo1 ?>">
                              <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                              <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">


                              <input type="hidden" name="go_back" value="si">
                              <input type="hidden" name="posi" value="<?= $anterior ?>">
                              <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                              <input type="hidden" name="SURC_Sumario_Id" value="<?= $row_sumarios['Id_sumario'] ?>">
                              <input type="hidden" name="palabra_clave" value="<?= $palabra_clave ?>">

                							<input type="image" src="imagenes/iconos/anterior-osc.png" title="Página anterior">

                						</form>
                				<?php	}  ?>
    				         </td>

    				         <td>&nbsp;</td>
    				         <td align="right">
                          <?php
                					if ($impresos == $tamano_pagina) {
                						$proximo = $inicio + $tamano_pagina;
                					?>
                						<form action="consulta_sum_vif.php" method="post">
                              <input type="hidden" name="nrosumario_mp" value="<?= $nrosumario_mp ?>">
                							<input type="hidden" name="anio" value="<?= $anio ?>">

                							<input type="hidden" name="SURC_CCO_Id" value="<?= $SURC_CCO_Id ?>">
                              <input type="hidden" name="SURC_Sectores_Id" value="<?=$SURC_Sectores_Id ?>">
                              <input type="hidden" name="DepPol_Codigo" value="<?= $DepPol_Codigo ?>">
                              <input type="hidden" name="DepPol_Codigo1" value="<?= $DepPol_Codigo1 ?>">
                							<input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                							<input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">


                							<input type="hidden" name="posi" value="<?= $proximo ?>">
                							<input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                							<input type="hidden" name="go_back" value="si">
                              <input type="hidden" name="palabra_clave" value="<?= $palabra_clave ?>">

                							<input type="image" src="imagenes/iconos/siguiente-osc.png" title="Página siguiente">
                						</form>
                					<?php
                					} else {
                						echo '<img src="imagenes/iconos/siguiente-claro.png"/>';
                					} ?>

      				        </td>

                  </tr>

            </table>



        </section>


    </article>


  </section>

  <div id="footer"><?php include ('footer.php');?></div>

  <script type="text/javascript" src="js/jquery.js">  </script>
  <script type="text/javascript" src="js/alertify.js">  </script>
  <script type="text/javascript" src="js/campos.js">  </script>
</body>
</html>
