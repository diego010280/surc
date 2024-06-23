<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/estilomap.css">
    <script src="js/hora.js?v=2.0.126"></script>
    <!-- <script src="js/map.js"></script> -->

  </head>
  <body>
    <form class="" action="sum_d_gral_ins.php" method="POST">
      <table ALIGN="right">
        <tr>
          <td>

            <button type="submit" name="btn_guardar_gral_upd" value="Guardar Cambios" class="btnguardar" formaction="insertar_gral.php"><span class="soloimagen">Guardar Cambios</span></button>

            </td>
          <td>
                <button type="submit" name="btn_cancelar_gral_upd" value="Cancelar" class="btncancelar" form="actualizar"><span class="soloimagen">Cancelar</span></button>
          </td>
        </tr>
      </table>
      <table class="plus conmargen">
        <tr>
            <td>
                <b>Datos del Sumario</b>
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
          <td> <input type="text" name="SURC_Sumario_FechaSum" maxlength="12" class="w5" value=
            "<?php
                if (!empty($row_sumarios['Fecha_Carga'])){
                  echo date("d-m-Y",strtotime($row_sumarios['Fecha_Carga']));
          }else{
              echo date("d-m-Y");
          }?> " readonly> </td>

        <td>
          <input type="text" name="SURC_Sumario_HoraSum" class="w4" value="<?php if (!empty($row_sumarios['Hora_Carga'])) {
              echo date('H:i:s',strtotime("$row_sumarios[Hora_Carga] - 3 hours"));
              }else{
                echo date('H:i:s');
              }?>" readonly>
        </td>

          <td> <input type="text" name="SURC_Sumario_NroSumMP" autocomplete="off" class="w8" value="<?php
                if (!empty($row_sumarios['NroSumario_MP'])) {
                  echo $row_sumarios['NroSumario_MP'];
                }
             ?>" required ></td>

          <td> <input type="number" name="SURC_Sumario_Anio" maxlength="4" style="width:60px" value="<?php if (!empty($row_sumarios['Anio'])) {
          echo $row_sumarios['Anio'];}else {
            echo date('Y');
          }?>">
         </td>

         <td> <input type="text" name="SURC_Sumario_NroDenunciaMP" class="wchico" value=""  readonly> </td>
          <td>
              <select type="text" class="select" name="SURC_OrigenSumario_Id" required >
                              <option value="">Ninguno</option>
                              <?php
                              $orig_sum= mysqli_query($conex_surc,"SELECT * FROM `surc_origensumario`")
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
            <select type="text" class="select" name="SURC_TipoSum_Id" required>
                              <option value="">Ninguno</option>
                                  <?php
                                    $tipo_sum= mysqli_query ($conex_surc, "SELECT * FROM `surc_tiposum` ")
                                    or  die("Problemas con el select tipo sumario : ".mysqli_error($conex_surc));
                                    $row_tiposum = mysqli_fetch_array($tipo_sum);

                                  do { ?>
                                      <option value="<?php
                                            echo $row_tiposum['SURC_TipoSum_Id'];
                                               ?>">
                                      <?php echo utf8_encode ($row_tiposum['SURC_TipoSum_Descrip']) ?>

                                    </option>

                            <?php } while ($row_tiposum = mysqli_fetch_array($tipo_sum)); ?>
            </select>



        </tr>

    </table>
    <table class="plus conmargen">
      <tr>
        <td>Clasificación Delito SURC (M.P.)</td>

      </tr>

      <tr>
        <td>

          <input type="text" list="delitos" name="SURC_Sumario_IdTipoDelitoMP" class="w21" value="" onclick="this.select()" size="35" placeholder="Seleccionar" autocomplete="off" required>
          <?php
          echo '<datalist id="delitos">';
          $tipo_delito= mysqli_query ($conex_surc, "SELECT * FROM surc.surc_tipodelito;")
          or  die("Problemas con el select tipo delito: ".mysqli_error($conex_surc));
          $row_tipo_delito = mysqli_fetch_array($tipo_delito);

          do {?>
              <option value="<?php echo $row_tipo_delito['SURC_TipoDelito_Id'].' '.utf8_encode($row_tipo_delito['SURC_TipoDelito_Descripc'])?>"></option>
      <?php } while ($row_tipo_delito = mysqli_fetch_array($tipo_delito));

           ?>


        </td>

      </tr>

    </table>



    <table class="plus conmargen">
      <tr>
        <td>Dependencia Policial</td>
        <td>Fiscalía</td>

      </tr>

      <tr>
        <td>
          <input type="text" list="depend" name="DepPol_Codigo" value="" class="w21" onclick="this.select()" size="35" placeholder="Seleccionar" required autocomplete="off">

          <?php
            echo '<datalist id="depend">';
            $dependencia=mysqli_query($conex_dbseg,"SELECT * FROM ref_dependencias WHERE DepPol_Codigo>0")
            or  die("Problemas con el select de dependencia : ".mysqli_error($conex_dbseg));
            $row_depen=mysqli_fetch_array($dependencia);

            do {?>
              <option value="<?php echo $row_depen['DepPol_Codigo'].' '.utf8_encode($row_depen['DepPol_Descrip'])?>"></option>
          <?php     } while ($row_depen=mysqli_fetch_array($dependencia));


           ?>

        </td>

        <td>
          <input type="text" list="juzgado" name="SURC_JuzgadoFiscalia_Id" class="w21" value="" onclick="this.select()" size="35" placeholder="Seleccionar" required autocomplete="off">
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
        <td id="tit_horaimprecisa" 
        <?php
          if (!empty($row_sumarios['Hora_Delito'])) {
           echo 'class="hide"';
          }
        ?> 
        >Hora Imprecisa</td>
      </tr>
      <tr>
          <td> <input type="date" name="SURC_Sumario_FechaDel" class="w8" value="" required autocomplete="off"> </td>
          <td> <input type="time" name="SURC_Sumario_HoraDel" class="w5" value=""> </td>
          
          <td id="val_horaimprecisa" 
            <?php
              if (!empty($row_sumarios['Hora_Delito'])) {
              echo 'class="hide"';
              }
            ?> 
            >
            <select type="text" name="SURC_Sumario_horaimpr" id="select_horaimprecisa">
                <option value="">Seleccione...</option>
                <option value="1">Mañana</option>
                <option value="2">Tarde</option>
                <option value="3">Noche</option>
            </select>
        </td>

      </tr>
    </table>
    <table class="plus conmargen">
      <tr>
        <td>Lugar de Ocurrencia</td>
        <td>Nomb. Calle</td>
        <td>Alt. Calle</td>
        <td>Piso</td>
        <td>Dpto.</td>
        <td>Mza.</td>
        <td>Lote</td>
      </tr>
      <tr>
       
        <td>

          <select type="text" class="select" name="SURC_Sumario_IdLugar" required >
                            <option value="">Seleccione...</option>
                                <?php
                                $surc_lugares=mysqli_query($conex_surc," SELECT * FROM surc.surc_lugares;")
                                                  or  die("Problemas con el select tipo lugar hecho: ".mysqli_error($conex_surc));

                                $row_surc_lugares=mysqli_fetch_array($surc_lugares);

                                do { ?>
                                    <option value="<?php echo $row_surc_lugares['SURC_Lugar_Id']; ?>"
                                      >
                                    <?php echo utf8_encode($row_surc_lugares['SURC_Lugar_Descrip']) ?>

                                    </option>

                          <?php } while ($row_surc_lugares=mysqli_fetch_array($surc_lugares));?>
          </select>
        </td>




        <td> <input type="text" name="SURC_Sumario_NomCalle" style="text-transform:uppercase;" class="w21" value="" autocomplete="off"> </td>
        <td> <input type="number" name="SURC_Sumario_AltCalle" class="wchico" value="" > </td>
        <td> <input type="text" name="SURC_Sumario_Piso" style="text-transform:uppercase;" class="wchico" value="" autocomplete="off"> </td>
        <td> <input type="text" name="SURC_Sumario_Dpto" style="text-transform:uppercase;" class="wchico" value="" autocomplete="off"> </td>
        <td> <input type="text" name="SURC_Sumario_Mza" style="text-transform:uppercase;" class="wchico" value="" autocomplete="off"> </td>
        <td> <input type="text" name="SURC_Sumario_CasaLote" style="text-transform:uppercase;" class="wchico" value="" autocomplete="off"> </td>
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
          <input type="text" list="idlocalidad" id="id_localidad" name="Localidad_Codigo" autocomplete="off" class="w18" value="" onclick="this.select()" size="35" placeholder="Seleccionar" required>

        <?php
          echo '<datalist id="idlocalidad">';
          $localidad=mysqli_query($conex_dbseg,"SELECT * FROM dbseg.ref_localidad;")
                  or  die("Problemas con el select de localidad :".mysqli_error($conex_dbseg));
          $row_localidad=mysqli_fetch_array($localidad);

          do {?>
            <option value="<?php echo $row_localidad['Localidad_Codigo'].' '.utf8_encode($row_localidad['Localidad_Descrip']) ?>"></option>
          <?php } while ($row_localidad=mysqli_fetch_array($localidad)); ?>

         ?>

        </td>

        <td>

            <input type="text" list="idbarrios" name="Barrio_Codigo" autocomplete="off" id="barrios_id" value="" size="45" placeholder="Seleccionar...">


        </td>

        <td>
          <select type="text" class="select" name="SURC_Cuadriculas_Id" >
                            <option value="">Ninguno</option>
                                <?php
                                $cuadricula=mysqli_query($conex_surc," SELECT * FROM surc.surc_cuadriculas")
                                                  or  die("Problemas con el select cuadricula : ".mysqli_error($conex_surc));

                                $row_cuadricula=mysqli_fetch_array($cuadricula);

                                do { ?>
                                    <option value="<?php echo $row_cuadricula['SURC_Cuadriculas_Id']; ?>">
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
        <td> <textarea name="SURC_Sumario_TextoRelato" rows="10" style="overflow-y:scroll; min-width:100%; text-align:justify;text-transform:uppercase;"></textarea> </td>
      </tr>
    </table>

    <table class="plus conmargen">
        <tr>
          <td>  <b>Ubicación</b>
          </td>
        </tr>
        <tr>
            <td>Latitud (Coordenada "X")</td>
            <td>
              <input type="text" name="SURC_Sumario_CoordX" class="w18" id="lat" value=""  readonly>
            </td>
            <td><br><br></td>
            <td>Longitud (Coordenadas "Y")</td>
            <td>
              <input type="text" name="SURC_Sumario_CoordY" class="w18" id="lng" value=""  readonly>
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

    <form class="" action="sum_d_ins.php" id="actualizar" method="post">

    </form>

  </body>
</html>
