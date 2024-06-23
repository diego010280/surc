<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/conndb_auditoria.php');

date_default_timezone_set('America/Argentina/Salta');

// $tamano_pagina=45;



// if (isset($_REQUEST['posi'])) {
//   $inicio= $_REQUEST['posi'];
//   $anterior=$_REQUEST['posi'];
// }else {
//   $inicio=0;
//   $anterior=0;
// }
//
// if (isset($_REQUEST['total_registros'])){
//   $total_registros=$_REQUEST['total_registros'];
//
// }
//
//
if (isset($_REQUEST['buscador']) or isset($_REQUEST['go_back'])) {
    if (empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho'])) {

      // $usuario       = (empty($_REQUEST['usuario'])) ? '' : intval($_REQUEST['usuario']);
      $desdehecho = null;
      $hastahecho = null;
      $desdehecho_cons = null;
      $hastahecho_cons = null;


      $analista=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
        concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',
        count(auditoria_usuario_id) as 'cantidad' FROM auditorias.auditoria

        inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
        where auditoria_moduloId=15
        and auditoria_action_id in (3,4,5)
        and auditoria_descrip not like 'Modificacion existosa. '
        and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
        and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
        and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


        group by auditoria_usuario_id
        order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria analista : ".mysqli_error($conndb_audit));



      $num_analista= $analista->num_rows;

      if (!isset($_REQUEST['go_back'])) {
                  $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria

                  inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                  where auditoria_moduloId=15
                  and auditoria_action_id in (3,4,5)
                  and auditoria_descrip not like 'Modificacion existosa. '
                  and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                  and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                  and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


                  group by auditoria_usuario_id
                  order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conndb_audit));

                  $num_total_reg = mysqli_fetch_array($total);

                  $total_registros = $num_total_reg['totalregistros'];
        }





    } else {
        // $usuario       = (empty($_REQUEST['usuario'])) ? '' : intval($_REQUEST['usuario']);
        $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
        $hastahecho = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'];
        $desdehecho_cons = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'].' 00:00:00';
        $hastahecho_cons = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'].' 23:59:59';




        $analista=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
          concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',
          count(auditoria_usuario_id) as 'cantidad' FROM auditorias.auditoria

          inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
          where auditoria_moduloId=15
          and auditoria_action_id in (3,4,5)
          and auditoria_descrip not like 'Modificacion existosa. '
          and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
          and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
          and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


          group by auditoria_usuario_id
          order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria analista : ".mysqli_error($conndb_audit));



        $num_analista= $analista->num_rows;

        if (!isset($_REQUEST['go_back'])) {
                    $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria

                    inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                    where auditoria_moduloId=15
                    and auditoria_action_id in (3,4,5)
                    and auditoria_descrip not like 'Modificacion existosa. '
                    and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                    and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                    and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


                    group by auditoria_usuario_id
                    order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conndb_audit));

                    $num_total_reg = mysqli_fetch_array($total);

                    $total_registros = $num_total_reg['totalregistros'];
          }

    }
}else {
  // $usuario       = (empty($_REQUEST['usuario'])) ? '' : intval($_REQUEST['usuario']);
  $desdehecho = null;
  $hastahecho = null;
  $desdehecho_cons = null;
  $hastahecho_cons = null;


  $analista=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
    concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',
    count(auditoria_usuario_id) as 'cantidad' FROM auditorias.auditoria

    inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
    where auditoria_moduloId=15
    and auditoria_action_id in (3,4,5)
    and auditoria_descrip not like 'Modificacion existosa. '
    and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
    and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
    and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


    group by auditoria_usuario_id
    order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria analista : ".mysqli_error($conndb_audit));



  $num_analista= $analista->num_rows;


  if (!isset($_REQUEST['go_back'])) {
              $total=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
                concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',
                count(auditoria_usuario_id) as 'cantidad' FROM auditorias.auditoria

                inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
                where auditoria_moduloId=15
                and auditoria_action_id in (3,4,5)
                and auditoria_descrip not like 'Modificacion existosa. '
                and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
                and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
                and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


                group by auditoria_usuario_id
                order by count(auditoria_usuario_id) desc

              ") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conndb_audit));

              $num_total_reg = mysqli_fetch_array($total);

              $total_registros= $total->num_rows;
              // $total_registros = $num_total_reg['totalregistros'];
              // echo $total_registros.'<br>';
    }

}






?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <?php include 'head.php' ?>
  <title>Consulta Analistas</title>
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
        <h1>Ranking de Correcciones de Denuncias MP de los Analistas</h1>
        <br>

        <div id="find">
          <div id="cpanel1">
            <form  action="consulta_analista.php" method="get" autocomplete="off">

              <table class="plus conmargen">
                <thead>
                  <tr>
                    <td>Fecha Desde</td>
                    <td>&nbsp; &nbsp;</td>
                    <td>Fecha Hasta</td>

                  </tr>
                </thead>
                <tbody>
                    <tr>
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
            <form action="consulta_analista.php" method="get" id="limpiar"></form>

          </div>

        </div>
      </section>

      <section id='grilla'>
        <table id="tabla_abm">
              <thead>
                <tr>
                  <th>Nro. Orden</th>
                  <th></th>
                  <th>Usuario</th>
                  <th>Nombre y Apellido</th>
                  <th>Cantidad Correcciones</th>
                  <th colspan="2"></th>
                </tr>
              </thead>
              <tbody>

                <?php
                  $impresos=0;
                  if (!empty($num_analista)) {
                      mysqli_data_seek($analista,0);
                      while ($row_analista = mysqli_fetch_array($analista)) {
                        $impresos++;?>

                        <tr>
                          <td align="right"><?php echo $impresos; ?></td>
                          <td align="right"><?php echo strtoupper($row_analista['cuenta']); ?></td>
                          <td align="right"><?php echo utf8_encode($row_analista['usuario']); ?></td>
                          <td align="right"><?= $row_analista['cantidad'] ?></td>
                        </tr>



                    </tbody>
                    <?php }
                  }else {?>
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
                <?php  } ?>



              <!-- paginación -->
              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px; margin-bottom:-10px; font-family: 'Roboto', sans-serif;font-size:0.813rem">
                    <tr>
                      <td align="right" width="92%" valign="middle">
                        <?php
                              if (isset($_REQUEST['total_registros'])) {
                                $total_registros= $_REQUEST['total_registros'];
                              }

                              if (isset($num_analista) && ($num_analista>0)) {
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

                         <form action="consulta_analista.php" method="get">

                           <input type="hidden" name="usuario" value="<?= $_REQUEST['usuario'] ?>">
                           <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                           <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>">
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
                        <form action="consulta_analista.php" method="get">
                          <input type="hidden" name="go_back" value="si">
                          <input type="hidden" name="posi" value="<?= $proximo ?>">
                          <input type="hidden" name="total_registros" value="<?= $total_registros ?>">
                          <input type="hidden" name="usuario" value="<?= $usuario ?>">
                          <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                          <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>">

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
