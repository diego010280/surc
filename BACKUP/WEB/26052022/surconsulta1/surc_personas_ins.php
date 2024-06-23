<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/conndb_gral.php');
require_once ('connections/connauditoria.php');

date_default_timezone_set('America/Argentina/Salta');

$mensaje='';


if (!empty($_REQUEST['buscar_persona']) and $_REQUEST['buscar_persona']=='buscar') {

        if (!empty($_REQUEST['SURC_Persona_Documento'])) {

                      $dni_buscar  = (empty($_REQUEST['SURC_Persona_Documento'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Documento']));

                      $personas_rrhh= mysqli_query($conndb_gral,"SELECT * FROM db_gral.personas where db_gral.personas.persona_nro_doc='$dni_buscar';")
                                      or die("Problemas con el select consulta datos personas rrhh : ".mysqli_error($conndb_gral));

                      $row_personas_rrhh=mysqli_fetch_array($personas_rrhh);
                      $num_personas_rrhh= $personas_rrhh->num_rows;


                        if ($num_personas_rrhh<=1) {
                            $persona_id=$row_personas_rrhh['persona_id'];
                            $SURC_Persona_Documento   = (empty($_REQUEST['SURC_Persona_Documento'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Documento']));
                            header("Location: alta_personas.php?persona_id=$persona_id&SURC_Persona_Documento=$SURC_Persona_Documento");
                        }

      } else {
            $mensaje='dnivacio';
      }
} elseif (!empty($_REQUEST['SURC_Persona_Id']) and $_REQUEST['vienede']=='alta_per') {
    $SURC_Persona_Id=$_REQUEST['SURC_Persona_Id'];

   $surc_personas= mysqli_query($conex_surc,"SELECT * FROM surc.surc_persona where SURC_Persona_Id='$SURC_Persona_Id'")
   or die("Problemas con el select consulta datos personas sumario : ".mysqli_error($conex_surc));

   $row_surc_personas=mysqli_fetch_array($surc_personas);
   $num_surc_personas= $surc_personas->num_rows;

} else {

  if (!empty($_REQUEST['btn_surc_sumpersona_ins']) and $_REQUEST['btn_surc_sumpersona_ins']=='Insertar Sum_Per') {

    $Id_SURC_PersonaSumario_Id = mysqli_query($conex_surc,"SELECT MAX(SURC_PersonaSumario_Id) as 'id' FROM surc.surc_sumariopersona") or
    die("Problema con la obtencion del id maximo del surc_sumariopersona: ".mysqli_error($conex_surc));

    if ($row = mysqli_fetch_array($Id_SURC_PersonaSumario_Id)) {
    $id_persona = trim($row[0]);
    $PersonaSumario_Id=$id_persona+1;
    }


    $SURC_Sumario_Id=intval($_SESSION['SURC_Sumario_Id']);
    $SURC_PersonaSumario_Id=intval($PersonaSumario_Id);
    $SURC_PersonaSumario_IdPersona=intval($_REQUEST['SURC_Persona_Id']);
    $SURC_PersonaSumario_IdTipoPers=intval($_REQUEST['SURC_PersonaSumario_IdTipoPers']);
    $SURC_PersonaSumario_IdClasePer=intval($_REQUEST['SURC_PersonaSumario_IdClasePer']);
    $SURC_PersonaSumario_IdVinculo=intval($_REQUEST['SURC_PersonaSumario_IdVinculo']);

    if (!empty($_REQUEST['SURC_PersonaSumario_EsMenor']) and ($_REQUEST['SURC_PersonaSumario_EsMenor']=='esmenor')) {
      $SURC_PersonaSumario_EsMenor='S';
    } else {
     $SURC_PersonaSumario_EsMenor='N';
    }

    $SURC_PersonaSumario_Obs=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_PersonaSumario_Obs']))));


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

    mysqli_query($conex_surc,"SET NAMES 'utf8'");

    $sumario_persona= "INSERT INTO surc_sumariopersona(SURC_Sumario_Id,SURC_PersonaSumario_Id,
    SURC_PersonaSumario_IdPersona,SURC_PersonaSumario_IdTipoPers,SURC_PersonaSumario_IdClasePer,
    SURC_PersonaSumario_IdVinculo,SURC_PersonaSumario_EsMenor,SURC_PersonaSumario_Obs)

    VALUES (
            '$SURC_Sumario_Id','$SURC_PersonaSumario_Id',
            '$SURC_PersonaSumario_IdPersona','$SURC_PersonaSumario_IdTipoPers','$SURC_PersonaSumario_IdClasePer',
            '$SURC_PersonaSumario_IdVinculo','$SURC_PersonaSumario_EsMenor',NULLIF('$SURC_PersonaSumario_Obs','')
           )";

      if (mysqli_query($conex_surc,$sumario_persona)) {

        // ultimo id auditoria

        $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
        $row_uid = mysqli_fetch_array($uid);

        $nuevo_id = ($row_uid['max_id']+1);

        // insertar registro
         $activ="Alta existosa. surc_sumariopersona";
         mysqli_query($connaud,"SET NAMES 'utf8'");
         mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id, auditoria_action_id, auditoria_descrip)

               VALUES ('$nuevo_id', '$_SESSION[usuario_id]','3','$activ')");


         //fin registro actividad

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
            // ultimo id auditoria

            $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
            $row_uid = mysqli_fetch_array($uid);

            $nuevo_id = ($row_uid['max_id']+1);

            // insertar registro
             $activ="Modificacion existosa.Surc_sumario M ".$SURC_Sumario_CargaUsuario.' '.$SURC_Sumario_FechaSum.' '.$SURC_Sumario_HoraSum;
             mysqli_query($connaud,"SET NAMES 'utf8'");
             mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId ,auditoria_action_id, auditoria_descrip)

                   VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','5','$activ')");


             //fin registro actividad

            header("Location: sum_d_upd.php?accion=ins&tab=2");

          } else {
            header("Location: sum_d_upd.php?accion=no_upd&tab=2");
          }
      } else {
        header("Location:sum_d_upd.php?accion=no_ins&tab=2");
      }





}
}





?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <link rel="stylesheet" type="text/css" href="css/abm.css?v=2.033">
    <link rel="stylesheet" type="text/css" href="css/alta.css?v=2.2">
	  <link rel="stylesheet" type="text/css" href="css/ventanas.css?v=1.02">
    <link rel="stylesheet" type="text/css" href="css/estilos-doc.css">
    <script type="text/javascript" defer src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" defer src="js/JFunciones.js?v=1.02"></script>

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
    <form class="" action="surc_personas_ins.php" method="post">
      <input type="hidden" name="SURC_Persona_Id" value="<?php echo $_REQUEST['SURC_Persona_Id'] ?>">
      <div class="mensaje">
            <div id="mensaje">
            <?php
              if (!empty($mensaje)) {
                if ($mensaje == 'dnivacio') {
                  echo '<span class="naranja">Debe ingresar un Documento para la busqueda de la persona</span>';
                }
              } ?>
            </div>
      </div>


      <article id="artwo">
        <p>
          Datos Personas Vinculadas con el Hecho
        </p>
        <div class="borde">
          <table class="plus conmargen">
            <tr>
              <td>Ingrese DNI:</td>
              <td>
                <input type="text" class="w8" name="SURC_Persona_Documento" value="<?php if (!empty($_REQUEST['SURC_Persona_Documento'])) {
                  echo $_REQUEST['SURC_Persona_Documento'];
                }  ?>">
              </td>
              <td>
                <button type="submit" class="btncel" value="buscar" name="buscar_persona">Buscar</button>
              </td>
              <td>
                <button type="submit" class="btncel" form="limpiar">Limpiar Busqueda</button>
              </td>

            </tr>

          </table>


          <?php
          if (!empty($_REQUEST['buscar_persona']) and $_REQUEST['buscar_persona']=='buscar') {
             if ($num_personas_rrhh>1) {
                 include 'grilla_personas_rrhh.php';
             }
          } elseif (!empty($_REQUEST['SURC_Persona_Id']) and $_REQUEST['vienede']=='alta_per') {
              include 'surc_personas_altasum.php';?>
              <table>
                <tr>
                  <td>
                    <button type="submit" name="btn_surc_sumpersona_ins" value="Insertar Sum_Per" class="btnguardar"><span class="soloimagen">Insertar</span></button>

                  </td>
                  <td>
                    <button type="submit" name="btn_surc_sumpersonacancelar_ins" form="salirsumper" value="Cancelar" class="btncancelar"><span class="soloimagen">Cancelar</span></button>

                  </td>
				</tr>
                </table>
        <?php } ?>


        </div>



          </form>



      </article>


    <form class="" action="surc_personas_ins.php" id="limpiar" method="post">   </form>
    <form class="" action="sum_d_upd.php" id="salirsumper" method="post">
        <input type="hidden" name="tab" value="2">
    </form>



  </section>

  <div id="footer"><?php include ('footer.php');?></div>


</body>
</html>
