<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');


?>

<table class="plus conmargen">
		<tr>
                <td>
                  Apellido y Nombre
                </td>
                <td>
                    <input type="text" name="" class="w18" value="<?= $row_surc_personas['SURC_Persona_ApellidoNombre'] ?>" readonly>
                </td>
        </tr>
      <tr>
                <td>Tipo de Persona</td>
                <td>
                  <select type="text" class="select" name="SURC_PersonaSumario_IdTipoPers" required>
                  <option value="">Seleccionar</option>
                  <?php

                          $surc_tipopersona=mysqli_query($conex_surc," SELECT * FROM surc.surc_tipopersona;")
                                            or  die("Problemas con el select tipo persona: ".mysqli_error($conex_surc));

                          $row_surc_tipopersona=mysqli_fetch_array($surc_tipopersona);
                                            do {?>
                                              <option value="<?php
                                                  echo $row_surc_tipopersona['SURC_TipoPersona_Id'];
                                              ?>">
                                              <?php echo utf8_encode($row_surc_tipopersona['SURC_TipoPersona_Descrip']); ?>
                                            </option>
                                            <?php } while ($row_surc_tipopersona=mysqli_fetch_array($surc_tipopersona));?>




                  </select>
                </td>
      </tr>
      <tr>
                <td>Clase de Persona</td>
                <td>
                  <select type="text" class="select" name="SURC_PersonaSumario_IdClasePer" required>
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
                  <select type="text" class="select" name="SURC_PersonaSumario_IdVinculo" required>
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
                  <textarea name="SURC_PersonaSumario_Obs" rows="8" cols="80" style="overflow-y:scroll;text-align:justify;text-transform:uppercase;"><?= utf8_encode($row_personasum['SURC_PersonaSumario_Obs']) ?></textarea>

                </td>
              </tr>


            </table>
