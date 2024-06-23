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



if (!empty($_REQUEST['persona_id'])) {
  $_SESSION['persona_id']=$_REQUEST['persona_id'];
  $_SESSION['SURC_Persona_Documento']=$_REQUEST['SURC_Persona_Documento'];

  $personas_rrhh= mysqli_query($conndb_gral,"SELECT * FROM db_gral.personas where persona_id='$_SESSION[persona_id]'")
  or die("Problemas con el select consulta datos personas rrhh : ".mysqli_error($conndb_gral));

  $row_personas_rrhh=mysqli_fetch_array($personas_rrhh);
  $num_personas_rrhh= $personas_rrhh->num_rows;
}

if (!empty($_REQUEST['btn_guardar_persona_upd']) and $_REQUEST['btn_guardar_persona_upd']=='Insertar') {

  mysqli_query($conex_surc,"SET NAMES 'utf8'");

  $Id_surc_persona = mysqli_query($conex_surc,"SELECT MAX(`SURC_Persona_Id`) as 'id' FROM `surc_persona`") or
  die("Problema con la obtencion del id maximo del surc_persona: ".mysqli_error($conex_surc));

  if ($row = mysqli_fetch_array($Id_surc_persona)) {
  $id_persona = trim($row[0]);
  $SURC_Persona_Id=$id_persona+1;

  }



    $SURC_Persona_Apellido=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Apellido']))));
    $SURC_Persona_Nombre= mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Nombre']))));
    $SURC_Persona_Sexo= mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Sexo']))));
    $SURC_Persona_FechNacim = (empty($_REQUEST['SURC_Persona_FechNacim'])) ? '' : $_REQUEST['SURC_Persona_FechNacim'];
    // $SURC_Persona_FechNacim=$_REQUEST['SURC_Persona_FechNacim'];
    $SURC_Persona_Documento=utf8_encode(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Documento']))));
    $SURC_Persona_ApellidoNombre=$SURC_Persona_Apellido.', '.$SURC_Persona_Nombre;
    $SURC_Persona_Alias=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Alias']))));
    $SURC_Persona_Edad= intval($_REQUEST['SURC_Persona_Edad']);
    $SURC_Persona_IdApeNom=$SURC_Persona_Id.' - '.$SURC_Persona_ApellidoNombre;
    $SURC_Persona_Telefono=utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_Telefono'])));
    $SURC_Persona_IdNacionalidad=intval($_REQUEST['SURC_Persona_Edad']);
    $SURC_Persona_IdEstadoCivil=intval($_REQUEST['SURC_Persona_IdEstadoCivil']);
    $SURC_Persona_ApellidoPadre=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_ApellidoPadre']))));
    $SURC_Persona_NombrePadre=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_NombrePadre']))));
    $SURC_Persona_ApellidoMadre=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_ApellidoMadre']))));
    $SURC_Persona_NombreMadre=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Persona_NombreMadre']))));


    $insert_surc_persona="INSERT INTO surc_persona(
      SURC_Persona_Id, SURC_Persona_Apellido, SURC_Persona_Nombre, SURC_Persona_Sexo, SURC_Persona_FechNacim,
      SURC_Persona_Documento,SURC_Persona_ApellidoNombre,SURC_Persona_Alias,SURC_Persona_Edad,SURC_Persona_IdApeNom,
      SURC_Persona_Telefono,SURC_Persona_IdNacionalidad,SURC_Persona_IdEstadoCivil,SURC_Persona_ApellidoPadre,
      SURC_Persona_NombrePadre,SURC_Persona_ApellidoMadre,SURC_Persona_NombreMadre)

      VALUES ('$SURC_Persona_Id','$SURC_Persona_Apellido','$SURC_Persona_Nombre',NULLIF('$SURC_Persona_Sexo',''), NULLIF('$SURC_Persona_FechNacim',''),
        NULLIF('$SURC_Persona_Documento',''),'$SURC_Persona_ApellidoNombre',NULLIF('$SURC_Persona_Alias',''),'$SURC_Persona_Edad', '$SURC_Persona_IdApeNom',
        NULLIF('$SURC_Persona_Telefono',''),NULLIF('$SURC_Persona_IdNacionalidad',''),NULLIF('$SURC_Persona_IdEstadoCivil',''),NULLIF('$SURC_Persona_ApellidoPadre',''),
        NULLIF('$SURC_Persona_NombrePadre',''),NULLIF('$SURC_Persona_ApellidoMadre',''),NULLIF('$SURC_Persona_NombreMadre',''))";

        if (mysqli_query($conex_surc,$insert_surc_persona)) {

          // ultimo id auditoria

          $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
          $row_uid = mysqli_fetch_array($uid);

          $nuevo_id = ($row_uid['max_id']+1);

          // insertar registro
           $activ="Alta existosa. surc_persona";
           mysqli_query($connaud,"SET NAMES 'utf8'");
           mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id, auditoria_moduloId,auditoria_action_id, auditoria_descrip)

                 VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','3','$activ')");


           //fin registro actividad

          header("Location:alta_personas_domicilio.php?persona_id=$SURC_Persona_Id&SURC_Persona_Documento=$SURC_Persona_Documento");
        } else {
          header("Location: sum_d_upd.php?accion=no_ins&tab=2");
        }

       // header("Location:surc_personas_ins.php?SURC_Persona_Id=$SURC_Persona_Id&SURC_Persona_Documento=$_SESSION[SURC_Persona_Documento]&vienede=alta_per");


}

?>
 <!DOCTYPE html>
 <html lang="es">
 <head>
     <?php include 'head.php' ?>
     <link rel="stylesheet" type="text/css" href="css/abm.css?v=2.033">
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
    <article class="artwo">

      <div class="titulo">
          <img src="imagenes/team.png" height="32px" width="33px">
          <div class="postitulo">Datos de la Persona</div>
      </div>

      <ul class="tabs group">
        <li class="active"> <a href="#">Datos Personales</a></li>

      </ul>


      <div id="content">
        <form class="" action="alta_personas.php" method="post">

                <table class="plus conmargen">
                    <tr>
                      <td>Apellido Pers.</td>
                      <td>
                        <input type="text" style="text-transform:uppercase;" class="w18" name="SURC_Persona_Apellido" value="<?php if (!empty($row_personas_rrhh['persona_apellido'])) {
                          echo $row_personas_rrhh['persona_apellido'];
                        } ?>" required>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Nombre Pers.</td>
                      <td>
                        <input type="text" style="text-transform:uppercase;" class="w18" name="SURC_Persona_Nombre" value="<?php if (!empty($row_personas_rrhh['persona_nombre'])) {
                          echo $row_personas_rrhh['persona_nombre'];
                        } ?>" required>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Alias Apodo</td>
                      <td>
                          <input type="text" style="text-transform:uppercase;" class="w8" name="SURC_Persona_Alias" value="">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Estado Civil</td>
                      <td>

                        <select type="text" class="select" name="SURC_Persona_IdEstadoCivil">
                            <option value="">Seleccionar...</option>
                            <?php
                              $estado_civil=mysqli_query($conex_surc," SELECT * FROM surc.surc_estadocivil;")
                                                or  die("Problemas con el select estado civil: ".mysqli_error($conex_surc));

                              $row_estado_civil=mysqli_fetch_array($estado_civil);
                              do {?>
                                <option value="<?php
                                    echo $row_estado_civil['SURC_EstadoCivil_Id'];
                                  ?>">
                                <?php echo utf8_encode($row_estado_civil['SURC_EstadoCivil_Descrip']); ?>
                              </option>
                            <?php } while ($row_estado_civil=mysqli_fetch_array($estado_civil));?>

                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Sexo Pers.</td>
                      <td>
                          <select type="text" class="select" name="SURC_Persona_Sexo">
                                <option value="">Seleccionar...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                         </select>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Fecha Nacimiento</td>
                      <td>
                        <input type="date" name="SURC_Persona_FechNacim" value="">
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Edad</td>
                      <td>
                        <input type="number" name="SURC_Persona_Edad" value="0">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Nro. Documento</td>
                      <td>
                        <input type="text" name="SURC_Persona_Documento" value="<?php if (!empty($row_personas_rrhh['persona_nro_doc'])) {
                          echo $row_personas_rrhh['persona_nro_doc'];
                        } ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Nacionalidad</td>
                      <td>
                        <select type="text" class="select" name="SURC_Persona_IdNacionalidad">
                            <option value="">Seleccionar</option>
                            <?php

                            $SURC_Persona_IdNacionalidad=mysqli_query($conex_dbseg," SELECT * FROM dbseg.ref_nacionalidad;")
                                              or  die("Problemas con el select nacionalidad: ".mysqli_error($conex_dbseg));

                            $row_SURC_Persona_IdNacionalidad=mysqli_fetch_array($SURC_Persona_IdNacionalidad);
                            do {?>
                              <option value="<?php
                                  echo $row_SURC_Persona_IdNacionalidad['Nac_Codigo'];
                                ?>">
                              <?php echo utf8_encode($row_SURC_Persona_IdNacionalidad['Nac_Descrip']); ?>
                            </option>
                          <?php } while ($row_SURC_Persona_IdNacionalidad=mysqli_fetch_array($SURC_Persona_IdNacionalidad))?>

                        </select>
                      </td>

                      <td>&nbsp; &nbsp;</td>
                      <td>Telefóno</td>
                      <td>
                        <input type="text" class="w8" name="SURC_Persona_Telefono" value="">
                      </td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                    </tr>

                    <tr>
                      <td>Nombres Padre</td>
                      <td>
                        <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_NombrePadre" value="">
                      </td>
                        <td>&nbsp; &nbsp;</td>
                        <td>Apellidos Padre</td>
                        <td>
                          <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_ApellidoPadre" value="">
                        </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Nombres Madre</td>
                      <td>
                        <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_NombreMadre" value="">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Apellidos Madre</td>
                      <td>
                        <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_ApellidoMadre" value="">
                      </td>
                    </tr>

                  </table>

                <table>
                  <tr>
                    <td>
                    <button type="submit" name="btn_guardar_persona_upd" value="Insertar" class="btnguardar"><span class="soloimagen">Insertar</span></button>
                    </td>
                    <td>
                    <button type="submit" name="btn_cancelar_persona_upd" value="Cancelar" form='salir' class="btncancelar"><span class="soloimagen">Cancelar</span></button>

                    </td>
                  </tr>
                </table>


        </form>


      </div>


    </article>
    <form class="" action="sum_d_upd.php" id="salir" method="post">
      <input type="hidden" name="tab" value="2">

    </form>


  </section>

    <div id="footer"><?php include ('footer.php');?></div>
  </html>
