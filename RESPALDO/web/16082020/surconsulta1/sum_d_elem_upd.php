<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      if ($alta==true) {?>
        <div class="">
                  <button class="btnGyC" type="submit" name="" form="agregar">Agregar Elemento</button>
        </div>
         <form action="surc_elementos_ins.php" method="get" id="agregar">
         </form>
        <br>
    <?php } ?>


    <section id="grilla">
      <table id="tabla_abm">
            <thead>
              <tr>
                <th>N°</th>
                <th>Tipo Elem.</th>
                <th>Elemento</th>
                <th>Nro. de Serie</th>
                <th>Cantidad</th>
                <th>Observaciones</th>
                <!-- <th>Condición</th> -->
                <th colspan="2"></th>
              </tr>
            </thead>
            <tbody>

              <?php
                $impresos=0;
                if (!empty($num_row_elementos)) {
                    mysqli_data_seek($elementos,0);

                    while ($row_elementos = mysqli_fetch_array($elementos)) {
              ?>
                      <tr>
                        <td><?= utf8_encode($row_elementos['SURC_SumarioElemento_Id']) ?></td>
                        <td><?= utf8_encode($row_elementos['forma']) ?></td>
                        <td><?= utf8_encode($row_elementos['Tipo_Elemento']) ?></td>
                        <td><?= utf8_encode($row_elementos['Numero_de_Serie']) ?></td>
                        <td><?= $row_elementos['Cantidad'] ?></td>
                        <td><?= utf8_encode($row_elementos['Observaciones']) ?></td>
                        <?php
                          if ($modif) {?>
                            <td align="center">
                                    <form  action="surc_elementos_upd.php" method="post">
                                      <input type="hidden" name="SURC_SumarioElemento_Id" value="<?= $row_elementos['SURC_SumarioElemento_Id'] ?>">
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
