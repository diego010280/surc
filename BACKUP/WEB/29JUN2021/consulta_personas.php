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
    if (empty($_REQUEST['palabra_clave_pers']) and empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho'])) {
      //mostrar mensaje agregar un valor
    } else {
        $palabra_clave_pers   = (empty($_REQUEST['palabra_clave_pers'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['palabra_clave_pers']));
        $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
        $hastahecho = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'];

        $personas=mysqli_query($conex_surc,"SELECT * FROM surc.personasumario
        								where (concat_ws(' ',Documento,ApellidoyNombre,Alias,Telefono) LIKE '%$palabra_clave_pers%' or '$palabra_clave_pers'='')
                        AND (surc.personasumario.Fecha_delito>='$desdehecho' or '$desdehecho'='')
                        AND (surc.personasumario.Fecha_delito<= '$hastahecho' or '$hastahecho'='')
                        ORDER BY Anio DESC,Fecha_delito DESC
                        LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta personas : ".mysqli_error($conex_surc));

        $num_row_personas= $personas->num_rows;

        if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conex_surc,"SELECT count(*) as totalregistros  FROM surc.personasumario
                    								where (concat_ws(' ',Documento,ApellidoyNombre,Alias,Telefono) LIKE '%$palabra_clave_pers%' or '$palabra_clave_pers'='')
                                    AND (surc.personasumario.Fecha_delito>='$desdehecho' or '$desdehecho'='')
                                    AND (surc.personasumario.Fecha_delito<= '$hastahecho' or '$hastahecho'='')
                                    LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta personas : ".mysqli_error($conex_surc));

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
            <form  action="consulta_personas.php" method="post" autocomplete="off">

              <table class="plus conmargen">
                <thead>
                  <tr>
                    <td>Palabra Clave (Busca campos Ape. y Nomb.-DNI-Alias- Telf.) </td>
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
                        <input type="text" class="w21" name="palabra_clave_pers" value="<?php if (isset($_REQUEST['palabra_clave_pers'])) {
                          echo $_REQUEST['palabra_clave_pers'];
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

                      <td>&nbsp; &nbsp;</td>

                      <td>
                        <div>
                          <button type="submit" class="btncel" name="excel_pers" value="excel_pers" formaction="excel_pers_cons.php" name="button"><span class="soloimagen">Excel</span></button>
                          <!-- <button type="submit" class="btncel" form="excel"><span class="soloimagen">Excel</span>
                          </button> -->

                        </div>
                      </td>

                    </tr>
                </tbody>

                </table>
                <br>

            </form>
            <form action="consulta_personas.php" method="post" id="limpiar"></form>
            <form action="excel_pers_cons.php" method="get" id="excel"></form>

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
                  <th>Grupo Delictivo</th>
                  <th>Tipo Persona</th>
                  <th>Clase Persona</th>
                  <th>Vinculo</th>
                  <th>Documento</th>
                  <th>Apellido y Nombre</th>
                  <th>Sexo</th>
                  <th>Fecha Nac.</th>
                  <th>Edad</th>
                  <th>Alias</th>
                  <th>Teléfono</th>
                  <th>Estado Civil</th>
                  <th colspan="2"></th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $impresos=0;
                  if (!empty($num_row_personas)) {
                      mysqli_data_seek($personas,0);

                      while ($row_personas = mysqli_fetch_array($personas)) {
                      ++$impresos;?>
                        <tr>
                          <td align="right"><?= $impresos ?></td>
                          <td align="right"><?= utf8_encode($row_personas['NroSumario_MP']) ?></td>
                          <td align="center"><?= utf8_encode($row_personas['Anio']) ?></td>
                          <td><?= utf8_encode($row_personas['Dependencia']) ?></td>
                          <td align="center"><?= date("d-m-Y",strtotime($row_personas['Fecha_delito'])) ?></td>
                          <td><?= utf8_encode($row_personas['Agrupamiento_Delictivo']) ?></td>
                          <td><?= utf8_encode($row_personas['Tipo_Persona']) ?></td>
                          <td><?= utf8_encode($row_personas['Clase_Persona']) ?></td>
                          <td><?= utf8_encode($row_personas['Vinculo_Persona']) ?></td>
                          <td><?= utf8_encode($row_personas['Documento']) ?></td>
                          <td><?= utf8_encode($row_personas['ApellidoyNombre']) ?></td>
                          <td align="center"><?= utf8_encode($row_personas['Sexo']) ?></td>
                          <td align="center"> <?php if (!is_null($row_personas['Fecha_Nac'])) {
                             date("d-m-Y",strtotime($row_personas['Fecha_Nac']));
                              }?> </td>
                          <td align="center"><?php if (!is_null($row_personas['Edad'])) {
                            $row_personas['Edad'];
                          } ?></td>
                          <td align="center"><?= utf8_encode($row_personas['Alias']) ?></td>
                          <td><?= $row_personas['Telefono'] ?></td>
                          <td><?= utf8_encode($row_personas['Est_Civil']) ?></td>
                          <td>
                            <form action="sum_d_personas.php" method="post">
                                    <input type="image" name="boton" src="imagenes/iconos/lupa.png" width="16" title="Ver" value="">
                                    <input type="hidden" name="SURC_Sumario_Id" value="<?= $row_personas['SURC_Sumario_Id'] ?>">
                                    <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                                    <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
                                    <input type="hidden" name="go_back" value="si">
                                    <input type="hidden" name="posi" value="<?= $anterior ?>">
                                    <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                                    <input type="hidden" name="palabra_clave_pers" value="<?= $palabra_clave_pers ?>">
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

                              if (isset($num_row_personas) && ($num_row_personas>0)) {
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

                           <input type="hidden" name="palabra_clave_pers" value="<?= $_REQUEST['palabra_clave_pers'] ?>">
                           <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                           <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
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
                        <form action="consulta_personas.php" method="post">
                          <input type="hidden" name="go_back" value="si">
                          <input type="hidden" name="posi" value="<?= $proximo ?>">
                          <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                          <input type="hidden" name="palabra_clave_pers" value="<?= $palabra_clave_pers ?>">
                          <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                          <input type="hidden" name="hastahecho" value="<?= $_REQUEST['hastahecho'] ?>">
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
