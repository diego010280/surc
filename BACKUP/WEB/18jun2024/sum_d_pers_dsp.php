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
                <th>Tipo Persona</th>
                <th>Clase Persona</th>
                <th>Vinculo</th>
                <th>Documento</th>
                <th>Apellido y Nombre</th>
                <th>Sexo</th>
                <th>Fecha Nacimiento</th>
                <th>Edad</th>
                <th>Alias</th>
                <th>Teléfono</th>
                <th>Estado Civil</th>
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
                        <td><?= $impresos ?></td>
                        <td><?= utf8_encode($row_personas['Tipo_Persona']) ?></td>
                        <td><?= utf8_encode($row_personas['Clase_Persona']) ?></td>
                        <td><?= utf8_encode($row_personas['Vinculo_Persona']) ?></td>
                        <td><?= utf8_encode($row_personas['Documento']) ?></td>
                        <td><?= utf8_encode($row_personas['ApellidoyNombre']) ?></td>
                        <td><?= utf8_encode($row_personas['Sexo']) ?></td>
                        <td><?php
                            if (!empty($row_personas['Fecha_Nac'])) {
                              date("d-m-Y",strtotime($row_personas['Fecha_Nac']));
                            }?>
                        </td>
                        <td><?= $row_personas['Edad'] ?></td>
                        <td><?= utf8_encode($row_personas['Alias']) ?></td>
                        <td><?= $row_personas['Telefono'] ?></td>
                        <td><?= utf8_encode($row_personas['Est_Civil']) ?></td>

                      </tr>
                  <?php  }
                }
               ?>

            </tbody>

      </table>

    </section>
  </body>
</html>
