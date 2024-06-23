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
    if (empty($_REQUEST['SURC_TipoElemento_Id']) and empty($_REQUEST['SURC_FormaElemento_Id']) AND
        empty($_REQUEST['palabra_clave_elemen']) and empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) ) {
      //mostrar mensaje agregar un valor
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

                WHERE (surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle = '$SURC_TipoElemento_Id' or '$SURC_TipoElemento_Id'='')
                AND (surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma = '$SURC_FormaElemento_Id' OR '$SURC_FormaElemento_Id' = '')
                AND (concat_ws(' ',surc.surc_sumarioelemento.SURC_SumarioElemento_NroSerieE,surc.surc_sumarioelemento.SURC_SumarioElemento_Obs) LIKE '%$palabra_clave_elemen%' or '$palabra_clave_elemen'='')
                AND (surc.surc_sumario.SURC_Sumario_FechaDel>='$desdehecho' or '$desdehecho'='')
                AND (surc.surc_sumario.SURC_Sumario_FechaDel<= '$hastahecho' or '$hastahecho'='')
                LIMIT $inicio, $tamano_pagina") or die("Problemas con el select consulta datos consulta_elemento.php : ".mysqli_error($conex_surc));

                $num_row_elementos=$elementos ->num_rows;

          if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conex_surc,"SELECT count(*) as totalregistros  FROM surc.surc_sumarioelemento

                    LEFT JOIN surc.surc_tipoelemento ON surc.surc_tipoelemento.SURC_TipoElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle
                    LEFT JOIN surc.surc_formaelemento ON surc.surc_formaelemento.SURC_FormaElemento_Id = surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma
                    LEFT JOIN surc.surc_sumario ON surc.surc_sumario.SURC_Sumario_Id=surc.surc_sumarioelemento.SURC_Sumario_Id
                    LEFT JOIN dbseg.ref_dependencias ON dbseg.ref_dependencias.DepPol_Codigo = surc.surc_sumario.SURC_Sumario_IdDependencia

                    WHERE (surc.surc_sumarioelemento.SURC_SumarioElemento_IdTipoEle = '$SURC_TipoElemento_Id' or '$SURC_TipoElemento_Id'='')
                    AND (surc.surc_sumarioelemento.SURC_SumarioElemento_IdForma = '$SURC_FormaElemento_Id' OR '$SURC_FormaElemento_Id' = '')
                    AND (concat_ws(' ',surc.surc_sumarioelemento.SURC_SumarioElemento_NroSerieE,surc.surc_sumarioelemento.SURC_SumarioElemento_Obs) LIKE '%$palabra_clave_elemen%' or '$palabra_clave_elemen'='')
                    AND (surc.surc_sumario.SURC_Sumario_FechaDel>='$desdehecho' or '$desdehecho'='')
                    AND (surc.surc_sumario.SURC_Sumario_FechaDel<= '$hastahecho' or '$hastahecho'='')
                    LIMIT $inicio, $tamano_pagina") or die("Problemas con el select consulta datos consulta_elemento.php : ".mysqli_error($conex_surc));

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
  <title>Consulta Elemento</title>
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
        <h1>Elementos de Sumario</h1>
        <br>

        <div id="find">
          <div id="cpanel1">
            <form  action="consulta_element.php" method="post" autocomplete="off">

              <table class="plus conmargen">
                <thead>
                  <tr>
                    <td>Tipo de Elemento</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Condición</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Palabra Clave (Busca en Nro. de Serie y Observaciones) </td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Fecha Desde</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Fecha Hasta</td>
                    <td>&nbsp; &nbsp;</td>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <select type="text" class="select" name="SURC_TipoElemento_Id" >
                              <option value="">Ninguno</option>
                              <?php
                                  $tipo_element=mysqli_query($conex_surc,"SELECT * FROM surc.surc_tipoelemento")
                                                or  die("Problemas con el select tipo elemento: ".mysqli_error($conex_surc));
                                  $row_tipo_element=mysqli_fetch_array($tipo_element);
                              do {?>
                                <option value="<?php echo $row_tipo_element['SURC_TipoElemento_Id']; ?>" <?php if (isset($_REQUEST['SURC_TipoElemento_Id']) and
                                  $_REQUEST['SURC_TipoElemento_Id']==$row_tipo_element['SURC_TipoElemento_Id']) {
                                  echo "selected";
                                  }  ?>>

                                  <?php echo utf8_encode ($row_tipo_element['SURC_TipoElemento_Descrip']) ?>
                                </option>
                              <?php } while ($row_tipo_element=mysqli_fetch_array($tipo_element)); ?>

                        </select>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <select class="select" name="SURC_FormaElemento_Id">
                          <option value="">Ninguno</option>
                          <?php
                              $tipo_formaelemento=mysqli_query($conex_surc,"SELECT * FROM surc.surc_formaelemento")
                                                  or  die("Problemas con el select tipo forma elemento: ".mysqli_error($conex_surc));
                              $row_tipo_formaelemento=mysqli_fetch_array($tipo_formaelemento);
                           do {?>
                             <option value="<?php echo $row_tipo_formaelemento['SURC_FormaElemento_Id']; ?>" <?php if (isset($_REQUEST['SURC_FormaElemento_Id']) AND
                              $_REQUEST['SURC_FormaElemento_Id']==$row_tipo_formaelemento['SURC_FormaElemento_Id']) {
                               echo "selected";
                             } ?>>
                             <?php echo utf8_encode ($row_tipo_formaelemento['SURC_FormaElemento_Descrip'])  ?>


                             </option>
                           <?php } while ($row_tipo_formaelemento=mysqli_fetch_array($tipo_formaelemento)); ?>


                        </select>


                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <input type="text" class="w21" name="palabra_clave_elemen" value="<?php if (isset($_REQUEST['palabra_clave_elemen'])) {
                          echo $_REQUEST['palabra_clave_elemen'];
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

                <table >
                  <tr>
                    <td>


                    </td>
                  </tr>
                </table>





            </form>
            <form action="consulta_element.php" method="post" id="limpiar"></form>

          </div>

        </div>
      </section>

      <section id='grilla'>
        <table id="tabla_abm">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Nro. Sum.</th>
                  <th>Año Sum.</th>
                  <th>Dependencia</th>
                  <th>Fecha Delito</th>
                  <th>Forma</th>
                  <th>Elemento</th>
                  <th>Nro. de Serie</th>
                  <th>Cantidad</th>
                  <th>Observaciones</th>
                  <th>Condición</th>
                  <th colspan="2"></th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $impresos=0;
                  if (!empty($num_row_elementos)) {
                      mysqli_data_seek($elementos,0);

                      while ($row_elementos = mysqli_fetch_array($elementos)) {
                      ++$impresos;?>
                        <tr>
                          <td><?= $impresos ?></td>
                          <td><?= utf8_encode($row_elementos['Nro_sum_mp']) ?></td>
                          <td><?= utf8_encode($row_elementos['Anio_sum']) ?></td>
                          <td><?= utf8_encode($row_elementos['desc_dependencia']) ?></td>
                          <td><?= date("d-m-Y",strtotime($row_elementos['fecha_Delito'])) ?></td>
                          <td><?= utf8_encode($row_elementos['forma']) ?></td>
                          <td><?= utf8_encode($row_elementos['Tipo_Elemento']) ?></td>
                          <td><?= utf8_encode($row_elementos['Numero_de_Serie']) ?></td>
                          <td><?= $row_elementos['Cantidad'] ?></td>
                          <td><?= utf8_encode($row_elementos['Observaciones']) ?></td>
                          <td><?= utf8_encode($row_elementos['Condicion']) ?></td>
                          <td>
                            <form action="sum_d_elemento.php" method="post">
                                    <input type="image" name="boton" src="imagenes/iconos/lupa.png" width="16" title="Ver" value="">
                                    <input type="hidden" name="SURC_TipoElemento_Id" value="<?= $_REQUEST['SURC_TipoElemento_Id'] ?>">
                                    <input type="hidden" name="SURC_FormaElemento_Id" value="<?= $_REQUEST['SURC_FormaElemento_Id'] ?>">
                                    <input type="hidden" name="SURC_Sumario_Id" value="<?= $row_elementos['SURC_Sumario_Id'] ?>">
                                    <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                                    <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
                                    <input type="hidden" name="go_back" value="si">
                                    <input type="hidden" name="posi" value="<?= $anterior ?>">
                                    <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                                    <input type="hidden" name="palabra_clave_elemen" value="<?= $palabra_clave_elemen ?>">
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

                              if (isset($num_row_elementos) && ($num_row_elementos>0)) {
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

                         <form action="consulta_element.php" method="post">

                           <input type="hidden" name="SURC_FormaElemento_Id" value="<?= $_REQUEST['SURC_FormaElemento_Id'] ?>">
                           <input type="hidden" name="SURC_TipoElemento_Id" value="<?= $_REQUEST['SURC_TipoElemento_Id'] ?>">
                           <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                           <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
                           <input type="hidden" name="go_back" value="si">
                           <input type="hidden" name="posi" value="<?= $anterior ?>">
                           <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                           <input type="hidden" name="palabra_clave_elemen" value="<?= $palabra_clave_elemen ?>">
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
                        <form action="consulta_element.php" method="post">
                          <input type="hidden" name="SURC_FormaElemento_Id" value="<?= $_REQUEST['SURC_FormaElemento_Id'] ?>">
                          <input type="hidden" name="SURC_TipoElemento_Id" value="<?= $_REQUEST['SURC_TipoElemento_Id'] ?>">
                          <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                          <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
                          <input type="hidden" name="go_back" value="si">
                          <input type="hidden" name="posi" value="<?= $proximo ?>">
                          <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                          <input type="hidden" name="palabra_clave_elemen" value="<?= $palabra_clave_elemen ?>">
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
