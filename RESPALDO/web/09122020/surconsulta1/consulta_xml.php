<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/connxml.php');

date_default_timezone_set('America/Argentina/Salta');

$tamano_pagina=20;



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
    if (empty($_REQUEST['xml']) and empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) and empty($_REQUEST['xml_auditoria_estado'])) {

      $xml        = (empty($_REQUEST['xml'])) ? '' : intval($_REQUEST['xml']);
      $desdehecho = null;
      $hastahecho = null;
      $desdehecho_cons = null;
      $hastahecho_cons = null;
      $xml_auditoria_estado='';


      $xml_mp=mysqli_query($conex_xml,"SELECT * FROM xml_auditoria
        WHERE (xml_auditoria_nroxml='$xml' or '$xml'='')
        and (xml_auditoria_fechacarga >= '$desdehecho_cons' or '$desdehecho_cons'='')
        and (xml_auditoria_fechacarga <= '$hastahecho_cons' or '$hastahecho_cons'='')
        and (xml_auditoria_estado='$xml_auditoria_estado' or '$xml_auditoria_estado'='')
        ORDER BY xml_auditoria_fechacarga DESC
        LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conex_xml));



      $num_xml_mp= $xml_mp->num_rows;

      if (!isset($_REQUEST['go_back'])) {
                  $total=mysqli_query($conex_xml,"SELECT count(*) as totalregistros  FROM xml_auditoria
                    WHERE (xml_auditoria_nroxml='$xml' or '$xml'='')
                    and (xml_auditoria_fechacarga>='$desdehecho_cons' or '$desdehecho_cons'='')
                    and (xml_auditoria_fechacarga<='$hastahecho_cons' or '$hastahecho_cons'='')
                    and (xml_auditoria_estado='$xml_auditoria_estado' or '$xml_auditoria_estado'='')
                    ORDER BY xml_auditoria_fechacarga DESC
                    LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conex_xml));

                  $num_total_reg = mysqli_fetch_array($total);

                  $total_registros = $num_total_reg['totalregistros'];
        }





    } else {
        $xml        = (empty($_REQUEST['xml'])) ? '' : intval($_REQUEST['xml']);
        $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
        $hastahecho = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'];
        $desdehecho_cons = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'].' 00:00:00';
        $hastahecho_cons = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'].' 23:59:59';

        switch ($_REQUEST['xml_auditoria_estado']) {
          case 'Cargado':
                $xml_auditoria_estado=1;
            break;

          case 'No Cargado':
                  $xml_auditoria_estado=0;
          break;

          default:
              $xml_auditoria_estado='';
            break;
        }





        $xml_mp=mysqli_query($conex_xml,"SELECT * FROM xml_auditoria
          WHERE (xml_auditoria_nroxml='$xml' or '$xml'='')
          and (xml_auditoria_fechacarga >= '$desdehecho_cons' or '$desdehecho_cons'='')
          and (xml_auditoria_fechacarga <= '$hastahecho_cons' or '$hastahecho_cons'='')
          and (xml_auditoria_estado='$xml_auditoria_estado' or '$xml_auditoria_estado'='')
          ORDER BY xml_auditoria_fechacarga DESC
          LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conex_xml));



        $num_xml_mp= $xml_mp->num_rows;

        if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conex_xml,"SELECT count(*) as totalregistros  FROM xml_auditoria
                      WHERE (xml_auditoria_nroxml='$xml' or '$xml'='')
                      and (xml_auditoria_fechacarga>='$desdehecho_cons' or '$desdehecho_cons'='')
                      and (xml_auditoria_fechacarga<='$hastahecho_cons' or '$hastahecho_cons'='')
                      and (xml_auditoria_estado='$xml_auditoria_estado' or '$xml_auditoria_estado'='')
                      ORDER BY xml_auditoria_fechacarga DESC
                      LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conex_xml));

                    $num_total_reg = mysqli_fetch_array($total);

                		$total_registros = $num_total_reg['totalregistros'];
          }

    }
}else {
  $xml        = (empty($_REQUEST['xml'])) ? '' : intval($_REQUEST['xml']);
  $desdehecho = date("Y-m-d");
  $hastahecho = date("Y-m-d");
  $desdehecho_cons = $desdehecho.' 00:00:00';
  $hastahecho_cons = $hastahecho.' 23:59:59';
  $xml_auditoria_estado='';


  $xml_mp=mysqli_query($conex_xml,"SELECT * FROM xml_auditoria
    WHERE (xml_auditoria_nroxml='$xml' or '$xml'='')
    and (xml_auditoria_fechacarga >= '$desdehecho_cons' or '$desdehecho_cons'='')
    and (xml_auditoria_fechacarga <= '$hastahecho_cons' or '$hastahecho_cons'='')
    and (xml_auditoria_estado='$xml_auditoria_estado' or '$xml_auditoria_estado'='')
    ORDER BY xml_auditoria_fechacarga DESC
    LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conex_xml));



  $num_xml_mp= $xml_mp->num_rows;

  if (!isset($_REQUEST['go_back'])) {
              $total=mysqli_query($conex_xml,"SELECT count(*) as totalregistros  FROM xml_auditoria
                WHERE (xml_auditoria_nroxml='$xml' or '$xml'='')
                and (xml_auditoria_fechacarga>='$desdehecho_cons' or '$desdehecho_cons'='')
                and (xml_auditoria_fechacarga<='$hastahecho_cons' or '$hastahecho_cons'='')
                and (xml_auditoria_estado='$xml_auditoria_estado' or '$xml_auditoria_estado'='')
                ORDER BY xml_auditoria_fechacarga DESC
                LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conex_xml));

              $num_total_reg = mysqli_fetch_array($total);

              $total_registros = $num_total_reg['totalregistros'];
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
        <h1>XML del Ministerio Público</h1>
        <br>

        <div id="find">
          <div id="cpanel1">
            <form  action="consulta_xml.php" method="post" autocomplete="off">

              <table class="plus conmargen">
                <thead>
                  <tr>
                    <td>Número de XML</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Fecha Desde</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Fecha Hasta</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Estado de Carga</td>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <input type="text" class="w8" name="xml" value="<?php if (isset($_REQUEST['xml'])) {
                          echo $_REQUEST['xml'];
                        } else {
                          echo "";
                        } ?>">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <input type="date" name="desdehecho" style="width:132px; height:25px;" value="<?php if (isset($_REQUEST['desdehecho'])) {
                          echo $_REQUEST['desdehecho'];
                        }else {
                          echo $desdehecho;
                        } ?>">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <input type="date" name="hastahecho" style="width:132px; height:25px;" value="<?php if (isset($_REQUEST['hastahecho'])) {
                          echo $_REQUEST['hastahecho'];
                        }else {
                          echo $hastahecho;
                        } ?>">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <select class="select" name="xml_auditoria_estado">
                            <option value=""
                            <?php
                              if (isset($_REQUEST['xml_auditoria_estado']) and ($_REQUEST['xml_auditoria_estado']=='')) {
                                echo "selected";
                              }
                             ?>>Seleccionar</option>
                            <option value="Cargado"
                            <?php
                              if (isset($_REQUEST['xml_auditoria_estado']) and ($_REQUEST['xml_auditoria_estado']=="Cargado")) {
                                echo "selected";
                              }
                             ?>>Cargado</option>
                            <option value="No Cargado"
                            <?php
                            if (isset($_REQUEST['xml_auditoria_estado']) and ($_REQUEST['xml_auditoria_estado']=="No Cargado")) {
                              echo "selected";
                            }
                             ?>>No Cargado</option>
                        </select>

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
            <form action="consulta_xml.php" method="post" id="limpiar"></form>

          </div>

        </div>
      </section>

      <section id='grilla'>
        <table id="tabla_abm">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Nro. XML</th>
                  <th>Id Sum. Surc</th>
                  <th>Codigo Ing.</th>
                  <th>Tipo de Error</th>
                  <!-- <th>Ubicación xml</th> -->

                  <th>Fecha Carga</th>
                  <th>Estado</th>
                  <th colspan="2"></th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $impresos=0;
                  if (!empty($num_xml_mp)) {
                      mysqli_data_seek($xml_mp,0);

                      while ($row_xml_mp = mysqli_fetch_array($xml_mp)) {
                      $impresos++;?>
                        <tr>
                          <td align="right"><?= $row_xml_mp['xml_auditoria_id'] ?></td>
                          <td align="center"><?= $row_xml_mp['xml_auditoria_nroxml']?></td>
                          <td align="center"><?= $row_xml_mp['xml_auditoria_nrosum'] ?></td>
                          <td align="left">
                            <?php

                            switch ($row_xml_mp['xml_auditoria_codigo']) {
                              case '0':
                                    echo "Error Nodo";
                                break;

                              case '1':
                                      echo "XML No Existe";
                                break;

                              case '2':
                                      echo "XML Existe";
                                break;

                              case '3':
                                      echo "Error Auditoria";
                                break;

                              default:
                                // code...
                                break;
                            }

                           ?>
                          </td>

                          <td><?= $row_xml_mp['xml_auditoria_errormysql'] ?></td>


                          <td align="center"><?= $row_xml_mp['xml_auditoria_fechacarga'] ?></td>
                          <td align="center">
                            <?php
                              switch ($row_xml_mp['xml_auditoria_estado']) {
                                case '1':
                                      echo "Cargado";
                                  break;

                                case '0':
                                      echo "No Cargado";
                                  break;

                                default:
                                  // code...
                                  break;
                              }

                             ?>
                          </td>

                          <td>
                            <a href="<?= '/xml/'.$row_xml_mp['xml_auditoria_ubicacion'] ?>" target="_blank"><img src="imagenes/iconos/lupa.png" type="image" width="16" title="Ver" name="boton" src="imagenes/iconos/xml.png" ></a>

                          </td>
                          <td>
                            <form class="" action="verxml.php" method="get">
                                <input type="image" name="boton" src="imagenes/iconos/xml.png" width="16" title="Descargar" value="">
                                <input type="hidden" name="ubicacion" value="<?= $row_xml_mp['xml_auditoria_ubicacion'] ?>">
                                <input type="hidden" name="nombre_archivo" value="<?php
                                  $variable=array();
                                  $variable=explode("/",$row_xml_mp['xml_auditoria_ubicacion']);
                                  echo $variable[4];
                                ?>">


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

                              if (isset($num_xml_mp) && ($num_xml_mp>0)) {
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

                         <form action="consulta_xml.php" method="post">

                           <input type="hidden" name="xml" value="<?= $_REQUEST['xml'] ?>">
                           <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                           <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>">
                           <input type="hidden" name="go_back" value="si">
                           <input type="hidden" name="posi" value="<?= $anterior ?>">
                           <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                           <input type="hidden" name="xml_auditoria_estado" value="<?= $_REQUEST['xml_auditoria_estado'] ?>">

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
                        <form action="consulta_xml.php" method="post">
                          <input type="hidden" name="go_back" value="si">
                          <input type="hidden" name="posi" value="<?= $proximo ?>">
                          <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                          <input type="hidden" name="xml" value="<?= $xml ?>">
                          <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                          <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>">
                          <input type="hidden" name="xml_auditoria_estado" value="<?= $_REQUEST['xml_auditoria_estado'] ?>">
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
