<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');

$tamano_pagina=12;

if (isset($_REQUEST['posi'])) {
  $inicio= $_REQUEST['posi'];
  $anterior=$_REQUEST['posi'];
}else {
  $inicio=0;
  $anterior=0;
}

if (isset($_REQUEST['total_registros'])){
  $total_registros=$_REQUEST['total_registros'];

}

if (isset($_REQUEST['buscador']) or isset($_REQUEST['go_back'])) {
    if (empty($_REQUEST['palabra_clave']) and empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho'])) {
      //mostrar mensaje agregar un valor
    } else {
        $palabra_clave   = (empty($_REQUEST['palabra_clave'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['palabra_clave']));

        $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
        $hastahecho = (empty($_REQUEST['hastahecho'])) ? NULL : $_REQUEST['hastahecho'];

        $sumarios= mysqli_query($conex_surc,"SELECT
          SURC_Sumario_Id,SURC_Sumario_NroSumMP as 'NroSumario_MP',
          SURC_Sumario_Anio as 'Anio', dbseg.ref_dependencias.DepPol_Descrip,
          dbseg.ref_unidadreg.UnidadReg_Descrip as 'Unidad_Regional',
          surc.surc_tiposum.SURC_TipoSum_Descrip as 'Tipo_Sumario',
  			  surc.surc_origensumario.SURC_OrigenSumario_Descrip as 'Origen_Sumario',
          surc.surc_tipogrdelito.SURC_TipoGrDelito_Descrip as'Agrupamiento_Delictivo',
          surc.surc_sumario.SURC_Sumario_FechaDel as 'Fecha_Delito',
          surc.surc_sumario.SURC_Sumario_CargaUsuario as 'Usuario',
          surc.surc_sumario.SURC_Sumario_FechaSum as 'Fecha_Carga',
          time(surc.surc_sumario.SURC_Sumario_HoraSum) as 'Hora_Carga'

  			FROM surc.surc_sumario
  			LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo= surc.surc_sumario.SURC_Sumario_IdDependencia
  			LEFT JOIN surc.surc_sectores ON (surc.surc_sectores.SURC_Sectores_IdCCO=dbseg.ref_dependencias.SURC_Sectores_IdCCO)and(surc.surc_sectores.SURC_Sectores_Id=dbseg.ref_dependencias.SURC_Sectores_Id)
  			LEFT JOIN dbseg.ref_unidadreg ON dbseg.ref_unidadreg.UnidadReg_Codigo=dbseg.ref_dependencias.UnidadReg_Codigo
  			LEFT JOIN surc.surc_tiposum ON surc.surc_tiposum.SURC_TipoSum_Id=surc.surc_sumario.SURC_Sumario_IdTipoSumario
  			LEFT JOIN surc.surc_origensumario ON surc.surc_origensumario.SURC_OrigenSumario_Id=surc.surc_sumario.SURC_Sumario_IdOrigSum
  			LEFT JOIN surc.surc_hechodelictivo ON surc.surc_hechodelictivo.SURC_HechoDelictivo_Id=surc.surc_sumario.SURC_Sumario_IdHechoDel
  			LEFT JOIN surc.surc_tipogrdelito ON surc.surc_tipogrdelito.SURC_TipoGrDelito_Id = surc.surc_hechodelictivo.SURC_HechoDelictivo_IdTGrDelit
  			LEFT JOIN surc.surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.surc_sumario.SURC_Sumario_IdModalidad


        where (surc.surc_sumario.SURC_Sumario_TextoRelato LIKE '%$palabra_clave%' or '$palabra_clave'='')
        AND (surc.surc_sumario.SURC_Sumario_FechaDel>='$desdehecho' or '$desdehecho'='')
        AND (surc.surc_sumario.SURC_Sumario_FechaDel<= '$hastahecho' or '$hastahecho'='')

        ORDER BY   SURC_Sumario_Anio DESC, surc.surc_sumario.SURC_Sumario_FechaDel DESC
        LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta sumario: ".mysqli_error($conex_surc));

        $row_sumarios =  mysqli_fetch_array($sumarios);
        $num_row_sumarios= $sumarios->num_rows;

        if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conex_surc,"SELECT count(*) as totalregistros  FROM surc.surc_sumario
              			LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo= surc.surc_sumario.SURC_Sumario_IdDependencia
              			LEFT JOIN surc.surc_sectores ON (surc.surc_sectores.SURC_Sectores_IdCCO=dbseg.ref_dependencias.SURC_Sectores_IdCCO)and(surc.surc_sectores.SURC_Sectores_Id=dbseg.ref_dependencias.SURC_Sectores_Id)
              			LEFT JOIN dbseg.ref_unidadreg ON dbseg.ref_unidadreg.UnidadReg_Codigo=dbseg.ref_dependencias.UnidadReg_Codigo
              			LEFT JOIN surc.surc_tiposum ON surc.surc_tiposum.SURC_TipoSum_Id=surc.surc_sumario.SURC_Sumario_IdTipoSumario
              			LEFT JOIN surc.surc_origensumario ON surc.surc_origensumario.SURC_OrigenSumario_Id=surc.surc_sumario.SURC_Sumario_IdOrigSum
              			LEFT JOIN surc.surc_hechodelictivo ON surc.surc_hechodelictivo.SURC_HechoDelictivo_Id=surc.surc_sumario.SURC_Sumario_IdHechoDel
              			LEFT JOIN surc.surc_tipogrdelito ON surc.surc_tipogrdelito.SURC_TipoGrDelito_Id = surc.surc_hechodelictivo.SURC_HechoDelictivo_IdTGrDelit
              			LEFT JOIN surc.surc_modalidad ON surc_modalidad.SURC_Modalidad_Id = surc.surc_sumario.SURC_Sumario_IdModalidad


                    where (surc.surc_sumario.SURC_Sumario_TextoRelato LIKE '%$palabra_clave%' or '$palabra_clave'='')
                    AND (surc.surc_sumario.SURC_Sumario_FechaDel>='$desdehecho' or '$desdehecho'='')
                    AND (surc.surc_sumario.SURC_Sumario_FechaDel<= '$hastahecho' or '$hastahecho'='')
                    LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta sumario: ".mysqli_error($conex_surc));

                    $num_total_reg = mysqli_fetch_array($total);

                		$total_registros = $num_total_reg['totalregistros'];
          }

    }
}





?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <?php include 'head.php' ?>
  <title>Consulta Personas</title>
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

      <section id="buscador_elemen">
        <h1>Personas de Sumario</h1>
        <br>

        <div id="find">
          <div id="cpanel1">
            <form  action="consulta_sumario_me.php" method="post" autocomplete="off">

              <table class="plus conmargen">
                <thead>
                  <tr>
                    <td>Palabra Clave (Busca Relato Denuncia) </td>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <input type="text" class="w21" name="palabra_clave" value="<?php if (isset($_REQUEST['palabra_clave'])) {
                          echo $_REQUEST['palabra_clave'];
                        } else {
                          echo "";
                        } ?>">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <input type="date" name="desdehecho" style="width:132px" value="<?php if (isset($_REQUEST['desdehecho'])) {
                          echo $_REQUEST['desdehecho'];
                        }else {
                          echo "";
                        } ?>">
                      </td>
                        <td>&nbsp; &nbsp;</td>
                        <td>
                          <input type="date" name="hastahecho" style="width:132px" value="<?php if (isset($_REQUEST['hastahecho'])) {
                            echo $_REQUEST['hastahecho'];
                          }else {
                            echo "";
                          } ?>">
                        </td>
                        <td>&nbsp; &nbsp;</td>
                      <td>
                        <div >
                          <button name="buscador" type="submit" value="buscar" class="btncel"><span class="soloimagen">Buscar</span></button>
                        </div>

                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <div>
                            <button type="submit" class="btncel" form="limpiar"><span class="soloimagen">Limpiar Filtro</span></button>
                        </div>
                      </td>

                    </tr>
                </tbody>

                </table>
                <br>





            </form>
            <form action="consulta_sumario_me.php" method="post" id="limpiar"></form>

          </div>

        </div>
      </section>

      <section id='grilla'>
        <table id="tabla_abm">
              <thead>
                <tr>
                  <th>N°</th>
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
                          <td align="right"><?= $impresos ?></td>
                          <td align="right"><?= $row_sumarios['NroSumario_MP'] ?></td>
                          <td align="center"><?= $row_sumarios['Anio'] ?></td>
                          <td><?= utf8_encode($row_sumarios['DepPol_Descrip']) ?></td>
                          <td><?= utf8_encode($row_sumarios['Unidad_Regional']) ?></td>
                          <td><?= utf8_encode($row_sumarios['Tipo_Sumario']) ?></td>
                          <td><?= utf8_encode($row_sumarios['Origen_Sumario']) ?></td>
                          <td><?= utf8_encode($row_sumarios['Agrupamiento_Delictivo']) ?></td>
                          <td align="center"><?=date("d-m-Y",strtotime($row_sumarios['Fecha_Delito']))  ?></td>
                          <td align="right"><?= $row_sumarios['Usuario'] ?></td>
                          <td align="center"><?= $row_sumarios['Fecha_Carga'] ?></td>
                          <td align="center">
                            <?php if (!empty($row_sumarios['Hora_Carga'])) {
                                echo date('H:i:s',strtotime("$row_sumarios[Hora_Carga] - 3 hours"));}?>
                          </td>
                          <td>
                            <form action="sum_d_sumarios_mc.php" method="post">
                                    <input type="image" name="boton" src="imagenes/iconos/lupa.png" width="16" title="Ver" value="">
                                    <input type="hidden" name="SURC_Sumario_Id" value="<?= $row_sumarios['SURC_Sumario_Id'] ?>">
                                    <input type="hidden" name="go_back" value="si">
                                    <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                                    <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
                                    <input type="hidden" name="posi" value="<?= $anterior ?>">
                                    <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                                    <input type="hidden" name="palabra_clave" value="<?= utf8_encode($palabra_clave) ?>">
                            </form>
                          </td>


                        </tr>
                          </tbody>
                    <?php  }
                  } else {?>
                    <table >
                      <tr>
                        <td>
                              <?php
                                if (isset($_REQUEST['buscador']) or isset($_REQUEST['go_back'])) {?>
                                  <h2 style="color:red;">SIN REGISTROS PARA VISUALIZAR</h2>
                              <?php  }?>


                        </td>
                      </tr>
                    </table>

                <?php } ?>



              <!-- paginación -->
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

                              } else {

                                  echo "Registros: ".$desde.'-'.'0'.' de '. '0';
                              }

                         ?>
                      </td>

                      <td align="right">
                        <?php
                          if ($inicio==0) {
                            echo '<img src="imagenes/iconos/anterior-claro.png"/> ';
                          } else {
                            	$anterior = $inicio - $tamano_pagina;


                         ?>

                         <form action="consulta_personas.php" method="post">

                           <input type="hidden" name="palabra_clave" value="<?= $_REQUEST['palabra_clave'] ?>">
                           <input type="hidden" name="go_back" value="si">
                           <input type="hidden" name="posi" value="<?= $anterior ?>">
                           <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                           <input type="image" src="imagenes/iconos/anterior-osc.png" title="Página anterior">


                         </form>

                         <?php } ?>


                      </td>
                      <td>&nbsp;</td>
                      <td align="right">
                        <?php
                            if ($impresos == $tamano_pagina) {
                              $proximo = $inicio + $tamano_pagina;

                        ?>
                        <form action="consulta_sumario_me.php" method="post">
                          <input type="hidden" name="go_back" value="si">
                          <input type="hidden" name="posi" value="<?= $proximo ?>">
                          <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                          <input type="hidden" name="palabra_clave" value="<?= $palabra_clave ?>">
                        	<input type="image" src="imagenes/iconos/siguiente-osc.png" title="Página siguiente">
                        </form>
                      <?php } else {
                        echo '<img src="imagenes/iconos/siguiente-claro.png"/>';
                       } ?>
                      </td>
                    </tr>
              </table>

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
