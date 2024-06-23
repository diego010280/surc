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
if (!empty($_REQUEST['SURC_TipoGrDelito_Id'])) {
  $foco2=1;
}


// Paginacion de Grilla

$tamano_pagina=10;

if (isset($_REQUEST['posi'])) {
  $inicio= $_REQUEST['posi'];
}else {
  $inicio=0;
}


// BOTON BUSCAR ..................................//
if (isset($_REQUEST['buscador']) or isset($_REQUEST['go_back'])) {

    if (empty($_REQUEST['nrosumario_mp']) and empty($_REQUEST['anio']) and empty($_REQUEST['SURC_TipoSum_Id']) and empty($_REQUEST['SURC_OrigenSumario_Id']) and
        empty($_REQUEST['SURC_CCO_Id']) and empty($_REQUEST['SURC_Sectores_Id']) and empty($_REQUEST['DepPol_Codigo']) and empty($_REQUEST['DepPol_Codigo1']) and
        empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) and empty($_REQUEST['desdecarga']) and empty($_REQUEST['hastacarga']) and
        empty($_REQUEST['SURC_TipoGrDelito_Id']) and empty($_REQUEST['SURC_HechoDelictivo_Id']) and empty($_REQUEST['SURC_Modalidad_Id']) and empty($_REQUEST['UnidadReg_Codigo'])) {

        $vacio=true;

    } else {


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
      $hastahecho = (empty($_REQUEST['hastahecho'])) ? date('Y-m-d') : $_REQUEST['hastahecho'];

      $desdecarga = (empty($_REQUEST['desdecarga'])) ? null : $_REQUEST['desdecarga'];
      $hastacarga = (empty($_REQUEST['hastacarga'])) ? date('Y-m-d') : $_REQUEST['hastacarga'];

      $SURC_TipoGrDelito_Id= (empty($_REQUEST['SURC_TipoGrDelito_Id'])) ? '' : intval($_REQUEST['SURC_TipoGrDelito_Id']);


      if (empty($_REQUEST['SURC_HechoDelictivo_Id'])) {
          $SURC_HechoDelictivo_Id= '';
      } else {
        $hechodelictivo = explode(" ", $_REQUEST['SURC_HechoDelictivo_Id']);
        $SURC_HechoDelictivo_Id = intval($hechodelictivo[0]);
      }

      if (empty($_REQUEST['SURC_Modalidad_Id'])) {
          $SURC_Modalidad_Id = '';
      } else {
        $modalidad = explode(" ",$_REQUEST['SURC_Modalidad_Id']);
        $SURC_Modalidad_Id = intval($modalidad[0]);
      }


      if (empty($_REQUEST['UnidadReg_Codigo'])) {
              $UnidadReg_Codigo= '';
      } else {
        $unidad = explode(" ",$_REQUEST['UnidadReg_Codigo']);
        $UnidadReg_Codigo = intval($unidad[0]);
      }


      $sumarios= mysqli_query($conex_surc,"SELECT SURC_Sumario_NroSumMP as 'NroSumario_MP', SURC_Sumario_Anio as 'Anio', dbseg.ref_dependencias.DepPol_Descrip,
			DBSEG.ref_unidadreg.UnidadReg_Descrip as 'Unidad_Regional', SURC.surc_tiposum.SURC_TipoSum_Descrip as 'Tipo_Sumario',
			SURC.surc_origensumario.SURC_OrigenSumario_Descrip as 'Origen_Sumario', SURC.surc_tipogrdelito.SURC_TipoGrDelito_Descrip as'Agrupamiento_Delictivo',surc.surc_sumario.SURC_Sumario_FechaDel as
			'Fecha_Delito',surc.surc_sumario.SURC_Sumario_CargaUsuario as 'Usuario', surc.surc_sumario.SURC_Sumario_FechaSum as 'Fecha_Carga', time(surc.surc_sumario.SURC_Sumario_HoraSum) as 'Hora_Carga'
			FROM surc.surc_sumario
			LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo= surc.surc_sumario.SURC_Sumario_IdDependencia
			LEFT JOIN surc.surc_sectores ON (SURC.surc_sectores.SURC_Sectores_IdCCO=dbseg.ref_dependencias.SURC_Sectores_IdCCO)and(SURC.surc_sectores.SURC_Sectores_Id=dbseg.ref_dependencias.SURC_Sectores_Id)
			LEFT JOIN DBSEG.ref_unidadreg ON DBSEG.ref_unidadreg.UnidadReg_Codigo=dbseg.ref_dependencias.UnidadReg_Codigo
			LEFT JOIN surc.surc_tiposum ON surc.surc_tiposum.SURC_TipoSum_Id=surc.surc_sumario.SURC_Sumario_IdTipoSumario
			LEFT JOIN SURC.surc_origensumario ON SURC.surc_origensumario.SURC_OrigenSumario_Id=SURC.surc_sumario.SURC_Sumario_IdOrigSum
			LEFT JOIN SURC.surc_hechodelictivo ON SURC.surc_hechodelictivo.SURC_HechoDelictivo_Id=SURC.surc_sumario.SURC_Sumario_IdHechoDel
			LEFT JOIN SURC.surc_tipogrdelito ON SURC.surc_tipogrdelito.SURC_TipoGrDelito_Id = surc.surc_hechodelictivo.SURC_HechoDelictivo_IdTGrDelit
			LEFT JOIN surc.surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.surc_sumario.SURC_Sumario_IdModalidad
			WHERE (surc.surc_sumario.SURC_Sumario_NroSumMP LIKE '%$nrosumario_mp%' or '$nrosumario_mp'='')
      AND (surc.surc_sumario.SURC_Sumario_Anio = '$anio' OR '$anio'='')
			AND (surc.surc_tiposum.SURC_TipoSum_Id = '$SURC_TipoSum_Id' OR '$SURC_TipoSum_Id' = '')
			AND (SURC.surc_origensumario.SURC_OrigenSumario_Id = '$SURC_OrigenSumario_Id' OR '$SURC_OrigenSumario_Id'='')
			AND (DBSEG.ref_dependencias.SURC_Sectores_IdCCO='$SURC_CCO_Id' OR '$SURC_CCO_Id'='')
			AND (DBSEG.ref_dependencias.SURC_Sectores_Id='$SURC_Sectores_Id' OR '$SURC_Sectores_Id'='')
			AND (DBSEG.ref_dependencias.DepPol_Codigo='$codigo_dep' OR '$codigo_dep'='')
		  AND (surc.surc_sumario.SURC_Sumario_FechaDel BETWEEN '$desdehecho' and '$hastahecho')
		  AND (surc.surc_sumario.SURC_Sumario_FechaSum BETWEEN '$desdecarga' and '$hastacarga')
			AND (SURC.surc_tipogrdelito.SURC_TipoGrDelito_Id='$SURC_TipoGrDelito_Id' OR '$SURC_TipoGrDelito_Id'='')
			AND (surc.surc_hechodelictivo.SURC_HechoDelictivo_Id='$SURC_HechoDelictivo_Id' OR '$SURC_HechoDelictivo_Id'='')
			AND (surc.surc_modalidad.SURC_Modalidad_Id='$SURC_Modalidad_Id' OR '$SURC_Modalidad_Id'='')
      AND (DBSEG.ref_unidadreg.UnidadReg_Codigo='$UnidadReg_Codigo' or '$UnidadReg_Codigo'='')
		  LIMIT $inicio, $tamano_pagina ") or die("Problemas con el select datos txt : ".mysqli_error($conex_surc));;

	  //En la consulta te faltó LEFT JOIN surc.surc_modalidad ON ..
      //En el WHERE tenes que considerar cuando las variables vienen vacias -> surc.campo = '$variable' or '$variable'=''
	  //La lectura del conjunto de resultados $sumarios se realiza en consulta_sum_grid.php. Aqui estas leyendo solo el primer registro

	   $row_sumarios =  mysqli_fetch_array($sumarios);
     $num_row_sumarios= $sumarios->num_rows;

    //echo $num_row_sumarios;
      //TOTAL Registros

		if (!isset($_REQUEST['go_back'])) {


        $total = mysqli_query($conex_surc,"SELECT count(*) as totalregistros FROM surc.surc_sumario
			  LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo= surc.surc_sumario.SURC_Sumario_IdDependencia
			  LEFT JOIN surc.surc_sectores ON (SURC.surc_sectores.SURC_Sectores_IdCCO=dbseg.ref_dependencias.SURC_Sectores_IdCCO)and(SURC.surc_sectores.SURC_Sectores_Id=dbseg.ref_dependencias.SURC_Sectores_Id)
			  LEFT JOIN DBSEG.ref_unidadreg ON DBSEG.ref_unidadreg.UnidadReg_Codigo=dbseg.ref_dependencias.UnidadReg_Codigo
			  LEFT JOIN surc.surc_tiposum ON surc.surc_tiposum.SURC_TipoSum_Id=surc.surc_sumario.SURC_Sumario_IdTipoSumario
			  LEFT JOIN SURC.surc_origensumario ON SURC.surc_origensumario.SURC_OrigenSumario_Id=SURC.surc_sumario.SURC_Sumario_IdOrigSum
			  LEFT JOIN SURC.surc_hechodelictivo ON SURC.surc_hechodelictivo.SURC_HechoDelictivo_Id=SURC.surc_sumario.SURC_Sumario_IdHechoDel
			  LEFT JOIN SURC.surc_tipogrdelito ON SURC.surc_tipogrdelito.SURC_TipoGrDelito_Id = surc.surc_hechodelictivo.SURC_HechoDelictivo_IdTGrDelit
			  LEFT JOIN surc.surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.surc_sumario.SURC_Sumario_IdModalidad
			  WHERE (surc.surc_sumario.SURC_Sumario_NroSumMP LIKE '%$nrosumario_mp%' or '$nrosumario_mp'='')
			  AND (surc.surc_sumario.SURC_Sumario_Anio = '$anio' OR '$anio'='')
					AND (surc.surc_tiposum.SURC_TipoSum_Id = '$SURC_TipoSum_Id' OR '$SURC_TipoSum_Id' = '')
					AND (SURC.surc_origensumario.SURC_OrigenSumario_Id = '$SURC_OrigenSumario_Id' OR '$SURC_OrigenSumario_Id'='')
					AND (DBSEG.ref_dependencias.SURC_Sectores_IdCCO='$SURC_CCO_Id' OR '$SURC_CCO_Id'='')
					AND (DBSEG.ref_dependencias.SURC_Sectores_Id='$SURC_Sectores_Id' OR '$SURC_Sectores_Id'='')
					AND (DBSEG.ref_dependencias.DepPol_Codigo='$codigo_dep' OR '$codigo_dep'='')
				  AND (surc.surc_sumario.SURC_Sumario_FechaDel BETWEEN '$desdehecho' and '$hastahecho')
				  AND (surc.surc_sumario.SURC_Sumario_FechaSum BETWEEN '$desdecarga' and '$hastacarga')
					AND (SURC.surc_tipogrdelito.SURC_TipoGrDelito_Id='$SURC_TipoGrDelito_Id' OR '$SURC_TipoGrDelito_Id'='')
					AND (surc.surc_hechodelictivo.SURC_HechoDelictivo_Id='$SURC_HechoDelictivo_Id' OR '$SURC_HechoDelictivo_Id'='')
					AND (surc.surc_modalidad.SURC_Modalidad_Id='$SURC_Modalidad_Id' OR '$SURC_Modalidad_Id'='')
			AND (DBSEG.ref_unidadreg.UnidadReg_Codigo='$UnidadReg_Codigo' or '$UnidadReg_Codigo'='')
			  ") or die("Problemas con el select datos txt : ".mysqli_error($conex_surc));;

		$num_total_reg = mysqli_fetch_array($total);

		$total_registros = $num_total_reg['totalregistros'];
		}
    }

    }

  //BOTON GENERAR EXCEL...................................///
  // mysqli_close($conex_surc);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <link rel="stylesheet" type="text/css" href="css/abm.css?v=2.033">
    <link rel="stylesheet" type="text/css" href="/css/alertify.css">
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
    <article id="artUno">
            <section id='buscador'>
              <h1>Buscador</h1>

                <div id="find">

                  <div id="cpanel1">

                    <form action="consulta_sum.php" method="post" autocomplete="off">

                        <table class="plus conmargen">
                          <thead>
                            <tr>
                              <td>Nro.Sum.MP.</td>
                              <td>Año</td>
                              <td>Tipo de Sumario</td>
                              <td>Origen de Sumario</td>
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
                              <td>
                                <select type="text" class="select" name="SURC_TipoSum_Id" >
                                                  <option value="">Ninguno</option>
                                                      <?php
                                                        $tipo_sum= mysqli_query ($conex_surc, "SELECT * FROM `surc_tiposum` ")
                                                        or  die("Problemas con el select tipo sumario : ".mysqli_error($conex_surc));
                                                        $row_tiposum = mysqli_fetch_array($tipo_sum);

                                                      do { ?>
                                                          <option value="<?php echo $row_tiposum['SURC_TipoSum_Id']; ?>" <?php if ( isset($_REQUEST['SURC_TipoSum_Id']) and $_REQUEST['SURC_TipoSum_Id']==$row_tiposum['SURC_TipoSum_Id'] ) {
                                                            echo 'selected';
                                                        } ?>>
                                                          <?php echo utf8_encode ($row_tiposum['SURC_TipoSum_Descrip']) ?>

														  </option>

                                                <?php } while ($row_tiposum = mysqli_fetch_array($tipo_sum)); ?>
                                </select>
                              </td>
                              <td>
                                <select type="text" class="select" name="SURC_OrigenSumario_Id" >
                                                  <option value="">Ninguno</option>
                                                  <?php
                                                  $orig_sum= mysqli_query($conex_surc,"SELECT * FROM `surc_origensumario`")
                                                  or  die("Problemas con el select origen sumario : ".mysqli_error($conex_surc));
                                                  $row_origsum= mysqli_fetch_array($orig_sum);

                                                  do {?>
                                                    <option value="<?php echo $row_origsum['SURC_OrigenSumario_Id'] ;?>" <?php if (isset($_REQUEST['SURC_OrigenSumario_Id']) and $_REQUEST['SURC_OrigenSumario_Id']==$row_origsum['SURC_OrigenSumario_Id']) {
                                                      echo 'selected';
                                                      }?>>
                                                      <?php echo utf8_encode ($row_origsum['SURC_OrigenSumario_Descrip']) ?>


                                                    </option>
                                                  <?php  } while ($row_origsum= mysqli_fetch_array($orig_sum)); ?>

                                </select>
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
                                  <input type="text" list="otraentidad" value="<?php if (isset($_REQUEST['DepPol_Codigo1'])) { echo $_REQUEST['DepPol_Codigo1']; } else {
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
                              <td>Desde</td>
                              <td>Hasta</td>
                              <td>&nbsp;</td>
                              <td><h4>Fecha de Carga</h4></td>
                              <td>Desde</td>
                              <td>Hasta</td>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td></td>
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
                              <td>&nbsp; </td>
                              <td></td>
                              <td>
                                    <input type="date" name="desdecarga" style="width:132px" value="<?php if(isset($_REQUEST['desdecarga'])) {
                                      echo $_REQUEST['desdecarga'];
                                      }?>">
                              </td>
                              <td>
                                <input type="date" name="hastacarga" style="width:132px" value="<?php if (isset($_REQUEST['hastacarga'])) {
                                     echo $_REQUEST['hastacarga'];
                                     } ?>">
                              </td>
                            </tr>
                          </tbody>
                        </table>

						<table class="plus conmargen">
                          <thead>
                            <tr>
                              <td>Agrupamiento Delictivo</td>
                              <td>Hecho Delictivo</td>
                            </tr>
                          </thead>
                          <tbody>

                            <tr>
                              <td>
                                <select name="SURC_TipoGrDelito_Id" onchange="submit()">
                                    <option value="">Seleccionar</option>
                                      <?php
                                      $grup_delito=mysqli_query($conex_surc,"SELECT * FROM surc.surc_tipogrdelito");
                                      $row_grupdelito=mysqli_fetch_array($grup_delito);

                                      do {?>
                                        <option value="<?php echo $row_grupdelito['SURC_TipoGrDelito_Id']; ?>" <?php if (isset($_REQUEST['SURC_TipoGrDelito_Id']) and $_REQUEST['SURC_TipoGrDelito_Id']==$row_grupdelito['SURC_TipoGrDelito_Id']){
                                          echo 'selected';

                                        } ?>>
                                        <?php echo utf8_encode($row_grupdelito['SURC_TipoGrDelito_Descrip']); ?>
                                      </option>
                                    <?php } while ($row_grupdelito=mysqli_fetch_array($grup_delito));

                                    ?>

                                </select>

                              </td>


                              <td>
                                <input type="text" list="hechodelictivo" value="<?php if (isset($_REQUEST['SURC_HechoDelictivo_Id']) and (!empty($_REQUEST['SURC_TipoGrDelito_Id']))) {
                                  echo $_REQUEST['SURC_HechoDelictivo_Id'];
                                } else {
                                  echo "";
                                } ?>" name="SURC_HechoDelictivo_Id" onclick="this.select()" size="45" placeholder="Seleccionar" <?php if ($foco2==0) {
                                        echo 'disabled';
                                      } else {
                                        echo 'autofocus';
                                      }
                                      ?>>

                                      <?php

                                      echo '<datalist id="hechodelictivo">';
                                      $hechos=mysqli_query($conex_surc,"SELECT * FROM surc_hechodelictivo where SURC_HechoDelictivo_IdTGrDelit='$_REQUEST[SURC_TipoGrDelito_Id]'")
                                      or  die("Problemas con el select de Hechos Delictivos: ".mysqli_error($conex_surc));
                                      $row_hechos=mysqli_fetch_array($hechos);


                                      do {?>
                                        <option value="<?php echo $row_hechos['SURC_HechoDelictivo_Id']." ".utf8_encode($row_hechos['SURC_HechoDelictivo_Descrip']); ?>"></option>
                                      <?php  } while ($row_hechos=mysqli_fetch_array($hechos));

                                      echo '</datalist>';

                                      ?>

                                </td>
                            </tr>
                          </tbody>
                        </table>

						<table class="plus conmargen">
                          <thead>
                            <tr>
                              <td>Modalidad</td>
                              <td>Unidad Regional</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <input type="text" list="modalidades" value="<?php if (isset($_REQUEST['SURC_Modalidad_Id'])) {
                                  echo $_REQUEST['SURC_Modalidad_Id'];
                                } else {
                                  echo "";
                                }?>"   name="SURC_Modalidad_Id" onclick="this.select()" size="45" placeholder="Seleccionar">

                                      <?php

                                      echo '<datalist id="modalidades">';
                                      $modalidad=mysqli_query($conex_surc,"SELECT * FROM surc_modalidad")
                                      or  die("Problemas con el select de modalidades : ".mysqli_error($conex_surc));

                                      $row_modalidad=mysqli_fetch_array($modalidad);

                                      do {?>
                                        <option value="<?php echo $row_modalidad['SURC_Modalidad_Id']." ".utf8_encode($row_modalidad['SURC_Modalidad_Descrip']); ?>"></option>
                                      <?php  } while ($row_modalidad=mysqli_fetch_array($modalidad));

                                      echo '</datalist>';

                                      ?>
                              </td>
                              <td>
                                  <input type="text" list="unidad" name="UnidadReg_Codigo" value="<?php if (isset($_REQUEST['UnidadReg_Codigo'])) {
                                    echo $_REQUEST['UnidadReg_Codigo'];
                                  } else {
                                    echo "";
                                  }?>" onclick="this.select()" size="35" placeholder="Seleccionar">
                                  <?php
                                    echo '<datalist id="unidad">';
                                    $unidad=mysqli_query($conex_dbseg,"SELECT * FROM DBSEG.ref_unidadreg")
                                            or  die("Problemas con el select de Unidad Regional : ".mysqli_error($conex_dbseg));
                                    $row_unidad=mysqli_fetch_array($unidad);
                                    do { ?>
                                      <option value="<?php echo $row_unidad['UnidadReg_Codigo']." ".utf8_encode($row_unidad['UnidadReg_Descrip']); ?>"></option>
                                    <?php  } while ($row_unidad=mysqli_fetch_array($unidad));

                                    echo '</datalist>';

                                    ?>

                              </td>

                            </tr>
                          </tbody>
                        </table>

                        <!-- Boton Buscar -->


                        <div class="pos_buscar">
            				<button name="buscador" type="submit" value="buscar" class="btncel"><span class="soloimagen">Buscar</span></button>
            			</div>

                        <div class="pos_buscar">
                            <button type="submit" name="excel" value="excel" class="btncel" formaction="excel.php"><span class="soloimagen">Exportar Excel</span></button>
                        </div>

                        <div class="pos_buscar">
                            <button type="submit" name="excelpers" value="excelpers" class="btncel" formaction="excelpers.php"><span class="soloimagen">Exportar Excel Pers.</span></button>
                      </div>

                        <div class="pos_buscar">
                            <button type="submit" class="btncel" form="limpiar"><span class="soloimagen">Limpiar Filtro</span></button>
                        </div>

                    </form>

					<form action="consulta_sum.php" method="post" id="limpiar"></form>


        </section>

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
                                  <th>Usuario</th>
                                  <th>Fecha</th>
                                  <th>Hora</th>
                                  <th>Acciones</th>
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
                            				<td><?= utf8_encode($row_sumarios['DepPol_Descrip']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Unidad_Regional']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Tipo_Sumario']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Origen_Sumario']) ?></td>
                            				<td><?= utf8_encode($row_sumarios['Agrupamiento_Delictivo']) ?></td>
                            				<td><?= $row_sumarios['Fecha_Delito'] ?></td>
                            				<td><?= $row_sumarios['Usuario'] ?></td>
                            				<td><?= $row_sumarios['Fecha_Carga'] ?></td>
                            				<td><?= $row_sumarios['Hora_Carga'] ?></td>

                            			</tr>
                            		<?php
                            		}
                            	} else { ?>
                            		<tr>
                                  <td >Sin registros para visualizar</td></tr>
                            	<?php
                            	} ?>
                              </tbody>

                            </table>


						<!--Paginación  -->


            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px; margin-bottom:-10px; font-family: 'Roboto', sans-serif;font-size:0.813rem">
              <tr>
                <td align="right" width="92%" valign="middle" ;>
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
						<form action="consulta_sum.php" method="post">
							<input type="hidden" name="nrosumario_mp" value="<?= $_REQUEST['nrosumario_mp'] ?>">
							<input type="hidden" name="anio" value="<?= $_REQUEST['anio'] ?>">
							<input type="hidden" name="SURC_TipoSum_Id" value="<?= $_REQUEST['SURC_TipoSum_Id'] ?>">
							<input type="hidden" name="SURC_OrigenSumario_Id" value="<?= $_REQUEST['SURC_OrigenSumario_Id'] ?>">
							<input type="hidden" name="SURC_CCO_Id" value="<?= $_REQUEST['SURC_CCO_Id'] ?>">
							<input type="hidden" name="SURC_Sectores_Id" value="<?php if (isset($_REQUEST['SURC_Sectores_Id'])) echo $_REQUEST['SURC_Sectores_Id'] ?>">
							<input type="hidden" name="DepPol_Codigo" value="<?php if (isset($_REQUEST['DepPol_Codigo'])) echo $_REQUEST['DepPol_Codigo'] ?>">
							<input type="hidden" name="DepPol_Codigo1" value="<?= $_REQUEST['DepPol_Codigo1'] ?>">
							<input type="hidden" name="desdehecho" value="<?= $_REQUEST['desdehecho'] ?>">
							<input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
							<input type="hidden" name="desdecarga" value="<?= $_REQUEST['desdecarga'] ?>">
							<input type="hidden" name="hastacarga" value="<?= $_REQUEST['hastacarga'] ?>">
							<input type="hidden" name="SURC_TipoGrDelito_Id" value="<?= $_REQUEST['SURC_TipoGrDelito_Id'] ?>">
							<input type="hidden" name="SURC_HechoDelictivo_Id" value="<?php if (isset($_REQUEST['SURC_HechoDelictivo_Id'])) echo $_REQUEST['SURC_HechoDelictivo_Id'] ?>">
							<input type="hidden" name="SURC_Modalidad_Id" value="<?= $_REQUEST['SURC_Modalidad_Id'] ?>">
							<input type="hidden" name="UnidadReg_Codigo" value="<?= $_REQUEST['UnidadReg_Codigo'] ?>">
							<input type="hidden" name="posi" value="<?= $anterior ?>">
							<input type="hidden" name="total_registros" value="<?= $total_registros ?>">
							<input type="hidden" name="go_back" value="si">
							<input type="image" src="imagenes/iconos/anterior-osc.png" title="Página anterior">
						</form>
					<?php
					}  ?>
				</td>
				<td>&nbsp;</td>
				<td align="right">
                    <?php
					if ($impresos == $tamano_pagina) {
						$proximo = $inicio + $tamano_pagina;
					?>
						<form action="consulta_sum.php" method="get">
                            <input type="hidden" name="nrosumario_mp" value="<?= $_REQUEST['nrosumario_mp'] ?>">
							<input type="hidden" name="anio" value="<?= $_REQUEST['anio'] ?>">
							<input type="hidden" name="SURC_TipoSum_Id" value="<?= $_REQUEST['SURC_TipoSum_Id'] ?>">
							<input type="hidden" name="SURC_OrigenSumario_Id" value="<?= $_REQUEST['SURC_OrigenSumario_Id'] ?>">
							<input type="hidden" name="SURC_CCO_Id" value="<?= $_REQUEST['SURC_CCO_Id'] ?>">
                            <input type="hidden" name="SURC_Sectores_Id" value="<?php if (isset($_REQUEST['SURC_Sectores_Id'])) echo $_REQUEST['SURC_Sectores_Id'] ?>">
                            <input type="hidden" name="DepPol_Codigo" value="<?php if (isset($_REQUEST['DepPol_Codigo'])) echo $_REQUEST['DepPol_Codigo'] ?>">
                            <input type="hidden" name="DepPol_Codigo1" value="<?= $_REQUEST['DepPol_Codigo1'] ?>">
							<input type="hidden" name="desdehecho" value="<?= $_REQUEST['desdehecho'] ?>">
							<input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
							<input type="hidden" name="desdecarga" value="<?= $_REQUEST['desdecarga'] ?>">
							<input type="hidden" name="hastacarga" value="<?= $_REQUEST['hastacarga'] ?>">
							<input type="hidden" name="SURC_TipoGrDelito_Id" value="<?= $_REQUEST['SURC_TipoGrDelito_Id'] ?>">
                            <input type="hidden" name="SURC_HechoDelictivo_Id" value="<?php if (isset($_REQUEST['SURC_HechoDelictivo_Id'])) echo $_REQUEST['SURC_HechoDelictivo_Id'] ?>">
                            <input type="hidden" name="SURC_Modalidad_Id" value="<?= $_REQUEST['SURC_Modalidad_Id'] ?>">
                            <input type="hidden" name="UnidadReg_Codigo" value="<?= $_REQUEST['UnidadReg_Codigo'] ?>">
							<input type="hidden" name="posi" value="<?= $proximo ?>">
							<input type="hidden" name="total_registros" value="<?= $total_registros ?>">
							<input type="hidden" name="go_back" value="si">
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
