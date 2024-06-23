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
        concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',segusuario.usuarios.usuario_dni as'documento',
        segusuario.usuarios.usuario_email as 'correo',count(auditoria_usuario_id) as 'cantidad',modulo_descrip FROM auditorias.auditoria

        inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
        inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId
        where auditoria_moduloId=15
        and auditoria_action_id in (3,4,5)
        and auditoria_descrip not like 'Modificacion existosa. '
        and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
        and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
        and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


        group by auditoria_usuario_id
        order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria analista : ".mysqli_error($conndb_audit));



      $num_analista= $analista->num_rows;

      // if (!isset($_REQUEST['go_back'])) {
      //             $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria
      //
      //             inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
      //             where auditoria_moduloId=15
      //             and auditoria_action_id in (3,4,5)
      //             and auditoria_descrip not like 'Modificacion existosa. '
      //             and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
      //             and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
      //             and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
      //
      //
      //             group by auditoria_usuario_id
      //             order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conndb_audit));
      //
      //             $num_total_reg = mysqli_fetch_array($total);
      //
      //             $total_registros = $num_total_reg['totalregistros'];
      //   }





    } else {
        // $usuario       = (empty($_REQUEST['usuario'])) ? '' : intval($_REQUEST['usuario']);
        $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
        $hastahecho = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'];
        $desdehecho_cons = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'].' 00:00:00';
        $hastahecho_cons = (empty($_REQUEST['hastahecho'])) ? null : $_REQUEST['hastahecho'].' 23:59:59';




        $analista=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
          concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',segusuario.usuarios.usuario_dni as 'documento',
          segusuario.usuarios.usuario_email as 'correo',count(auditoria_usuario_id) as 'cantidad',modulo_descrip FROM auditorias.auditoria

          inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
          inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

          where auditoria_moduloId=15
          and auditoria_action_id in (3,4,5)
          and auditoria_descrip not like 'Modificacion existosa. '
          and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
          and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
          and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


          group by auditoria_usuario_id
          order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria analista : ".mysqli_error($conndb_audit));



        $num_analista= $analista->num_rows;

        // if (!isset($_REQUEST['go_back'])) {
        //             $total=mysqli_query($conndb_audit,"SELECT count(*) as totalregistros  FROM auditorias.auditoria
        //
        //             inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
        //             where auditoria_moduloId=15
        //             and auditoria_action_id in (3,4,5)
        //             and auditoria_descrip not like 'Modificacion existosa. '
        //             and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
        //             and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
        //             and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
        //
        //
        //             group by auditoria_usuario_id
        //             order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conndb_audit));
        //
        //             $num_total_reg = mysqli_fetch_array($total);
        //
        //             $total_registros = $num_total_reg['totalregistros'];
        //   }

    }
}else {
  // $usuario       = (empty($_REQUEST['usuario'])) ? '' : intval($_REQUEST['usuario']);
  $desdehecho = date("Y-m-d");
  $hastahecho = date("Y-m-d");
  $desdehecho_cons = $desdehecho.' 00:00:00';
  $hastahecho_cons = $hastahecho.' 23:59:59';


  $analista=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
    concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',segusuario.usuarios.usuario_dni as'documento',
    segusuario.usuarios.usuario_email as 'correo',count(auditoria_usuario_id) as 'cantidad',modulo_descrip FROM auditorias.auditoria

    inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
    inner join segusuario.modulos on segusuario.modulos.modulo_id=auditorias.auditoria.auditoria_moduloId

    where auditoria_moduloId=15
    and auditoria_action_id in (3,4,5)
    and auditoria_descrip not like 'Modificacion existosa. '
    and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
    and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
    and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')


    group by auditoria_usuario_id
    order by count(auditoria_usuario_id) desc") or die("Problemas con la consulta auditoria analista : ".mysqli_error($conndb_audit));



  $num_analista= $analista->num_rows;


  // if (!isset($_REQUEST['go_back'])) {
  //             $total=mysqli_query($conndb_audit,"SELECT auditoria_usuario_id, segusuario.usuarios.usuario_cuenta as 'cuenta',
  //               concat(segusuario.usuarios.usuario_apellido,', ',segusuario.usuarios.usuario_nombre) as 'usuario',
  //               count(auditoria_usuario_id) as 'cantidad' FROM auditorias.auditoria
  //
  //               inner join segusuario.usuarios on segusuario.usuarios.usuario_id=auditorias.auditoria.auditoria_usuario_id
  //               where auditoria_moduloId=15
  //               and auditoria_action_id in (3,4,5)
  //               and auditoria_descrip not like 'Modificacion existosa. '
  //               and auditoria_descrip not like 'Modificacion existosa.Surc_sumario M %'
  //               and (auditoria_fech>='$desdehecho_cons' or '$desdehecho_cons'='')
  //               and (auditoria_fech<='$hastahecho_cons' or '$hastahecho_cons'='')
  //
  //
  //               group by auditoria_usuario_id
  //               order by count(auditoria_usuario_id) desc
  //
  //             ") or die("Problemas con la consulta auditoria xml : ".mysqli_error($conndb_audit));
  //
  //             $num_total_reg = mysqli_fetch_array($total);
  //
  //             $total_registros= $total->num_rows;
  //             // $total_registros = $num_total_reg['totalregistros'];
  //             // echo $total_registros.'<br>';
  //   }

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
            <form  action="consulta_analista.php" method="post" autocomplete="off">

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
            <form action="consulta_analista.php" method="post" id="limpiar"></form>

          </div>

        </div>
      </section>

      <section id='grilla'>
        <table id="tabla_abm">
              <thead>
                <tr>
                  <th width="5%">Nro. Orden</th>
                  <th>Foto</th>
                  <th width="8%">Usuario</th>
                  <th width="20%">Nombre y Apellido</th>
                  <th width="10%">DNI</th>
                  <th width="10%">Modulo Analizado</th>
                  <th width="20%">Correo Electronico</th>
                  <th with="10%">Cantidad Correcciones</th>
                  <th colspan="3"></th>
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
                          <td align="center"><?php echo $impresos; ?></td>
                          <td width="8%" valign="middle" align="center">

                            <?php
                                $legajo="SELECT RRHH_DatosPers_Legajo as 'legajo' FROM rrhh.view_datospers
                                          where RRHH_DatosPers_NroDoc='$row_analista[documento]' and RRHH_DatosPers_activo=1";
                                if ($rrhh_legajo=mysqli_query($connrrhh,$legajo)) {
                                      $num_rrhh_legajo=$rrhh_legajo->num_rows;
                                      $row_rrhh_legajo=mysqli_fetch_array($rrhh_legajo);

                                      if ($num_rrhh_legajo>0) {
                                            include ('buscar_ruta_foto.php');


                                      }
                                }else {
                                  $errormysql="Error: La ejecución de busqueda legajo para foto debido a:".mysqli_error($connrrhh);
                                  echo $errormysql.'<br>';
                                }

                                if (!empty($ruta_foto)) {?>

                                    <img src="<?php echo $ruta_foto; ?>" width="60" height="60"/>
                                <?php } ?>






                          </td>
                          <td align="LEFT"><?php echo strtoupper($row_analista['cuenta']); ?></td>
                          <td align="LEFT"><?php echo utf8_encode($row_analista['usuario']); ?></td>
                          <td align="center"><?= $row_analista['documento'] ?></td>
                          <td align="left"><?= $row_analista['modulo_descrip'] ?></td>
                          <td align="left"><?= $row_analista['correo'] ?></td>
                          <td align="center"><?= $row_analista['cantidad'] ?></td>

                          <td>
                                <form action="consulta_x_analista.php" method="post">

                                    <input type="image" name="boton" src="imagenes/iconos/lupa.png" width="16" title="Ver" value="">

                                    <input type="hidden" name="desdehecho" value="<?= $desdehecho ?>">
                                    <input type="hidden" name="hastahecho" value="<?= $hastahecho ?>">
                                    <input type="hidden" name="usuario" value="<?= $row_analista['auditoria_usuario_id'] ?>">
                                    <input type="hidden" name="go_back" value="si">


                                </form>
                          </td>
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
