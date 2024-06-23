<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
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
              </tr>
            </thead>
            <tbody>

              <?php
                $impresos=0;
                if (!empty($num_row_elementos)) {
                    mysqli_data_seek($elementos,0);

                    while ($row_elementos = mysqli_fetch_array($elementos)) {
                    ++$impresos;?>
                      <tr>
                        <td><?= $impresos ?></td>
                        <td><?= utf8_encode($row_elementos['forma']) ?></td>
                        <td><?= utf8_encode($row_elementos['Tipo_Elemento']) ?></td>
                        <td><?= utf8_encode($row_elementos['Numero_de_Serie']) ?></td>
                        <td><?= $row_elementos['Cantidad'] ?></td>
                        <td><?= utf8_encode($row_elementos['Observaciones']) ?></td>
                        
                      </tr>
                  <?php  }
                }
               ?>

            </tbody>

      </table>

    </section>
  </body>
</html>
