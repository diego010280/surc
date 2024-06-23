<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/estilomap.css">
    <!-- <script src="js/map.js"></script> -->

  </head>
  <body>
    <form class="" action="sum_d_gral_upd.php" method="post">
      <table ALIGN="right">
        <tr>
          <td>

            <button type="submit" name="btn_guardar_gral_upd" value="Guardar Cambios" class="btnguardar" formaction="update_gral.php"><span class="soloimagen">Guardar Cambios</span></button>

            </td>
          <td>
                <button type="submit" name="btn_cancelar_gral_upd" value="Cancelar" class="btncancelar" formaction="sum_d_upd.php"><span class="soloimagen">Cancelar</span></button>
          </td>
        </tr>
      </table>
      <table class="plus conmargen">
        <tr>
            <td>
                <b> Datos del Sumario </b>
                <br>
            </td>
        </tr>
      </table>
    <table class="plus conmargen">

        <tr>
          <td>Fecha Sum.</td>
          <td>Hora Sum.</td>
          <td>Nro.Sum. (M.P.)</td>
          <td>Año</td>
          <td>Nro. XML</td>
          <td>Origen Sumario</td>
          <td>Tipo Sumario </td>
        </tr>
        <tr>
          <td> <input type="text" name="SURC_Sumario_FechaSum" maxlength="12" class="w5" value="<?= date("d-m-Y",strtotime($row_sumarios['Fecha_Carga'])) ?>" readonly> </td>
          <td> <input type="text" name="SURC_Sumario_HoraSum" class="w4" value="<?php if (!empty($row_sumarios['Hora_Carga'])) {
              echo date('H:i:s',strtotime("$row_sumarios[Hora_Carga] - 3 hours"));}?>" readonly> </td>
          <td> <input type="text" name="SURC_Sumario_NroSumMP" class="wchico" value="<?= $row_sumarios['NroSumario_MP'] ?>" > </td>
          <td> <input type="number" name="SURC_Sumario_Anio" maxlength="4" style="width:60px" value="<?= $row_sumarios['Anio'] ?>" > </td>
          <td> <input type="text" name="SURC_Sumario_NroDenunciaMP" class="wchico"value="<?= $row_sumarios['xml'] ?>" readonly> </td>
          <td>
              <select type="text" class="select" name="SURC_OrigenSumario_Id" >
                              <option value="">Ninguno</option>
                              <?php
                              $orig_sum= mysqli_query($conex_surc,"SELECT * FROM `surc_origensumario`
							  order by SURC_OrigenSumario_Descrip")
                              or  die("Problemas con el select origen sumario : ".mysqli_error($conex_surc));
                              $row_origsum= mysqli_fetch_array($orig_sum);

                              do {?>
                                <option value="<?php echo $row_origsum['SURC_OrigenSumario_Id'];
                                    ?>" <?php if (isset( $row_sumarios['Id_origen']) and $row_sumarios['Id_origen']==$row_origsum['SURC_OrigenSumario_Id']) {
                                  echo 'selected';
                                  }?>>
                                  <?php echo utf8_encode ($row_origsum['SURC_OrigenSumario_Descrip']) ?>


                                </option>
                              <?php  } while ($row_origsum= mysqli_fetch_array($orig_sum)); ?>

            </select>

                      </td>
          <td>
            <select type="text" class="select" name="SURC_TipoSum_Id" >
                              <option value="">Ninguno</option>
                                  <?php
                                    $tipo_sum= mysqli_query ($conex_surc, "SELECT * FROM `surc_tiposum`
									order by SURC_TipoSum_Descrip")
                                    or  die("Problemas con el select tipo sumario : ".mysqli_error($conex_surc));
                                    $row_tiposum = mysqli_fetch_array($tipo_sum);

                                  do { ?>
                                      <option value="<?php
                                            echo $row_tiposum['SURC_TipoSum_Id'];
                                               ?>" <?php if ( isset($row_sumarios['Id_Tipo_Sumario']) and $row_sumarios['Id_Tipo_Sumario']==$row_tiposum['SURC_TipoSum_Id'] ) {
                                        echo 'selected';
                                    } ?>>
                                      <?php echo utf8_encode ($row_tiposum['SURC_TipoSum_Descrip']) ?>

                                    </option>

                            <?php } while ($row_tiposum = mysqli_fetch_array($tipo_sum)); ?>
            </select>



        </tr>

    </table>
    <table class="plus conmargen">
      <tr>
        <td>Clasificación Delito SURC (M.P.)</td>

        <?php if (!empty($row_caratula['surc_caratulas_desc'])) {?>
          <td style="color:red;">Delitos del XML (M.P.) para tener en cuenta</td>
      <?php  } ?>

      </tr>
      <tr>
        <td> <input type="text" name="SURC_TipoDelito_Descripc" class="w18" value="<?= utf8_encode($row_sumarios['Caratula']) ?>" readonly> </td>

        <?php if (!empty($row_caratula['surc_caratulas_desc'])) {?>
          <td>
            <input type="text" name="" style="color:red;" class="w50" value="<?= utf8_encode($row_caratula['surc_caratulas_desc']) ?>"readonly>
          </td>
      <?php  } ?>

      </tr>
    </table>

    <table class="plus conmargen">
      <tr>
        <td>Dependencia Policial</td>
        <td>Fiscalía</td>

      </tr>

      <tr>
        <td>
          <select type="text" class="select" name="DepPol_Codigo" >
                          <option value="">Ninguno</option>
                          <?php
                          $dependencia=mysqli_query($conex_dbseg,"SELECT * FROM ref_dependencias")
                          or  die("Problemas con el select de dependencia : ".mysqli_error($conex_dbseg));
                          $row_depen=mysqli_fetch_array($dependencia);

                          do {?>
                            <option value="<?php
                                              echo $row_depen['DepPol_Codigo'];
                                ?>" <?php if (isset( $row_sumarios['Id_deppol_codigo']) and $row_sumarios['Id_deppol_codigo']==$row_depen['DepPol_Codigo']) {
                              echo 'selected';
                              }?>>
                              <?php echo utf8_encode($row_depen['DepPol_Descrip']) ?>


                            </option>
                          <?php  } while (  $row_depen=mysqli_fetch_array($dependencia)); ?>

        </select>


        </td>

        <td>
          <input type="text" list="juzgado" name="SURC_JuzgadoFiscalia_Id" class="w21" value="<?php if (!empty($row_sumarios['Id_Fiscalia'])) {
            echo $row_sumarios['Id_Fiscalia'].' '.utf8_encode($row_sumarios['Fiscalia']);
          } else {
            echo "";
          } ?>" onclick="this.select()" size="35" placeholder="Seleccionar">
          <?php
            echo '<datalist id="juzgado">';
            $juzgado=mysqli_query($conex_surc,"SELECT * FROM surc.surc_juzgadofiscalia")
                    or  die("Problemas con el select de juzgado/fiscalia : ".mysqli_error($conex_surc));
            $row_juzgado=mysqli_fetch_array($juzgado);

            do {?>
              <option value="<?php echo $row_juzgado['SURC_JuzgadoFiscalia_Id'].' '.utf8_encode($row_juzgado['SURC_JuzgadoFiscalia_Descrip']) ?>"></option>
            <?php } while ($row_juzgado=mysqli_fetch_array($juzgado)); ?>


        </td>
      </tr>
    </table>

    <table class="plus conmargen">
      <tr>
        <td> <b>Datos del Hecho</b>
              <br>
        </td>
      </tr>
    </table>

    <table class="plus conmargen">
      <tr>
        <td>Fecha Delito</td>
        <td>Hora Delito</td>
        <td>Lugar de Ocurrencia</td>
        <td>Nomb. Calle</td>
        <td>Alt. Calle</td>
        <td>Piso</td>
        <td>Dpto.</td>
        <td>Mza.</td>
        <td>Lote</td>
      </tr>
      <tr>
        <td> <input type="date" name="SURC_Sumario_FechaDel" class="w8" value="<?= $row_sumarios['Fecha_Delito'] ?>"> </td>
        <td> <input type="time" name="SURC_Sumario_HoraDel" class="w5" value="<?php if (!empty($row_sumarios['Hora_Delito'])) {
            echo date('H:i',strtotime("$row_sumarios[Hora_Delito] - 3 hours"));}?>"> </td>
        <td>

          <select type="text" class="select" name="SURC_Sumario_IdLugar" required >
                            <option value="">Seleccione...</option>
                                <?php
                                $surc_lugares=mysqli_query($conex_surc," SELECT * FROM surc.surc_lugares
								order by SURC_Lugar_Descrip;")
                                                  or  die("Problemas con el select tipo lugar hecho: ".mysqli_error($conex_surc));

                                $row_surc_lugares=mysqli_fetch_array($surc_lugares);

                                do { ?>
                                    <option value="<?php echo $row_surc_lugares['SURC_Lugar_Id']; ?>"
                                      <?php if ( isset($row_sumarios['Id_Lugar_Hecho']) and $row_sumarios['Id_Lugar_Hecho']==$row_surc_lugares['SURC_Lugar_Id'] ) {
                                      echo 'selected';
                                  } ?>>
                                    <?php echo utf8_encode($row_surc_lugares['SURC_Lugar_Descrip']) ?>

                                    </option>

                          <?php } while ($row_surc_lugares=mysqli_fetch_array($surc_lugares));?>
          </select>
        </td>




        <td> <input type="text" name="SURC_Sumario_NomCalle" style="text-transform:uppercase;" class="w21" value="<?= utf8_encode($row_sumarios['Nom_Calle']) ?>" > </td>
        <td> <input type="number" name="SURC_Sumario_AltCalle" class="wchico" value="<?= $row_sumarios['Alt_Calle'] ?>" > </td>
        <td> <input type="text" name="SURC_Sumario_Piso" style="text-transform:uppercase;" class="wchico" value="<?= $row_sumarios['Piso'] ?>" > </td>
        <td> <input type="text" name="SURC_Sumario_Dpto" style="text-transform:uppercase;" class="wchico" value="<?= $row_sumarios['Dpto'] ?>" > </td>
        <td> <input type="text" name="SURC_Sumario_Mza" style="text-transform:uppercase;" class="wchico" value="<?= $row_sumarios['Mza'] ?>" > </td>
        <td> <input type="text" name="SURC_Sumario_CasaLote" style="text-transform:uppercase;" class="wchico" value="<?= $row_sumarios['lote'] ?>" > </td>
      </tr>

    </table>
    <table class="plus conmargen">
      <tr>
        <td>Localidad</td>
        <td>Barrio</td>
        <td>Cuadrícula</td>
      </tr>
      <tr>
        <td>
          <input type="text" list="idlocalidad" id="id_localidad" name="Localidad_Codigo" class="w18" autocomplete="off" value="<?php if (!empty($row_sumarios['Id_localidad'])) {
        echo $row_sumarios['Id_localidad'].' '.utf8_encode($row_sumarios['Localidad']);
        } else {
          echo "";
        }?>" onclick="this.select()" size="35" placeholder="Seleccionar">

        <?php
          echo '<datalist id="idlocalidad">';
          $localidad=mysqli_query($conex_dbseg,"SELECT * FROM dbseg.ref_localidad
                     order by Localidad_Descrip;")
                  or  die("Problemas con el select de localidad :".mysqli_error($conex_dbseg));
          $row_localidad=mysqli_fetch_array($localidad);

          do {?>
            <option value="<?php echo $row_localidad['Localidad_Codigo'].' '.utf8_encode($row_localidad['Localidad_Descrip']) ?>"></option>
          <?php } while ($row_localidad=mysqli_fetch_array($localidad)); ?>

         ?>

        </td>

        <td>

            <input type="text" list="idbarrios" name="Barrio_Codigo" id="barrios_id" autocomplete="off" value="<?php if (!empty($row_sumarios['Id_Barrio'])) {
              echo $row_sumarios['Id_Barrio'].' '.utf8_encode($row_sumarios['Barrio']);
            }else {
              echo "";
            } ?>" size="45" placeholder="Seleccionar...">
            <?php
              echo '<datalist id="idbarrios">';
              $barrio=mysqli_query($conex_dbseg,"SELECT * FROM dbseg.ref_barrio  WHERE Localidad_Codigo = '$row_sumarios[Id_localidad]'
                order by Barrio_Descrip;") or die("Problemas con el select de barrio: ".mysqli_error($conex_dbseg));
              $row_barrio=mysqli_fetch_array($barrio);

              do {?>
              <option value="<?php echo $row_barrio['Barrio_Codigo']." ".utf8_encode($row_barrio['Barrio_Descrip']); ?>"></option>
            <?php  } while ($row_barrio=mysqli_fetch_array($barrio));
                echo '</datalist>';
             ?>


        </td>

        <td>
          <select type="text" class="select" name="SURC_Cuadriculas_Id" >
                            <option value="">Ninguno</option>
                                <?php
                                $cuadricula=mysqli_query($conex_surc," SELECT * FROM surc.surc_cuadriculas")
                                                  or  die("Problemas con el select cuadricula : ".mysqli_error($conex_surc));

                                $row_cuadricula=mysqli_fetch_array($cuadricula);

                                do { ?>
                                    <option value="<?php echo $row_cuadricula['SURC_Cuadriculas_Id']; ?>"
                                      <?php if ( isset($row_sumarios['Id_Cuadricula']) and $row_sumarios['Id_Cuadricula']==$row_cuadricula['SURC_Cuadriculas_Id'] ) {
                                      echo 'selected';
                                  } ?>>
                                    <?php echo utf8_encode($row_cuadricula['SURC_Cuadriculas_Descrip']) ?>

                                    </option>

                          <?php } while ($row_cuadricula=mysqli_fetch_array($cuadricula));?>
          </select>
          </td>

      </tr>
    </table>


    <table class="plus conmargen" style="width:100%;">
      <tr>
        <td>Texto o Relato</td>
      </tr>
      <tr>
        <td> <textarea name="SURC_Sumario_TextoRelato" rows="10" style="overflow-y:scroll; min-width:100%; text-align:justify;text-transform:uppercase;"><?= utf8_encode($row_sumarios['Descrip_Hecho']) ?></textarea> </td>
      </tr>
    </table>

    <?php if ($num_row_ampliacion>0) {?>
      <table class="plus conmargen" style="width:100%;">
        <tr>
          <td><b>Ampliaciones Realizadas</b></td>
        </tr>
      </table>
        <?php include 'sum_d_ampl_dsp.php'; ?>
    <?php } else {?>
      <table class="plus conmargen">
        <tr>
          <td><b>Ampliaciones Realizadas</b></td>

        </tr>
        <tr>
          <td>
              <input type="text" name="" class="w21" value="No se registraron ampliaciones..." readonly>

          </td>
        </tr>
      </table>
    <?php } ?>

    <table class="plus conmargen">
        <tr>
          <td>  <b>Ubicación</b>
          </td>
        </tr>
        <tr>
            <td>Latitud (Coordenada "X")</td>
            <td>
              <input type="text" name="SURC_Sumario_CoordX" class="w18" id="lat" value="<?= utf8_encode($row_sumarios['Coord_X']) ?>" readonly>
            </td>
            <td><br><br></td>
            <td>Longitud (Coordenadas "Y")</td>
            <td>
              <input type="text" name="SURC_Sumario_CoordY" class="w18" id="lng" value="<?= utf8_encode($row_sumarios['Coord_Y']) ?>" readonly>
            </td>

        </tr>

    </table>
    <table class="plus conmargen" style="width:50%;">
        <tr>
          <td>
              <!-- <img src="imagenes/sin_mapa.png" alt=""> -->
              <?php include 'maptiler_upd.php'; ?>

          </td>
        </tr>
    </table>

    </form>

  </body>
</html>
