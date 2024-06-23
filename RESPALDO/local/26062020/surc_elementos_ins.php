<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');


if (isset($_REQUEST['btn_guardarelemento_ins']) and $_REQUEST['btn_guardarelemento_ins']=='Insertar') {

        $SURC_SumarioElemento_IdTipoEle=intval($_REQUEST['SURC_SumarioElemento_IdTipoEle']);
        $SURC_SumarioElemento_IdForma=intval($_REQUEST['SURC_SumarioElemento_IdForma']);
        $SURC_SumarioElemento_CantElem=intval($_REQUEST['SURC_SumarioElemento_CantElem']);
        $SURC_SumarioElemento_NroSerieE=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_SumarioElemento_NroSerieE']))));
        $SURC_SumarioElemento_Obs=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_SumarioElemento_Obs']))));
        $SURC_SumarioElemento_Sus='NO';
        $SURC_SumarioElemento_Sec='NO';
        //****BUSCO CANTIDAD ELEMENTOS DEL SUMARIO EN LA TABLA PARA SURC_SumarioElemento_Id**************************//

        $Elemento_Id = mysqli_query($conex_surc,"SELECT MAX(SURC_SumarioElemento_Id) as 'id' FROM surc.surc_sumarioelemento
        where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or
        die("Problema con la obtencion del id maximo del SURC_SumarioElemento_Id: ".mysqli_error($conex_surc));

        if ($row = mysqli_fetch_array($Elemento_Id)) {
                $id_elem = trim($row[0]);
                $SURC_SumarioElemento_Id=$id_elem+1;
        }
        //******************************************************************************//


        //******Busqueda de usuario para grabar en surc_sumario y colocar modificado********************//
        $usuario=mysqli_query($conexion,"SELECT * FROM segusuario.usuarios
                                            where usuario_id='$_SESSION[usuario_id]'") or
                                            die("Problemas con el select usuarios : ".mysqli_error($conexion));
        $row_usuario=mysqli_fetch_array($usuario);

        $SURC_Sumario_CargaUsuario=strtoupper($row_usuario['usuario_cuenta']);
        $SURC_Sumario_FechaSum=date('Y-m-d');
        $SURC_Sumario_HoraSum_sumar=date('H:i:s');
        $SURC_Sumario_HoraSum='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraSum_sumar + 3 hours"));
        //******************************************************************************************//

        //*********INSERCION DEL ELEMENTO************************************************************//
        mysqli_query($conex_surc,"SET NAMES 'utf8'");

        $insert_elemento="INSERT INTO surc.surc_sumarioelemento (
                SURC_Sumario_Id,SURC_SumarioElemento_Id,SURC_SumarioElemento_Sus,
                SURC_SumarioElemento_Sec,SURC_SumarioElemento_IdTipoEle,
                SURC_SumarioElemento_NroSerieE,SURC_SumarioElemento_CantElem,
                SURC_SumarioElemento_Obs,SURC_SumarioElemento_IdForma)
              VALUES (
                '$_SESSION[SURC_Sumario_Id]','$SURC_SumarioElemento_Id','$SURC_SumarioElemento_Sus',
                '$SURC_SumarioElemento_Sec',NULLIF('$SURC_SumarioElemento_IdTipoEle',''),
                NULLIF('$SURC_SumarioElemento_NroSerieE',''),NULLIF('$SURC_SumarioElemento_CantElem',''),
                NULLIF('$SURC_SumarioElemento_Obs',''),NULLIF('$SURC_SumarioElemento_IdForma',''))";

        //***********************************************************************************************//

        if (mysqli_query($conex_surc,$insert_elemento)) {
                //***********INSERCION DEL USUARIO Y LA MODIFICACION EN SURC SUMARIO************************//
                   mysqli_query($conex_surc, "UPDATE surc.surc_sumario SET

                          SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
                          SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
                          SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
                          Surc_Sumario_Modificado='M'

                          where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or
                          die("Problemas con el update sumario:".mysqli_error($conex_surc));
                  //***************************************************************************************//
                          if (!empty(mysqli_affected_rows($conex_surc))) {
                            header("Location: sum_d_upd.php?accion=ins&tab=3");

                          } else {
                            header("Location: sum_d_upd.php?accion=no_upd&tab=3");
                          }

        } else {
           header("Location: sum_d_upd.php?accion=no_ins&tab=3");
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

      <form class="" action="surc_elementos_ins.php" method="post">

        <div class="borde">

          <table class="plus conmargen">
            <tr>
              <td>Elemento</td>
              <td>
                <select type="text" class="select" name="SURC_SumarioElemento_IdTipoEle" required>
                  <option value="">Seleccionar</option>
                    <?php

                    $surc_tipoelemento=mysqli_query($conex_surc," SELECT * FROM surc.surc_tipoelemento;")
                                      or  die("Problemas con el select tipo elemento: ".mysqli_error($conex_surc));

                    $row_surc_tipoelemento=mysqli_fetch_array($surc_tipoelemento);
                                      do {?>
                                        <option value="<?php
                                            echo $row_surc_tipoelemento['SURC_TipoElemento_Id'];
                                        ?>" >
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
                <input type="text" name="SURC_SumarioElemento_NroSerieE" class="w18" style="text-transform:uppercase;" value="">
              </td>
            </tr>
            <tr>
              <td>Tipo de Elemento</td>
              <td>
                <select type="text" class="select" name="SURC_SumarioElemento_IdForma" required>
                  <option value="">Seleccionar</option>
                    <?php

                    $surc_formaelemento=mysqli_query($conex_surc," SELECT * FROM surc.surc_formaelemento;")
                                      or  die("Problemas con el select tipo forma elemento: ".mysqli_error($conex_surc));

                    $row_surc_formaelemento=mysqli_fetch_array($surc_formaelemento);
                                      do {?>
                                        <option value="<?php
                                            echo $row_surc_formaelemento['SURC_FormaElemento_Id'];
                                        ?>" >
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
                <input type="number" class="wchico" name="SURC_SumarioElemento_CantElem" value="1">
              </td>

            </tr>
            <tr>
              <td>Observaciones</td>
              <td>
                <textarea name="SURC_SumarioElemento_Obs" rows="8" cols="80" style="overflow-y:scroll;text-align:justify;text-transform:uppercase;"></textarea>
              </td>
            </tr>

          </table>

          <table>
            <tr>
              <td>
                <button type="submit" name="btn_guardarelemento_ins" value="Insertar" class="btnguardar"><span class="soloimagen">Insertar</span></button>

              </td>
              <td>
                <button type="submit" name="btn_cancelarelemento_ins" form="salir" value="Cancelar" class="btncancelar"><span class="soloimagen">Cancelar</span></button>

              </td>
            </table>

        </div>

      </form>


      <form class="" action="sum_d_upd.php" id="salir" method="post">
        <input type="hidden" name="tab" value="3">

      </form>



        </div>


    </article>


  </section>

  <div id="footer"><?php include ('footer.php');?></div>


</body>
</html>
