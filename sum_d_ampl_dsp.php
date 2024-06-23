<!DOCTYPE html>
<html lang="es" dir="ltr">
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
                <th>Fecha Ampliación</th>
                <th>Hora Ampliación</th>
                <th>Texto Relato</th>
              </tr>
            </thead>
            <tbody>

              <?php
                 $impresos=0;
                if (!empty($num_row_ampliacion)) {
                    mysqli_data_seek($ampliacion,0);

                    while ($row_ampliacion = mysqli_fetch_array($ampliacion)) {
                      ++$impresos;?>
                      <tr>
                        <td><?= $impresos ?></td>
                        <td><?= date("d-m-Y",strtotime($row_ampliacion['SURC_SumarioAmpl_Fecha'])) ?></td>
                        <td><?php if (!empty($row_ampliacion['SURC_SumarioAmpl_Hora'])) {
                            echo date('H:i:s',strtotime("$row_ampliacion[SURC_SumarioAmpl_Hora] - 3 hours"));}?></td>
                        <td><?= utf8_encode($row_ampliacion['SURC_SumarioAmpl_TextoRelato']) ?></td>
                      </tr>
                  <?php  }
                }
               ?>

            </tbody>

      </table>

    </section>
  </body>
</html>
