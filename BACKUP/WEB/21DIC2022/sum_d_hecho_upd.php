<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

<form class="" action="sum_d_hecho_upd.php" method="post">

    <table class="plus conmargen">
        <tr>
            <td>
                <b>Datos del Hecho Delictivo</b>
                <br>
            </td>
        </tr>
    </table>


      <table class="plus conmargen">
        <tr>
          <td>Hecho Delictivo</td>
          <td>

            <select type="text" class="select" name="SURC_Sumario_IdHechoDel" >
                  <option value="">Seleccionar</option>
                  <?php

                          $hechodelictivo=mysqli_query($conex_surc," SELECT * FROM surc.surc_hechodelictivo
										ORDER BY SURC_HechoDelictivo_Descrip;")
                                            or  die("Problemas con el select hecho delictivo: ".mysqli_error($conex_surc));

                          $row_hechodelictivo=mysqli_fetch_array($hechodelictivo);
                                            do {?>
                                              <option value="<?php
                                                  echo $row_hechodelictivo['SURC_HechoDelictivo_Id'];
                                                ?>" <?php if (isset($row_sumarios['Id_Hechodelictivo']) and
                                              $row_sumarios['Id_Hechodelictivo']==$row_hechodelictivo['SURC_HechoDelictivo_Id']) {
                                                echo 'selected';
                                              } ?>>
                                              <?php echo utf8_encode($row_hechodelictivo['SURC_HechoDelictivo_Descrip']); ?>
                                            </option>
                                            <?php } while ($row_hechodelictivo=mysqli_fetch_array($hechodelictivo));?>




            </select>

          </td>

        </tr>
        <tr>
          <td>Tentativa</td>
          <td>
            <input type="checkbox" name="SURC_Sumario_Tentativa" value="tentativa" <?php if (!empty($row_sumarios['tentativa'])) {
              if ($row_sumarios['tentativa']=="S") {
                echo 'checked';
              }
            } ?>>
          </td>
        </tr>
        <tr>
          <td>Violencia Familiar (VIF)</td>
          <td>
            <input type="checkbox" name="SURC_HechoDelictivo_VIF" value="vif" <?php if (!empty($row_sumarios['hechodelictivo_vif'])) {
              if ($row_sumarios['hechodelictivo_vif']=="S") {
                echo 'checked';
              }
            } ?> >
          </td>

        </tr>
        <tr>
          <td>Violencia de Genero(VG)</td>
          <td>
            <input type="checkbox" name="SURC_Sumario_ViolGenero" value="vg" <?php if (!empty($row_sumarios['SURC_Sumario_ViolGenero'])) {
              if ($row_sumarios['SURC_Sumario_ViolGenero']=="S") {
                echo 'checked';
              }
            } ?> >
          </td>

        </tr>
        <tr>
          <td>Arma o Mecanismo</td>
          <td>

            <select type="text" class="select" name="SURC_Sumario_IdArmaMec">
                <option value="">Seleccionar</option>
                <?php
                        $armamecanismo=mysqli_query($conex_surc," SELECT * FROM surc.surc_armamecanismo
										ORDER BY SURC_ArmaMecanismo_Descrip;")
                                          or  die("Problemas con el select arca mecanismo: ".mysqli_error($conex_surc));

                        $row_armamecanismo=mysqli_fetch_array($armamecanismo);
                                          do {?>
                                            <option value="<?php
                                                  echo $row_armamecanismo['SURC_ArmaMecanismo_Id'];
                                                  ?>" <?php if (isset($row_sumarios['Id_armamec']) and
                                                  $row_sumarios['Id_armamec']==$row_armamecanismo['SURC_ArmaMecanismo_Id']) {
                                                    echo 'selected';
                                                  } ?>>
                                                  <?php echo utf8_encode($row_armamecanismo['SURC_ArmaMecanismo_Descrip']); ?>
                                            </option>
                                          <?php } while ($row_armamecanismo=mysqli_fetch_array($armamecanismo));?>




            </select>
          </td>
        </tr>
        <td>Modalidad Delictiva</td>
        <td>

          <select type="text" class="select" name="SURC_Sumario_IdModalidad" >
          <option value="">Seleccionar</option>
          <?php

                  $surc_modalidad=mysqli_query($conex_surc," SELECT * FROM surc.surc_modalidad
									ORDER BY SURC_Modalidad_Descrip;")
                                    or  die("Problemas con el select modalidad: ".mysqli_error($conex_surc));

                  $row_surc_modalidad=mysqli_fetch_array($surc_modalidad);
                                    do {?>
                                      <option value="<?php
                                            echo $row_surc_modalidad['SURC_Modalidad_Id'];
                                      ?>" <?php if (isset($row_sumarios['Id_modalidad']) and
                                      $row_sumarios['Id_modalidad']==$row_surc_modalidad['SURC_Modalidad_Id']) {
                                        echo 'selected';
                                      } ?>>
                                      <?php echo utf8_encode($row_surc_modalidad['SURC_Modalidad_Descrip']); ?>
                                    </option>
                                    <?php } while ($row_surc_modalidad=mysqli_fetch_array($surc_modalidad));?>




          </select>
        </td>
        <tr>
          <td>Forma Acción</td>
          <td>


            <select type="text" class="select" name="SURC_Sumario_IdFormaAcc" >
            <option value="">Seleccionar</option>
            <?php

                    $surc_formaaccion=mysqli_query($conex_surc," SELECT * FROM surc.surc_formaaccion;")
                                      or  die("Problemas con el select forma accion: ".mysqli_error($conex_surc));

                    $row_surc_formaaccion=mysqli_fetch_array($surc_formaaccion);
                                      do {?>
                                        <option value="<?php
                                              echo $row_surc_formaaccion['SURC_FormaAccion_Id'];
                                          ?>" <?php if (isset($row_sumarios['Id_formaacc']) and
                                        $row_sumarios['Id_formaacc']==$row_surc_formaaccion['SURC_FormaAccion_Id']) {
                                          echo 'selected';
                                        } ?>>
                                        <?php echo utf8_encode($row_surc_formaaccion['SURC_FormaAccion_Descrip']); ?>
                                      </option>
                                      <?php } while ($row_surc_formaaccion=mysqli_fetch_array($surc_formaaccion));?>




            </select>

          </td>
        </tr>
        <tr>
          <td>Modo Producción</td>
          <td>


            <select type="text" class="select" name="SURC_ModoProduccion_Id" >
            <option value="">Seleccionar</option>
            <?php

                    $surc_modoproduccion=mysqli_query($conex_surc," SELECT * FROM surc.surc_modoproduccion
					ORDER BY SURC_ModoProduccion_Descrip;")
                                      or  die("Problemas con el select modo produccion: ".mysqli_error($conex_surc));

                    $row_surc_modoproduccion=mysqli_fetch_array($surc_modoproduccion);
                                      do {?>
                                        <option value="<?php
                                            echo $row_surc_modoproduccion['SURC_ModoProduccion_Id'];
                                          ?>" <?php if (isset($row_sumarios['Id_modoprod']) and
                                        $row_sumarios['Id_modoprod']==$row_surc_modoproduccion['SURC_ModoProduccion_Id']) {
                                          echo 'selected';
                                        } ?>>
                                        <?php echo utf8_encode($row_surc_modoproduccion['SURC_ModoProduccion_Descrip']); ?>
                                      </option>
                                      <?php } while ($row_surc_modoproduccion=mysqli_fetch_array($surc_modoproduccion));?>




            </select>


          </td>
        </tr>
        <tr>
          <td>Condición Climática</td>
          <td>


            <select type="text" class="select" name="SURC_Sumario_IdCondClim">
            <option value="">Seleccionar</option>
            <?php

                    $surc_condclimatica=mysqli_query($conex_surc,"SELECT * FROM surc.surc_condclimatica
										ORDER BY SURC_CondClimatica_Descrip;")
                                      or  die("Problemas con el select condicion climatica: ".mysqli_error($conex_surc));

                    $row_surc_condclimatica=mysqli_fetch_array($surc_condclimatica);
                                      do {?>
                                        <option value="<?php
                                                echo $row_surc_condclimatica['SURC_CondClimatica_Id'];
                                          ?>" <?php if (isset($row_sumarios['Id_condclim']) and
                                        $row_sumarios['Id_condclim']==$row_surc_condclimatica['SURC_CondClimatica_Id']) {
                                          echo 'selected';
                                        } ?>>
                                        <?php echo utf8_encode($row_surc_condclimatica['SURC_CondClimatica_Descrip']); ?>
                                      </option>
                                      <?php } while (  $row_surc_condclimatica=mysqli_fetch_array($surc_condclimatica));?>




            </select>

          </td>
        </tr>
        <tr>
          <td>Vehiculo Móvil Hecho</td>
          <td>

            <select type="text" class="select" name="SURC_VehiculoHecho_Id" >
            <option value="">Seleccionar</option>
            <?php

                    $surc_vehiculohecho = mysqli_query($conex_surc,"SELECT * FROM surc.surc_vehiculohecho
										ORDER BY SURC_VehiculoHecho_Descrip;")
                                      or  die("Problemas con el select condicion climatica: ".mysqli_error($conex_surc));

                    $row_surc_vehiculohecho=mysqli_fetch_array($surc_vehiculohecho);
                                      do {?>
                                        <option value="<?php
                                            echo $row_surc_vehiculohecho['SURC_VehiculoHecho_Id'];
                                          ?>" <?php if (isset($row_sumarios['Id_vehichecho']) and
                                        $row_sumarios['Id_vehichecho']==$row_surc_vehiculohecho['SURC_VehiculoHecho_Id']) {
                                          echo 'selected';
                                        } ?>>
                                        <?php echo utf8_encode($row_surc_vehiculohecho['SURC_VehiculoHecho_Descrip']); ?>
                                      </option>
                                      <?php } while ($row_surc_vehiculohecho=mysqli_fetch_array($surc_vehiculohecho));?>




            </select>
          </td>
        </tr>

    </table>
    <table>
      <tr>
        <td>
        <button type="submit" name="btn_guardar_hecho_upd" value="Guardar Cambios" class="btnguardar" formaction="update_hecho.php"><span class="soloimagen">Guardar Cambios</span></button>
        </td>
        <td>
        <button type="submit" name="btn_cancelar_hecho_upd" value="Cancelar" class="btncancelar" formaction="sum_d_upd.php"><span class="soloimagen">Cancelar</span></button>

        </td>
      </tr>
    </table>

</form>


  </body>
</html>
