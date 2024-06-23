
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/estilos-doc.css">
  </head>
  <body>
    <?php
      if ($alta==true) {?>
        <div class="">
                  <button class="btnGyC" type="submit" name="" form="agregar">Agregar Persona</button>
        </div>
         <form action="surc_personas_ins.php" method="post" id="agregar">

         </form>
        <br>
    <?php } ?>


    <section id="grilla">
      <table id="tabla_abm">
            <thead>
              <tr>
                <th>N°</th>
                <th>Tipo Persona</th>
                <th>Clase Persona</th>
                <th>Vinculo</th>
                <th>DNI</th>
                <th>Apellido y Nombre</th>
                <th>Sexo</th>
                <th>Fecha Nac.</th>
                <th>Edad</th>
                <!-- <th>Alias</th> -->
                <th>Teléfono</th>
                <!-- <th>Estado Civil</th> -->
                <th colspan="2"></th>
              </tr>
            </thead>
            <tbody>

              <?php
                 $impresos=0;
                if (!empty($num_row_personas)) {
                    mysqli_data_seek($personas,0);

                    while ($row_personas = mysqli_fetch_array($personas)) {
                      ++$impresos;?>
                      <tr>
                        <td align="center"><?= $impresos ?></td>
                        <td><?= utf8_encode($row_personas['Tipo_Persona']) ?></td>
                        <td><?= utf8_encode($row_personas['Clase_Persona']) ?></td>
                        <td><?= utf8_encode($row_personas['Vinculo_Persona']) ?></td>
                        <td align="center"><?= utf8_encode($row_personas['Documento']) ?></td>
                        <td><?= utf8_encode($row_personas['ApellidoyNombre']) ?></td>
                        <td align="center"><?= utf8_encode($row_personas['Sexo']) ?></td>
                        <td align="center"><?php
                              if (!is_null($row_personas['Fecha_Nac'])) {
                         date("d-m-Y",strtotime($row_personas['Fecha_Nac']));
                       }
                         ?> </td>
                        <td align="center"><?php
                              if (!is_null($row_personas['Edad'])) {
                                 $row_personas['Edad'];
                              }?>  </td>

                        <td align="right"><?= $row_personas['Telefono'] ?></td>

                        <?php
                          if ($modif) {?>
                            <td align="center">
                                  <form  action="surc_personas_upd.php" method="post">
                                    <input type="hidden" name="SURC_PersonaSumario_IdPersona" value="<?= $row_personas['SURC_PersonaSumario_IdPersona'] ?>">
                                    <input type="image" name="boton" src="imagenes/iconos/pencil.png" width="16" title="Modificar" value="">

                                  </form>

                            </td>
                          <?php } ?>

                      </tr>
                  <?php  }
                }
               ?>

            </tbody>

      </table>

    </section>
  </body>
</html>
