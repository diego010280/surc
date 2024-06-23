<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');

if (!empty($_REQUEST['SURC_SumarioElemento_Id'])) {
  $_SESSION['SURC_SumarioElemento_Id']=$_REQUEST['SURC_SumarioElemento_Id'];
}

if (isset($_REQUEST['btn_guardarelemento_upd']) and $_REQUEST['btn_guardarelemento_upd']=='Guardar Cambios') {

            mysqli_query($conex_surc,"SET NAMES 'utf8'");


            $SURC_SumarioElemento_IdTipoEle=(empty($_REQUEST['SURC_SumarioElemento_IdTipoEle'])) ? '' : intval($_REQUEST['SURC_SumarioElemento_IdTipoEle']);
            $SURC_SumarioElemento_IdForma=(empty($_REQUEST['SURC_SumarioElemento_IdForma'])) ? '' : intval($_REQUEST['SURC_SumarioElemento_IdForma']);
            $SURC_SumarioElemento_CantElem=(empty($_REQUEST['SURC_SumarioElemento_CantElem'])) ? '' : intval($_REQUEST['SURC_SumarioElemento_CantElem']);



          $SURC_SumarioElemento_NroSerieE=(empty($_REQUEST['SURC_SumarioElemento_NroSerieE'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_SumarioElemento_NroSerieE']));

          $SURC_SumarioElemento_Obs=(empty($_REQUEST['SURC_SumarioElemento_Obs'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_SumarioElemento_Obs']));

          $usuario=mysqli_query($conexion,"SELECT * FROM segusuario.usuarios
                                            where usuario_id='$_SESSION[usuario_id]'") or
                                            die("Problemas con el select usuarios : ".mysqli_error($conexion));
          $row_usuario=mysqli_fetch_array($usuario);

            $SURC_Sumario_CargaUsuario=strtoupper($row_usuario['usuario_cuenta']);
            $SURC_Sumario_FechaSum=date('Y-m-d');
            $SURC_Sumario_HoraSum_sumar=date('H:i:s');
            $SURC_Sumario_HoraSum='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraSum_sumar + 3 hours"));

            mysqli_query($conex_surc, "UPDATE surc.surc_sumarioelemento SET

               SURC_SumarioElemento_IdTipoEle='$SURC_SumarioElemento_IdTipoEle',
               SURC_SumarioElemento_IdForma='$SURC_SumarioElemento_IdForma',
               SURC_SumarioElemento_CantElem='$SURC_SumarioElemento_CantElem',
               SURC_SumarioElemento_NroSerieE='$SURC_SumarioElemento_NroSerieE',
               SURC_SumarioElemento_Obs='$SURC_SumarioElemento_Obs'

               where (SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]') and (SURC_SumarioElemento_Id='$_SESSION[SURC_SumarioElemento_Id]')") or
               die("Problemas con el update personas sumario:".mysqli_error($conex_surc));

               mysqli_query($conex_surc, "UPDATE surc.surc_sumario SET

                SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
                SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
                SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
                Surc_Sumario_Modificado='M'

                where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or
                die("Problemas con el update sumario:".mysqli_error($conex_surc));

               if (!empty(mysqli_affected_rows($conex_surc))) {
                 header("Location: sum_d_upd.php?accion=mod&tab=3");

               } else {
                 header("Location: sum_d_upd.php?accion=no_upd&tab=3");
               }

           } else {
             if (isset($_REQUEST['btn_cancelarelemento_upd']) and $_REQUEST['btn_cancelarelemento_upd']=='Cancelar'){
                       header("Location: sum_d_upd.php?tab=3");


             }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <link rel="stylesheet" type="text/css" href="css/alta.css?v=2.2">
	  <link rel="stylesheet" type="text/css" href="css/ventanas.css?v=1.02">
    <link rel="stylesheet" type="text/css" href="css/estilos-doc.css">

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
      <p>
        Datos Elementos Vinculadas con el Hecho
      </p>

      <?php

          $elementosum=mysqli_query($conex_surc,"SELECT * FROM surc.surc_sumarioelemento
           								where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]' and SURC_SumarioElemento_Id='$_SESSION[SURC_SumarioElemento_Id]'")
           or die("Problemas con la consulta elementos sumarios : ".mysqli_error($conex_surc));

           $row_elementosum = mysqli_fetch_array($elementosum);


      ?>

      <form class="" action="surc_elementos_upd.php" method="post">

        <div class="borde">

          <table class="plus conmargen">
            <tr>
              <td>Elemento</td>
              <td>
                <select type="text" class="select" name="SURC_SumarioElemento_IdTipoEle">
                  <option value="">Seleccionar</option>
                    <?php

                    $surc_tipoelemento=mysqli_query($conex_surc," SELECT * FROM surc.surc_tipoelemento;")
                                      or  die("Problemas con el select tipo elemento: ".mysqli_error($conex_surc));

                    $row_surc_tipoelemento=mysqli_fetch_array($surc_tipoelemento);
                                      do {?>
                                        <option value="<?php
                                            echo $row_surc_tipoelemento['SURC_TipoElemento_Id'];
                                        ?>" <?php if (isset($row_elementosum['SURC_SumarioElemento_IdTipoEle']) and
                                        $row_elementosum['SURC_SumarioElemento_IdTipoEle']==$row_surc_tipoelemento['SURC_TipoElemento_Id']) {
                                          echo 'selected';
                                        } ?>>
                                        <?php echo utf8_encode($row_surc_tipoelemento['SURC_TipoElemento_Descrip']); ?>
                                      </option>
                                    <?php } while ($row_surc_tipoelemento=mysqli_fetch_array($surc_tipoelemento));?>

                     ?>

                </select>
              </td>
            </tr>
            <tr>
              <td>Nro. de Serie</td>
              <td>
                <input type="text" name="SURC_SumarioElemento_NroSerieE" class="w18" style="text-transform:uppercase;" value="<?php $row_elementosum['SURC_SumarioElemento_NroSerieE'] ?>">
              </td>
            </tr>
            <tr>
              <td>Tipo de Elemento</td>
              <td>
                <select type="text" class="select" name="SURC_SumarioElemento_IdForma">
                  <option value="">Seleccionar</option>
                    <?php

                    $surc_formaelemento=mysqli_query($conex_surc," SELECT * FROM surc.surc_formaelemento;")
                                      or  die("Problemas con el select tipo forma elemento: ".mysqli_error($conex_surc));

                    $row_surc_formaelemento=mysqli_fetch_array($surc_formaelemento);
                                      do {?>
                                        <option value="<?php
                                            echo $row_surc_formaelemento['SURC_FormaElemento_Id'];
                                        ?>" <?php if (isset($row_elementosum['SURC_SumarioElemento_IdForma']) and
                                        $row_elementosum['SURC_SumarioElemento_IdForma']==$row_surc_formaelemento['SURC_FormaElemento_Id']) {
                                          echo 'selected';
                                        } ?>>
                                        <?php echo utf8_encode($row_surc_formaelemento['SURC_FormaElemento_Descrip']); ?>
                                      </option>
                                    <?php } while ($row_surc_formaelemento=mysqli_fetch_array($surc_formaelemento));?>

                     ?>

                </select>
              </td>
            </tr>
            <tr>
              <td>Cantidad</td>
              <td>
                <input type="number" class="wchico" name="SURC_SumarioElemento_CantElem" value="<?= $row_elementosum['SURC_SumarioElemento_CantElem'] ?>">
              </td>

            </tr>
            <tr>
              <td>Observaciones</td>
              <td>
                <textarea name="SURC_SumarioElemento_Obs" rows="8" cols="80" style="overflow-y:scroll;text-align:justify;"><?= utf8_encode($row_elementosum['SURC_SumarioElemento_Obs']) ?></textarea>
              </td>
            </tr>

          </table>

          <table>
            <tr>
              <td>
                <button type="submit" name="btn_guardarelemento_upd" value="Guardar Cambios" class="btnguardar"><span class="soloimagen">Guardar Cambios</span></button>

              </td>
              <td>
                <button type="submit" name="btn_cancelarelemento_upd" value="Cancelar" class="btncancelar"><span class="soloimagen">Cancelar</span></button>

              </td>
            </table>

        </div>

      </form>






        </div>


    </article>


  </section>

  <div id="footer"><?php include ('footer.php');?></div>


</body>
</html>
