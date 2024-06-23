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

  $personas_surc= mysqli_query($conex_surc,"SELECT * FROM surc_persona where SURC_Persona_Id='$_SESSION[persona_id]'")
  or die("Problemas con el select consulta datos personas surc : ".mysqli_error($conex_surc));

  $row_personas_surc=mysqli_fetch_array($personas_surc);
  $num_personas_surc= $personas_surc->num_rows;
}

if (!empty($_REQUEST['btn_guardar_persona_upd']) and $_REQUEST['btn_guardar_persona_upd']=='Modificar') {

    mysqli_query($conex_surc,"SET NAMES 'utf8'");


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

    //*****************captar el usuario que hace la modificacion**************************************//

    $usuario=mysqli_query($conexion,"SELECT * FROM segusuario.usuarios
                                    where usuario_id='$_SESSION[usuario_id]'") or
                                    die("Problemas con el select usuarios : ".mysqli_error($conexion));
    $row_usuario=mysqli_fetch_array($usuario);

    $SURC_Sumario_CargaUsuario=mb_strtoupper($row_usuario['usuario_cuenta']);
    //**************************************************************************************************//

    //*********************auditoria de lo que modifico creo la gemela para comparar********************//
    $audit_personas_surc= mysqli_query($conex_surc,"SELECT * FROM surc_persona where SURC_Persona_Id='$_SESSION[persona_id]'")
    or die("Problemas con el select consulta datos personas surc auditoria : ".mysqli_error($conex_surc));

    $num_audit_personas_surc= $audit_personas_surc->num_rows;

    //*****************************************************************************************************//

    $upd_pers="UPDATE surc.surc_persona SET
    SURC_Persona_Apellido= NULLIF('$SURC_Persona_Apellido',''),
    SURC_Persona_Nombre=NULLIF('$SURC_Persona_Nombre',''),
    SURC_Persona_Sexo= NULLIF('$SURC_Persona_Sexo',''),
    SURC_Persona_FechNacim= NULLIF('$SURC_Persona_FechNacim',''),
    SURC_Persona_Documento= NULLIF('$SURC_Persona_Documento',''),
    SURC_Persona_ApellidoNombre=NULLIF('$SURC_Persona_ApellidoNombre',''),
    SURC_Persona_Alias=NULLIF('$SURC_Persona_Alias',''),
    SURC_Persona_Edad= NULLIF('$SURC_Persona_Edad','0'),
    SURC_Persona_IdApeNom= NULLIF('$SURC_Persona_IdApeNom',''),
    SURC_Persona_Telefono= NULLIF('$SURC_Persona_Telefono',''),
    SURC_Persona_IdNacionalidad= NULLIF('$SURC_Persona_IdNacionalidad',''),
    SURC_Persona_IdEstadoCivil= NULLIF('$SURC_Persona_IdEstadoCivil',''),
    SURC_Persona_ApellidoPadre= NULLIF('$SURC_Persona_ApellidoPadre',''),
    SURC_Persona_NombrePadre= NULLIF('$SURC_Persona_NombrePadre',''),
    SURC_Persona_ApellidoMadre= NULLIF('$SURC_Persona_ApellidoMadre',''),
    SURC_Persona_NombreMadre= NULLIF('$SURC_Persona_NombreMadre','')


  where SURC_Persona_Id='$_SESSION[persona_id]'";

  if ($upd_pers_sum=mysqli_query($conex_surc,$upd_pers)) {

          // ultimo id auditoria

          $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
    	    $row_uid = mysqli_fetch_array($uid);

          $nuevo_id = ($row_uid['max_id']+1);

          // insertar registro
           $activ="Modificacion existosa. ";

           while ($row_audit_personas_surc = mysqli_fetch_array($audit_personas_surc)) {
             if ($row_audit_personas_surc['SURC_Persona_Apellido']!=$SURC_Persona_Apellido) {
                  $activ=$activ.' '."SURC_Persona_Apellido".':'.$row_audit_personas_surc['SURC_Persona_Apellido'].' '.$SURC_Persona_Apellido;
              }
              if ($row_audit_personas_surc['SURC_Persona_Nombre']!=$SURC_Persona_Nombre) {
                  $activ=$activ.' '."SURC_Persona_Nombre".':'.$row_audit_personas_surc['SURC_Persona_Nombre'].' '.$SURC_Persona_Nombre;
              }
              if ($row_audit_personas_surc['SURC_Persona_Sexo']!=$SURC_Persona_Sexo) {
                  $activ=$activ.' '."SURC_Persona_Sexo".':'.$row_audit_personas_surc['SURC_Persona_Sexo'].' '.$SURC_Persona_Sexo;
              }
              if ($row_audit_personas_surc['SURC_Persona_FechNacim']!=$SURC_Persona_FechNacim) {
                  $activ=$activ.' '."SURC_Persona_FechNacim".':'.$row_audit_personas_surc['SURC_Persona_FechNacim'].' '.$SURC_Persona_FechNacim;
              }
              if ($row_audit_personas_surc['SURC_Persona_Documento']!=$SURC_Persona_Documento) {
                  $activ=$activ.' '."SURC_Persona_Documento".':'.$row_audit_personas_surc['SURC_Persona_Documento'].' '.$SURC_Persona_Documento;
              }
              if ($row_audit_personas_surc['SURC_Persona_ApellidoNombre']!=$SURC_Persona_ApellidoNombre) {
                  $activ=$activ.' '."SURC_Persona_ApellidoNombre".':'.$row_audit_personas_surc['SURC_Persona_ApellidoNombre'].' '.$SURC_Persona_ApellidoNombre;
              }
              if ($row_audit_personas_surc['SURC_Persona_Alias']!=$SURC_Persona_Alias) {
                  $activ=$activ.' '."SURC_Persona_Alias".':'.$row_audit_personas_surc['SURC_Persona_Alias'].' '.$SURC_Persona_Alias;
              }
              if ($row_audit_personas_surc['SURC_Persona_Edad']!=$SURC_Persona_Edad) {
                  $activ=$activ.' '."SURC_Persona_Edad".':'.$row_audit_personas_surc['SURC_Persona_Edad'].' '.$SURC_Persona_Edad;
              }
              if ($row_audit_personas_surc['SURC_Persona_IdApeNom']!=$SURC_Persona_IdApeNom) {
                  $activ=$activ.' '."SURC_Persona_IdApeNom".':'.$row_audit_personas_surc['SURC_Persona_IdApeNom'].' '.$SURC_Persona_IdApeNom;
              }
              if ($row_audit_personas_surc['SURC_Persona_Telefono']!=$SURC_Persona_Telefono) {
                  $activ=$activ.' '."SURC_Persona_Telefono".':'.$row_audit_personas_surc['SURC_Persona_Telefono'].' '.$SURC_Persona_Telefono;
              }
              if ($row_audit_personas_surc['SURC_Persona_IdNacionalidad']!=$SURC_Persona_IdNacionalidad) {
                  $activ=$activ.' '."SURC_Persona_IdNacionalidad".':'.$row_audit_personas_surc['SURC_Persona_IdNacionalidad'].' '.$SURC_Persona_IdNacionalidad;
              }
              if ($row_audit_personas_surc['SURC_Persona_IdEstadoCivil']!=$SURC_Persona_IdEstadoCivil) {
                  $activ=$activ.' '."SURC_Persona_IdEstadoCivil".':'.$row_audit_personas_surc['SURC_Persona_IdEstadoCivil'].' '.$SURC_Persona_IdEstadoCivil;
              }
              if ($row_audit_personas_surc['SURC_Persona_ApellidoPadre']!=$SURC_Persona_ApellidoPadre) {
                  $activ=$activ.' '."SURC_Persona_ApellidoPadre".':'.$row_audit_personas_surc['SURC_Persona_ApellidoPadre'].' '.$SURC_Persona_ApellidoPadre;
              }
              if ($row_audit_personas_surc['SURC_Persona_NombrePadre']!=$SURC_Persona_NombrePadre) {
                  $activ=$activ.' '."SURC_Persona_NombrePadre".':'.$row_audit_personas_surc['SURC_Persona_NombrePadre'].' '.$SURC_Persona_NombrePadre;
              }
              if ($row_audit_personas_surc['SURC_Persona_ApellidoMadre']!=$SURC_Persona_ApellidoMadre) {
                  $activ=$activ.' '."SURC_Persona_ApellidoMadre".':'.$row_audit_personas_surc['SURC_Persona_ApellidoMadre'].' '.$SURC_Persona_ApellidoMadre;
              }
              if ($row_audit_personas_surc['SURC_Persona_NombreMadre']!=$SURC_Persona_NombreMadre) {
                  $activ=$activ.' '."SURC_Persona_NombreMadre".':'.$row_audit_personas_surc['SURC_Persona_NombreMadre'].' '.$SURC_Persona_NombreMadre;
              }

        }

        mysqli_query($connaud,"SET NAMES 'utf8'");
        mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId,auditoria_action_id, auditoria_descrip)

              VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','5','$activ')");


        //fin registro actividad
        header("Location:surc_personas_upd.php?persona_id=$_SESSION[persona_id]");

  }


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
        <form class="" action="alta_personas_upd.php" method="post">

                <table class="plus conmargen">
                    <tr>
                      <td>Apellido Pers.</td>
                      <td>
                        <input type="text" style="text-transform:uppercase;" class="w18" name="SURC_Persona_Apellido" value="<?php if (!empty($row_personas_surc['SURC_Persona_Apellido'])) {
                          echo $row_personas_surc['SURC_Persona_Apellido'];
                        } ?>" required>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Nombre Pers.</td>
                      <td>
                        <input type="text" style="text-transform:uppercase;" class="w18" name="SURC_Persona_Nombre" value="<?php if (!empty($row_personas_surc['SURC_Persona_Nombre'])) {
                          echo $row_personas_surc['SURC_Persona_Nombre'];
                        } ?>" required>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Alias Apodo</td>
                      <td>
                          <input type="text" style="text-transform:uppercase;" class="w8" name="SURC_Persona_Alias" value="<?php if (!empty($row_personas_surc['SURC_Persona_Alias'])) {
                            echo $row_personas_surc['SURC_Persona_Alias'];
                          }?>">
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
                                  ?>" <?php if (isset($row_personas_surc['SURC_Persona_IdEstadoCivil']) and $row_personas_surc['SURC_Persona_IdEstadoCivil']==$row_estado_civil['SURC_EstadoCivil_Id']
                                    ) {
                                    echo 'selected';
                                  } ?>>
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
                                <option value="M"
                                <?php if (isset($row_personas_surc['SURC_Persona_Sexo']) AND
                                  $row_personas_surc['SURC_Persona_Sexo']=='M') {
                                  echo 'selected';
                                } ?>>Masculino</option>
                                <option value="F"
                                <?php if (isset($row_personas_surc['SURC_Persona_Sexo']) AND
                                  $row_personas_surc['SURC_Persona_Sexo']=='F') {
                                  echo 'selected';
                                } ?>>Femenino</option>
                         </select>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Fecha Nacimiento</td>
                      <td>
                        <input type="date" name="SURC_Persona_FechNacim" value="<?php if (!empty($row_personas_surc['SURC_Persona_FechNacim'])) {
                          echo $row_personas_surc['SURC_Persona_FechNacim'];
                        } ?>">
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Edad</td>
                      <td>
                        <input type="number" name="SURC_Persona_Edad" value="<?php if (!empty($row_personas_surc['SURC_Persona_Edad'])) {
                          echo $row_personas_surc['SURC_Persona_Edad'];
                        }else {
                          echo "0";
                        } ?>">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Nro. Documento</td>
                      <td>
                        <input type="text" name="SURC_Persona_Documento" value="<?php if (!empty($row_personas_surc['SURC_Persona_Documento'])) {
                          echo $row_personas_surc['SURC_Persona_Documento'];
                        } ?>">
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
                                ?>"  <?php if (isset($row_personas_surc['SURC_Persona_IdNacionalidad']) and $row_personas_surc['SURC_Persona_IdNacionalidad']==$row_SURC_Persona_IdNacionalidad['Nac_Codigo']
                                  ) {
                                  echo 'selected';
                                } ?>>
                              <?php echo utf8_encode($row_SURC_Persona_IdNacionalidad['Nac_Descrip']); ?>
                            </option>
                          <?php } while ($row_SURC_Persona_IdNacionalidad=mysqli_fetch_array($SURC_Persona_IdNacionalidad))?>

                        </select>
                      </td>

                      <td>&nbsp; &nbsp;</td>
                      <td>Telefóno</td>
                      <td>
                        <input type="text" class="w8" name="SURC_Persona_Telefono" value="<?php if (!empty($row_personas_surc['SURC_Persona_Telefono'])) {
                          echo $row_personas_surc['SURC_Persona_Telefono'];
                        } ?>">
                      </td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                    </tr>

                    <tr>
                      <td>Nombres Padre</td>
                      <td>
                        <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_NombrePadre" value="<?php if (!empty($row_personas_surc['SURC_Persona_NombrePadre'])) {
                          echo $row_personas_surc['SURC_Persona_NombrePadre'];
                        } ?>">
                      </td>
                        <td>&nbsp; &nbsp;</td>
                        <td>Apellidos Padre</td>
                        <td>
                          <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_ApellidoPadre" value="<?php if (!empty($row_personas_surc['SURC_Persona_ApellidoPadre'])) {
                            echo $row_personas_surc['SURC_Persona_ApellidoPadre'];
                          } ?>">
                        </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Nombres Madre</td>
                      <td>
                        <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_NombreMadre" value="<?php if (!empty($row_personas_surc['SURC_Persona_NombreMadre'])) {
                          echo $row_personas_surc['SURC_Persona_NombreMadre'];
                        } ?>">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Apellidos Madre</td>
                      <td>
                        <input type="text" class="w18" style="text-transform:uppercase;" name="SURC_Persona_ApellidoMadre" value="<?php if (!empty($row_personas_surc['SURC_Persona_ApellidoMadre'])) {
                          echo $row_personas_surc['SURC_Persona_ApellidoMadre'];
                        } ?>">
                      </td>
                    </tr>

                  </table>

                <table>
                  <tr>
                    <td>
                    <button type="submit" name="btn_guardar_persona_upd" value="Modificar" class="btnguardar"><span class="soloimagen">Modificar</span></button>
                    </td>
                    <td>
                    <button type="submit" name="btn_cancelar_persona_upd" value="Cancelar" form='salir' class="btncancelar"><span class="soloimagen">Cancelar</span></button>

                    </td>
                  </tr>
                </table>


        </form>


      </div>


    </article>
    <form class="" action="surc_personas_upd.php" id="salir" method="post">
      <input type="hidden" name="tab" value="2">
      <input type="hidden" name="SURC_PersonaSumario_IdPersona" value="<?php echo $_SESSION['persona_id']; ?>">

    </form>


  </section>

    <div id="footer"><?php include ('footer.php');?></div>
  </html>
