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

}



if (!empty($_REQUEST['btn_guardar_dliopersona_upd']) and $_REQUEST['btn_guardar_dliopersona_upd']=='Insertar') {

    $domicilio= mysqli_query($conex_surc,"SELECT * FROM surc.surc_domiciliospers where SURC_Persona_Id='$_SESSION[persona_id]'") or
    die ("Problema con la obtencion del domicilio surc: ".mysqli_error($conex_surc));
    $num_domicilio= $domicilio->num_rows;

    if ($num_domicilio>0) {
      $Id_SURC_DomiciliosPers_Id = mysqli_query($conex_surc,"SELECT MAX(SURC_DomiciliosPers_Id) as 'id' FROM surc.surc_domiciliospers
      where SURC_Persona_Id='$_SESSION[persona_id]'") or
      die("Problema con la obtencion del id maximo del surc_domiciliospers: ".mysqli_error($conex_surc));

      if ($row = mysqli_fetch_array($Id_SURC_DomiciliosPers_Id)) {
      $id_dlio = trim($row[0]);
      $SURC_DomiciliosPers_Id=$id_dlio+1;
      }
      $SURC_DomiciliosPers_Calle=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Calle']))));
      $SURC_DomiciliosPers_Altura= intval($_REQUEST['SURC_DomiciliosPers_Altura']);
      $SURC_DomiciliosPers_Manzana=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Manzana']))));
      $SURC_DomiciliosPers_Piso=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Piso']))));
      $SURC_DomiciliosPers_Dpto=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Dpto']))));
      $SURC_DomiciliosPers_LoteCasa=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_LoteCasa']))));
      $SURC_DomiciliosPers_IdBarrio=intval($_REQUEST['SURC_DomiciliosPers_IdBarrio']);
      $SURC_DomiciliosPers_IdLocalida=intval($_REQUEST['SURC_DomiciliosPers_IdLocalida']);
      $SURC_DomiciliosPers_IdProvinci=intval($_REQUEST['SURC_DomiciliosPers_IdProvinci']);
      $SURC_DomiciliosPers_IdPais=intval($_REQUEST['SURC_DomiciliosPers_IdPais']);
      $SURC_DomiciliosPers_IdDependen=intval($_REQUEST['SURC_DomiciliosPers_IdDependen']);
      $SURC_DomiciliosPers_Observacio=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Observacio']))));
      $SURC_DomiciliosPers_CoordX=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_CoordX']))));
      $SURC_DomiciliosPers_CoordY=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_CoordY']))));
      $SURC_DomiciliosPers_Fecha=date('Y-m-d');

      mysqli_query($conex_surc,"SET NAMES 'utf8'");

      $insert_surc_domiciliospers="INSERT INTO surc_domiciliospers(
        SURC_DomiciliosPers_Id,SURC_Persona_Id,SURC_DomiciliosPers_Calle,SURC_DomiciliosPers_Altura,
        SURC_DomiciliosPers_Manzana,SURC_DomiciliosPers_Piso,SURC_DomiciliosPers_Dpto,
        SURC_DomiciliosPers_LoteCasa,SURC_DomiciliosPers_IdBarrio,SURC_DomiciliosPers_IdLocalida,
        SURC_DomiciliosPers_IdProvinci,SURC_DomiciliosPers_IdPais,SURC_DomiciliosPers_CoordX,
        SURC_DomiciliosPers_CoordY,SURC_DomiciliosPers_Observacio,SURC_DomiciliosPers_IdDependen,
        SURC_DomiciliosPers_Fecha)

        VALUES (
          '$SURC_DomiciliosPers_Id','$_SESSION[persona_id]','$SURC_DomiciliosPers_Calle','$SURC_DomiciliosPers_Altura',
          NULLIF('$SURC_DomiciliosPers_Manzana',''),NULLIF('$SURC_DomiciliosPers_Piso',''),NULLIF('$SURC_DomiciliosPers_Dpto',''),
          NULLIF('$SURC_DomiciliosPers_LoteCasa',''),NULLIF('$SURC_DomiciliosPers_IdBarrio',0),NULLIF('$SURC_DomiciliosPers_IdLocalida',0),
          NULLIF('$SURC_DomiciliosPers_IdProvinci',0),NULLIF('$SURC_DomiciliosPers_IdPais',0),NULLIF('$SURC_DomiciliosPers_CoordX',''),
          NULLIF('$SURC_DomiciliosPers_CoordY',''),NULLIF('$SURC_DomiciliosPers_Observacio',''),NULLIF('$SURC_DomiciliosPers_IdDependen',0),
          '$SURC_DomiciliosPers_Fecha')";

        if (mysqli_query($conex_surc,$insert_surc_domiciliospers)) {
          // ultimo id auditoria

          $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
          $row_uid = mysqli_fetch_array($uid);

          $nuevo_id = ($row_uid['max_id']+1);

          // insertar registro
           $activ="Alta existosa. surc_domiciliospers";
           mysqli_query($connaud,"SET NAMES 'utf8'");
           mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId ,auditoria_action_id, auditoria_descrip)

                 VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','3','$activ')");


           //fin registro actividad
           header("Location:surc_personas_ins.php?SURC_Persona_Id=$_SESSION[persona_id]&SURC_Persona_Documento=$_SESSION[SURC_Persona_Documento]&vienede=alta_per");
        }else {
          header("Location: sum_d_upd.php?accion=no_ins&tab=2");
        }



   } else {

     $SURC_DomiciliosPers_Id=1;
     $SURC_DomiciliosPers_Calle=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Calle']))));
     $SURC_DomiciliosPers_Altura= intval($_REQUEST['SURC_DomiciliosPers_Altura']);
     $SURC_DomiciliosPers_Manzana=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Manzana']))));
     $SURC_DomiciliosPers_Piso=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Piso']))));
     $SURC_DomiciliosPers_Dpto=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Dpto']))));
     $SURC_DomiciliosPers_LoteCasa=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_LoteCasa']))));
     $SURC_DomiciliosPers_IdBarrio=intval($_REQUEST['SURC_DomiciliosPers_IdBarrio']);
     $SURC_DomiciliosPers_IdLocalida=intval($_REQUEST['SURC_DomiciliosPers_IdLocalida']);
     $SURC_DomiciliosPers_IdProvinci=intval($_REQUEST['SURC_DomiciliosPers_IdProvinci']);
     $SURC_DomiciliosPers_IdPais=intval($_REQUEST['SURC_DomiciliosPers_IdPais']);
     $SURC_DomiciliosPers_IdDependen=intval($_REQUEST['SURC_DomiciliosPers_IdDependen']);
     $SURC_DomiciliosPers_Observacio=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_Observacio']))));
     $SURC_DomiciliosPers_CoordX=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_CoordX']))));
     $SURC_DomiciliosPers_CoordY=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_DomiciliosPers_CoordY']))));
     $SURC_DomiciliosPers_Fecha=date('Y-m-d');

     mysqli_query($conex_surc,"SET NAMES 'utf8'");

     $insert_surc_domiciliospers="INSERT INTO surc_domiciliospers(
       SURC_DomiciliosPers_Id,SURC_Persona_Id,SURC_DomiciliosPers_Calle,SURC_DomiciliosPers_Altura,
       SURC_DomiciliosPers_Manzana,SURC_DomiciliosPers_Piso,SURC_DomiciliosPers_Dpto,
       SURC_DomiciliosPers_LoteCasa,SURC_DomiciliosPers_IdBarrio,SURC_DomiciliosPers_IdLocalida,
       SURC_DomiciliosPers_IdProvinci,SURC_DomiciliosPers_IdPais,SURC_DomiciliosPers_CoordX,
       SURC_DomiciliosPers_CoordY,SURC_DomiciliosPers_Observacio,SURC_DomiciliosPers_IdDependen,
       SURC_DomiciliosPers_Fecha)


         VALUES (
           '$SURC_DomiciliosPers_Id','$_SESSION[persona_id]','$SURC_DomiciliosPers_Calle','$SURC_DomiciliosPers_Altura',
           NULLIF('$SURC_DomiciliosPers_Manzana',''),NULLIF('$SURC_DomiciliosPers_Piso',''),NULLIF('$SURC_DomiciliosPers_Dpto',''),
           NULLIF('$SURC_DomiciliosPers_LoteCasa',''),NULLIF('$SURC_DomiciliosPers_IdBarrio',0),NULLIF('$SURC_DomiciliosPers_IdLocalida',0),
           NULLIF('$SURC_DomiciliosPers_IdProvinci',0),NULLIF('$SURC_DomiciliosPers_IdPais',0),NULLIF('$SURC_DomiciliosPers_CoordX',''),
           NULLIF('$SURC_DomiciliosPers_CoordY',''),NULLIF('$SURC_DomiciliosPers_Observacio',''),NULLIF('$SURC_DomiciliosPers_IdDependen',0),
           '$SURC_DomiciliosPers_Fecha')";

          if (mysqli_query($conex_surc,$insert_surc_domiciliospers)) {
            // ultimo id auditoria

            $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
            $row_uid = mysqli_fetch_array($uid);

            $nuevo_id = ($row_uid['max_id']+1);

            // insertar registro
             $activ="Alta existosa. surc_domiciliospers";
             mysqli_query($connaud,"SET NAMES 'utf8'");
             mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId, auditoria_action_id, auditoria_descrip)

                   VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','3','$activ')");


             //fin registro actividad
             header("Location:surc_personas_ins.php?SURC_Persona_Id=$_SESSION[persona_id]&SURC_Persona_Documento=$_SESSION[SURC_Persona_Documento]&vienede=alta_per");
          }else {
            header("Location: sum_d_upd.php?accion=no_ins&tab=2");
          }



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
        <li class="active"> <a href="#">Datos Domicilio Pers.</a></li>

      </ul>

      <div id="content">
        <form class="" action="alta_personas_domicilio.php" method="post">

          <table ALIGN="right">
                  <tr>
                    <td>
                    <button type="submit" name="btn_guardar_dliopersona_upd" value="Insertar" class="btnguardar"><span class="soloimagen">Insertar</span></button>
                    </td>
                    <td>
                    <button type="submit" name="btn_cancelar_dliopersona_upd" value="Cancelar" form='salir' class="btncancelar"><span class="soloimagen">Cancelar</span></button>

                    </td>
                  </tr>
                </table>

                <table class="plus conmargen">
                    <tr>
                      <td>Calle</td>
                      <td>
                        <input type="text" style="text-transform:uppercase;" class="w18" name="SURC_DomiciliosPers_Calle" value="" required>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Altura</td>
                      <td>
                        <input type="number" name="SURC_DomiciliosPers_Altura" value="" required>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Manzana</td>
                      <td>
                          <input type="text" style="text-transform:uppercase;" class="w8" name="SURC_DomiciliosPers_Manzana" value="">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Piso</td>
                      <td>
                          <input type="text" style="text-transform:uppercase;" class="w8" name="SURC_DomiciliosPers_Piso" value="">
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Departamento</td>
                      <td>
                        <input type="text" style="text-transform:uppercase;" class="w8" name="SURC_DomiciliosPers_Dpto" value="">
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Pers_Lote Casa</td>
                      <td>
                          <input type="text" style="text-transform:uppercase;" class="w8" name="SURC_DomiciliosPers_LoteCasa" value="">
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Barrio</td>
                      <td>
                        <select type="text" class="select" name="SURC_DomiciliosPers_IdBarrio">
                            <option value="">Seleccionar...</option>
                            <?php
                              $barrio=mysqli_query($conex_dbseg," SELECT * FROM dbseg.ref_barrio;")
                                                or  die("Problemas con el select Barrio: ".mysqli_error($conex_dbseg));

                              $row_barrio=mysqli_fetch_array($barrio);
                              do {?>
                                <option value="<?php
                                    echo $row_barrio['Barrio_Codigo'];
                                  ?>">
                                <?php echo utf8_encode($row_barrio['Barrio_Descrip']); ?>
                              </option>
                            <?php } while ($row_barrio=mysqli_fetch_array($barrio));?>

                        </select>
                      </td>

                      <td>&nbsp; &nbsp;</td>
                      <td>Localidad</td>
                      <td>
                        <select type="text" class="select" name="SURC_DomiciliosPers_IdLocalida">
                            <option value="">Seleccionar...</option>
                            <?php
                              $localidad=mysqli_query($conex_dbseg," SELECT * FROM dbseg.ref_localidad;")
                                                or  die("Problemas con el select Localidad: ".mysqli_error($conex_dbseg));

                              $row_localidad=mysqli_fetch_array($localidad);
                              do {?>
                                <option value="<?php
                                    echo $row_localidad['Localidad_Codigo'];
                                  ?>">
                                <?php echo utf8_encode($row_localidad['Localidad_Descrip']); ?>
                              </option>
                            <?php } while ($row_localidad=mysqli_fetch_array($localidad));?>

                        </select>
                      </td>

                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Provincia</td>
                      <td>
                        <select type="text" class="select" name="SURC_DomiciliosPers_IdProvinci">
                            <option value="">Seleccionar</option>
                            <?php

                            $provincia=mysqli_query($conex_dbseg," SELECT * FROM dbseg.ref_provincia;")
                                              or  die("Problemas con el select nacionalidad: ".mysqli_error($conex_dbseg));

                            $row_provincia=mysqli_fetch_array($provincia);
                            do {?>
                              <option value="<?php
                                  echo $row_provincia['Provincia_Codigo'];
                                ?>">
                              <?php echo utf8_encode($row_provincia['Provincia_Descrip']); ?>
                            </option>
                          <?php } while ($row_provincia=mysqli_fetch_array($provincia))?>

                        </select>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Pais</td>
                      <td>
                        <select type="text" class="select" name="SURC_DomiciliosPers_IdPais">
                            <option value="">Seleccionar</option>
                            <?php

                            $pais=mysqli_query($conex_dbseg," SELECT * FROM dbseg.ref_nacionalidad;")
                                              or  die("Problemas con el select nacionalidad: ".mysqli_error($conex_dbseg));

                            $row_pais=mysqli_fetch_array($pais);
                            do {?>
                              <option value="<?php
                                  echo $row_pais['Nac_Codigo'];
                                ?>">
                              <?php echo utf8_encode($row_pais['Nac_Descrip']); ?>
                            </option>
                          <?php } while ($row_pais=mysqli_fetch_array($pais))?>

                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>Dependencia Policial</td>
                      <td>
                        <select type="text" class="select" name="SURC_DomiciliosPers_IdDependen">
                            <option value="">Seleccionar</option>
                            <?php

                            $dependencia=mysqli_query($conex_dbseg," SELECT * FROM dbseg.ref_dependencias;")
                                              or  die("Problemas con el select nacionalidad: ".mysqli_error($conex_dbseg));

                            $row_dependencia=mysqli_fetch_array($dependencia);
                            do {?>
                              <option value="<?php
                                  echo $row_dependencia['DepPol_Codigo'];
                                ?>">
                              <?php echo utf8_encode($row_dependencia['DepPol_Descrip']); ?>
                            </option>
                          <?php } while ($row_dependencia=mysqli_fetch_array($dependencia))?>

                        </select>
                      </td>
                      <td>&nbsp; &nbsp;</td>
                      <td>Observaciones</td>
                      <td>
                        <textarea name="SURC_DomiciliosPers_Observacio" rows="3" style="overflow-y:scroll; min-width:100%; text-align:justify; text-transform:uppercase;"></textarea>
                      </td>

                    </tr>

                    <table class="plus conmargen">
                        <tr>
                          <td>  <b>Ubicación Domicilio</b>
                          </td>
                        </tr>
                        <tr>
                            <td>Latitud (Coordenada "X")</td>
                            <td>
                              <input type="text" name="SURC_DomiciliosPers_CoordX" class="w18" id="lat" value="" readonly>
                            </td>
                            <td><br><br></td>
                            <td>Longitud (Coordenadas "Y")</td>
                            <td>
                              <input type="text" name="SURC_DomiciliosPers_CoordY" class="w18" id="lng" value="" readonly>
                            </td>

                        </tr>

                    </table>
                    <table class="plus conmargen" style="width:50%;">
                        <tr>
                          <td>

                              <?php include 'maptiler_upd_dlio.php'; ?>

                          </td>
                        </tr>
                    </table>

                  </table>

                  </table>




        </form>


      </div>



    </article>
    <form class="" action="surc_personas_ins.php" id="salir" method="post">
        <input type="hidden" name="SURC_Persona_Id" value="<?php echo $_SESSION['persona_id']; ?>">
        <input type="hidden" name="SURC_Persona_Documento" value="<?php echo $_SESSION['SURC_Persona_Documento']; ?>">
        <input type="hidden" name="vienede" value="alta_per">

    </form>


  </section>

    <div id="footer"><?php include ('footer.php');?></div>
  </html>
