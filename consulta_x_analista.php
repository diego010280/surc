<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/conndb_auditoria.php');
require_once ('connections/connrrhh.php');

date_default_timezone_set('America/Argentina/Salta');

$tamano_pagina=20;

$_SESSION['desdehecho']=$_REQUEST['desdehecho'];

$_SESSION['hastahecho'] = $_REQUEST['hastahecho'];

$_SESSION['usuario']=$_REQUEST['usuario'];
$_SESSION['go_back']=$_REQUEST['go_back'];


// echo $_SESSION['usuario'].'<br>';

if (isset($_REQUEST['posi'])) {
  $inicio= $_REQUEST['posi'];
  $anterior=$_REQUEST['posi'];
}else {
  $inicio=0;
  $anterior=0;
}

// echo $inicio.'<br>';
// echo $anterior.'<br>';
if (isset($_REQUEST['total_registros'])) {
  $total_registros=$_REQUEST['total_registros'];

}
// echo $total_registros.'<br>';

if (isset($_REQUEST['go_back'])) {
  // echo "ingreso buscador";
    if (empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho'])) {
      $desdehecho = null;
      $hastahecho = null;
      $desdehecho_cons = null;
      $hastahecho_cons = null;

        $registros=mysqli_query($conndb_audit,"SELECT auditoria_fech,auditoria_usuario_id,concat(segusuario.usuarios.usuario_apellido,', ',
                  segusuario.usuarios.usuario_nombre) as 'apellidoynombre',auditoria_moduloId,modulo_descrip,auditoria_action_id,action_desc,
                  auditoria_descrip FROM auditorias.auditoria

                  inner join auditorias.actions on auditorias.actions.action_id=auditorias.auditoria.auditoria_action_id
                  inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                  inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

                  where auditoria_usuario_id='$_SESSION[usuario]'
                  and auditoria_moduloId=15
                  and auditoria_action_id in (3,4,5)
                  and auditoria_descrip not like 'Modificacion existosa. '
                  and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                  and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                  and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
                  LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta registros del analista : ".mysqli_error($conndb_audit));

                  $num_registros= $registros->num_rows;

        // if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria

                    inner join auditorias.actions on auditorias.actions.action_id=auditorias.auditoria.auditoria_action_id
                    inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                    inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

                    where auditoria_usuario_id='$_SESSION[usuario]'
                    and auditoria_moduloId=15
                    and auditoria_action_id in (3,4,5)
                    and auditoria_descrip not like 'Modificacion existosa. '
                    and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                    and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                    and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
                    LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta personas : ".mysqli_error($conndb_audit));

                    $num_total_reg = mysqli_fetch_array($total);

                    $total_registros = $num_total_reg['totalregistros'];
          // }
    } else {

      $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
      $hastahecho = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'];
      $desdehecho_cons = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'].' 00:00:00';
      $hastahecho_cons = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'].' 23:59:59';

        $registros=mysqli_query($conndb_audit,"SELECT auditoria_fech,auditoria_usuario_id,concat(segusuario.usuarios.usuario_apellido,', ',
                  segusuario.usuarios.usuario_nombre) as 'apellidoynombre',auditoria_moduloId,modulo_descrip,auditoria_action_id,action_desc,
                  auditoria_descrip FROM auditorias.auditoria

                  inner join auditorias.actions on auditorias.actions.action_id=auditorias.auditoria.auditoria_action_id
                  inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                  inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

                  where auditoria_usuario_id='$_SESSION[usuario]'
                  and auditoria_moduloId=15
                  and auditoria_action_id in (3,4,5)
                  and auditoria_descrip not like 'Modificacion existosa. '
                  and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                  and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                  and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
                  LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta registros del analista : ".mysqli_error($conndb_audit));

                  $num_registros= $registros->num_rows;

        // if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria

                    inner join auditorias.actions on auditorias.actions.action_id=auditorias.auditoria.auditoria_action_id
                    inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                    inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

                    where auditoria_usuario_id='$_SESSION[usuario]'
                    and auditoria_moduloId=15
                    and auditoria_action_id in (3,4,5)
                    and auditoria_descrip not like 'Modificacion existosa. '
                    and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                    and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                    and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
                    LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta personas : ".mysqli_error($conndb_audit));

                    $num_total_reg = mysqli_fetch_array($total);

                		$total_registros = $num_total_reg['totalregistros'];
          // }

    }
}else {

    // echo "no ingreso buscador";

    $desdehecho = null;
  $hastahecho = null;
  $desdehecho_cons = null;
  $hastahecho_cons = null;

    $registros=mysqli_query($conndb_audit,"SELECT auditoria_fech,auditoria_usuario_id,concat(segusuario.usuarios.usuario_apellido,', ',
              segusuario.usuarios.usuario_nombre) as 'apellidoynombre',auditoria_moduloId,modulo_descrip,auditoria_action_id,action_desc,
              auditoria_descrip FROM auditorias.auditoria

              inner join auditorias.actions on auditorias.actions.action_id=auditorias.auditoria.auditoria_action_id
              inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
              inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

              where auditoria_usuario_id='$_SESSION[usuario]'
              and auditoria_moduloId=15
              and auditoria_action_id in (3,4,5)
              and auditoria_descrip not like 'Modificacion existosa. '
              and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
              and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
              and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
              LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta registros del analista : ".mysqli_error($conndb_audit));

              $num_registros= $registros->num_rows;

    // if (!isset($_REQUEST['go_back'])) {
                $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria

                inner join auditorias.actions on auditorias.actions.action_id=auditorias.auditoria.auditoria_action_id
                inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

                where auditoria_usuario_id='$_SESSION[usuario]'
                and auditoria_moduloId=15
                and auditoria_action_id in (3,4,5)
                and auditoria_descrip not like 'Modificacion existosa. '
                and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
                LIMIT $inicio, $tamano_pagina") or die("Problemas con la consulta personas : ".mysqli_error($conndb_audit));

                $num_total_reg = mysqli_fetch_array($total);

                $total_registros = $num_total_reg['totalregistros'];
      // }
}





?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <?php include 'head.php' ?>
  <title>Registros Analista</title>
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
        <h1>Consulta Registros del Analista</h1>
        <br>
        <div class="pos_buscar">
          <form action="consulta_analista.php" method="post">

            <input type="hidden" name="desdehecho" value="<?php echo $_SESSION['desdehecho']; ?>">
            <input type="hidden" name="hastahecho" value="<?php echo $_SESSION['hastahecho']; ?>">
            <input type="hidden" name="go_back" value="<?php echo $_SESSION['go_back']; ?>">


              <button type="submit"  class="btnGyC" >VOLVER A LA CONSULTA RANKING</button>

          </form>

        </div>

        <div id="find">
          <div id="cpanel1">
            <form  action="consulta_x_analista.php" method="post" autocomplete="off">
              <input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">

              <table class="plus conmargen">
                <thead>
                  <tr>
                    <td>Fecha Desde</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Fecha Hasta</td>
                    <td>&nbsp; &nbsp;</td>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <input type="date" name="desdehecho" style="width:132px" value="<?php if (isset($_REQUEST['desdehecho'])) {
                          echo $_REQUEST['desdehecho'];
                        }else {
                          echo "";
                        } ?>" readonly>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>
                        <input type="date" name="hastahecho" style="width:132px" value="<?php if (isset($_REQUEST['hastahecho'])) {
                          echo $_REQUEST['hastahecho'];
                        }else {
                          echo "";
                        } ?>" readonly>
                      </td>
                      <!-- <td>&nbsp; &nbsp;</td>
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
                      </td> -->

                    </tr>
                </tbody>

                </table>
                <br>





            </form>

            <!-- <form action="consulta_x_analista.php" method="post" id="limpiar">
                <input type="hidden" name="usuario" value="<?php //echo $_SESSION['usuario']; ?>">
            </form> -->

          </div>

        </div>

      </section>

      <section id='grilla'>
        <table id="tabla_abm">
              <thead>
                <tr>
                  <th width="5%">N°</th>
                  <th width="15%">Nombre y Apellido</th>
                  <th width="5%">Acción Realizada</th>
                  <th width="10%">Fecha de Acción</th>
                  <th width="50%">Descripción Acción</th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $impresos=0;
                  if (!empty($num_registros)) {
                      mysqli_data_seek($registros,0);

                      while ($row_registros = mysqli_fetch_array($registros)) {
                      ++$impresos;?>
                        <tr>
                          <td align="center"><?= $impresos ?></td>
                          <td align="left"><?= utf8_encode($row_registros['apellidoynombre']) ?></td>
                          <td align="left"><?= utf8_encode($row_registros['action_desc']) ?></td>
                          <td align="center"><?= $row_registros['auditoria_fech'] ?></td>
                          <td><?= utf8_encode($row_registros['auditoria_descrip']) ?></td>

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

                              if (isset($num_registros) && ($num_registros>0)) {
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

                         <form action="consulta_x_analista.php" method="post">

                           <input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">
                           <!-- <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                           <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>"> -->
                           <input type="hidden" name="go_back" value="si">
                           <input type="hidden" name="posi" value="<?= $anterior ?>">
                           <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                           <input type="image" src="imagenes/iconos/anterior-osc.png" title="Página anterior">
                            <input type="hidden" name="desdehecho" value="<?php echo $_SESSION['desdehecho']; ?>">
                            <input type="hidden" name="hastahecho" value="<?php echo $_SESSION['hastahecho']; ?>">


                         </form>

                         <?php } ?>


                      </td>
                      <td>&nbsp;</td>
                      <td align="right">
                        <?php
                            if ($impresos == $tamano_pagina) {
                              $proximo = $inicio + $tamano_pagina;

                        ?>
                        <form action="consulta_x_analista.php" method="post">
                          <input type="hidden" name="go_back" value="si">
                          <input type="hidden" name="posi" value="<?= $proximo ?>">
                          <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                          <!-- <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                          <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>"> -->
                        	<input type="image" src="imagenes/iconos/siguiente-osc.png" title="Página siguiente">
                          <input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">
                          <input type="hidden" name="desdehecho" value="<?php echo $_SESSION['desdehecho']; ?>">
                          <input type="hidden" name="hastahecho" value="<?php echo $_SESSION['hastahecho']; ?>">
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
