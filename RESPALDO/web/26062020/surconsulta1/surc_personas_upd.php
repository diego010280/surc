<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');

if (!empty($_REQUEST['SURC_PersonaSumario_IdPersona'])) {
  $_SESSION['SURC_PersonaSumario_IdPersona']=$_REQUEST['SURC_PersonaSumario_IdPersona'];
}

if (isset($_REQUEST['btn_guardarpersona_upd']) and $_REQUEST['btn_guardarpersona_upd']=='Guardar Cambios') {

            mysqli_query($conex_surc,"SET NAMES 'utf8'");

            // $SURC_PersonaSumario_IdTipoPers=(empty($_REQUEST['SURC_PersonaSumario_IdTipoPers'])) ? '' : intval($_REQUEST['SURC_PersonaSumario_IdTipoPers']);
            $SURC_PersonaSumario_IdTipoPers=intval($_REQUEST['SURC_PersonaSumario_IdTipoPers']);
            $SURC_PersonaSumario_IdClasePer=(empty($_REQUEST['SURC_PersonaSumario_IdClasePer'])) ? '' : intval($_REQUEST['SURC_PersonaSumario_IdClasePer']);
            $SURC_PersonaSumario_IdVinculo=(empty($_REQUEST['SURC_PersonaSumario_IdVinculo'])) ? '' : intval($_REQUEST['SURC_PersonaSumario_IdVinculo']);


           if (!empty($_REQUEST['SURC_PersonaSumario_EsMenor']) and ($_REQUEST['SURC_PersonaSumario_EsMenor']=='esmenor')) {
           $SURC_PersonaSumario_EsMenor='S';
          } else {
           $SURC_PersonaSumario_EsMenor='N';
          }


          $SURC_PersonaSumario_Obs=(empty($_REQUEST['SURC_PersonaSumario_Obs'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_PersonaSumario_Obs']));


          $usuario=mysqli_query($conexion,"SELECT * FROM segusuario.usuarios
                                            where usuario_id='$_SESSION[usuario_id]'") or
                                            die("Problemas con el select usuarios : ".mysqli_error($conexion));
          $row_usuario=mysqli_fetch_array($usuario);

            $SURC_Sumario_CargaUsuario=strtoupper($row_usuario['usuario_cuenta']);
            $SURC_Sumario_FechaSum=date('Y-m-d');
            $SURC_Sumario_HoraSum_sumar=date('H:i:s');
            $SURC_Sumario_HoraSum='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraSum_sumar + 3 hours"));

            mysqli_query($conex_surc, "UPDATE surc.surc_sumariopersona SET

               SURC_PersonaSumario_IdTipoPers='$SURC_PersonaSumario_IdTipoPers',
               SURC_PersonaSumario_IdClasePer='$SURC_PersonaSumario_IdClasePer',
               SURC_PersonaSumario_IdVinculo='$SURC_PersonaSumario_IdVinculo',
               SURC_PersonaSumario_EsMenor='$SURC_PersonaSumario_EsMenor',
               SURC_PersonaSumario_Obs='$SURC_PersonaSumario_Obs'

               where (SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]') and (SURC_PersonaSumario_IdPersona='$_SESSION[SURC_PersonaSumario_IdPersona]')") or
               die("Problemas con el update personas sumario:".mysqli_error($conex_surc));

               mysqli_query($conex_surc, "UPDATE surc.surc_sumario SET

                SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
                SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
                SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
                Surc_Sumario_Modificado='M'

                where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or
                die("Problemas con el update sumario:".mysqli_error($conex_surc));

               if (!empty(mysqli_affected_rows($conex_surc))) {
                 header("Location: sum_d_upd.php?accion=mod&tab=2");

               } else {
                 header("Location: sum_d_upd.php?accion=no_upd");
               }

           } else {
             if (isset($_REQUEST['btn_cancelarpersona_upd']) and $_REQUEST['btn_cancelarpersona_upd']=='Cancelar'){
                       header("Location: sum_d_upd.php?tab=2");


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
        Datos Personas Vinculadas con el Hecho
      </p>

      <?php

          $personasum=mysqli_query($conex_surc,"SELECT * FROM surc.surc_sumariopersona
           								where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]' and SURC_PersonaSumario_IdPersona='$_SESSION[SURC_PersonaSumario_IdPersona]'")
           or die("Problemas con la consulta personas sumarios : ".mysqli_error($conex_surc));

           $row_personasum = mysqli_fetch_array($personasum);


      ?>


      <form class="" action="surc_personas_upd.php" method="post">
        <div class="borde">
          <table class="plus conmargen">
            <tr>
                <td>
                  Apellido y Nombre
                </td>
                <td>
                  <?php

                  $persona=mysqli_query($conex_surc,"SELECT * FROM surc.surc_persona
                                  where SURC_Persona_Id='$_SESSION[SURC_PersonaSumario_IdPersona]'")
                   or die("Problemas con la consulta personas sumarios : ".mysqli_error($conex_surc));

                  $row_persona = mysqli_fetch_array($persona);

                   ?>
                  <input type="text" name="" class="w18" value="<?= $row_persona['SURC_Persona_ApellidoNombre'] ?>" readonly>
                </td>
            </tr>
            <tr>
                <td>Tipo de Persona</td>
                <td>
                  <select type="text" class="select" name="SURC_PersonaSumario_IdTipoPers" >
                  <option value="">Seleccionar</option>
                  <?php

                          $surc_tipopersona=mysqli_query($conex_surc," SELECT * FROM surc.surc_tipopersona;")
                                            or  die("Problemas con el select tipo persona: ".mysqli_error($conex_surc));

                          $row_surc_tipopersona=mysqli_fetch_array($surc_tipopersona);
                                            do {?>
                                              <option value="<?php
                                                  echo $row_surc_tipopersona['SURC_TipoPersona_Id'];
                                              ?>" <?php if (isset($row_personasum['SURC_PersonaSumario_IdTipoPers']) and
                                              $row_personasum['SURC_PersonaSumario_IdTipoPers']==$row_surc_tipopersona['SURC_TipoPersona_Id']) {
                                                echo 'selected';
                                              } ?>>
                                              <?php echo utf8_encode($row_surc_tipopersona['SURC_TipoPersona_Descrip']); ?>
                                            </option>
                                            <?php } while ($row_surc_tipopersona=mysqli_fetch_array($surc_tipopersona));?>




                  </select>
                </td>
              </tr>
              <tr>
                <td>Clase de Persona</td>
                <td>
                  <select type="text" class="select" name="SURC_PersonaSumario_IdClasePer" >
                  <option value="">Seleccionar</option>
                  <?php

                          $surc_clasepersona=mysqli_query($conex_surc," SELECT * FROM surc.surc_clasepersona;")
                                            or  die("Problemas con el select clase persona: ".mysqli_error($conex_surc));

                          $row_surc_clasepersona=mysqli_fetch_array($surc_clasepersona);
                                            do {?>
                                              <option value="<?php
                                                echo   $row_surc_clasepersona['SURC_ClasePersona_Id'];
                                              ?>" <?php if (isset($row_personasum['SURC_PersonaSumario_IdClasePer']) and
                                              $row_personasum['SURC_PersonaSumario_IdClasePer']==$row_surc_clasepersona['SURC_ClasePersona_Id']) {
                                                echo 'selected';
                                              } ?>>
                                              <?php echo utf8_encode($row_surc_clasepersona['SURC_ClasePersona_Descrip']); ?>
                                            </option>
                                            <?php } while ($row_surc_clasepersona=mysqli_fetch_array($surc_clasepersona));?>




                  </select>
                </td>
              </tr>
              <tr>
                <td>Vinculo de Persona</td>
                <td>
                  <select type="text" class="select" name="SURC_PersonaSumario_IdVinculo">
                  <option value="">Seleccionar</option>
                  <?php

                          $surc_vinculopersona=mysqli_query($conex_surc," SELECT * FROM surc.surc_vinculopersona;")
                                            or  die("Problemas con el select vinculo persona: ".mysqli_error($conex_surc));

                          $row_surc_vinculopersona=mysqli_fetch_array($surc_vinculopersona);
                                            do {?>
                                              <option value="<?php
                                                  echo   $row_surc_vinculopersona['SURC_VinculoPersona_Id'];
                                                ?>" <?php if (isset($row_personasum['SURC_PersonaSumario_IdVinculo']) and
                                              $row_personasum['SURC_PersonaSumario_IdVinculo']==$row_surc_vinculopersona['SURC_VinculoPersona_Id']) {
                                                echo 'selected';
                                              } ?>>
                                              <?php echo utf8_encode($row_surc_vinculopersona['SURC_VinculoPersona_Descrip']); ?>
                                            </option>
                                            <?php } while ($row_surc_vinculopersona=mysqli_fetch_array($surc_vinculopersona));?>




                  </select>
                </td>
              </tr>
              <tr>
                <td>Es Menor</td>
                <td>
                  <input type="checkbox" name="SURC_PersonaSumario_EsMenor" value="esmenor" <?php if (!empty($row_personasum['SURC_PersonaSumario_EsMenor'])) {
                    if ($row_personasum['SURC_PersonaSumario_EsMenor']=="S") {
                      echo 'checked';
                    }
                  } ?>>
                </td>
              </tr>
              <tr>
                <td>Observaciones</td>
                <td>
                  <textarea name="SURC_PersonaSumario_Obs" rows="8" cols="80" style="overflow-y:scroll;text-align:justify;"><?= utf8_encode($row_personasum['SURC_PersonaSumario_Obs']) ?></textarea>

                </td>
              </tr>


            </table>

            <table>
              <tr>
                <td>
                  <button type="submit" name="btn_guardarpersona_upd" value="Guardar Cambios" class="btnguardar"><span class="soloimagen">Guardar Cambios</span></button>

                </td>
                <td>
                  <button type="submit" name="btn_cancelarpersona_upd" value="Cancelar" class="btncancelar"><span class="soloimagen">Cancelar</span></button>

                </td>
              </table>
      </form>



        </div>


    </article>


  </section>

  <div id="footer"><?php include ('footer.php');?></div>


</body>
</html>
