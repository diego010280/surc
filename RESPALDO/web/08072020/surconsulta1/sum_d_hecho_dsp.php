<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
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
          <input type="text" name="" class="w18" value="<?= utf8_encode($row_sumarios['Tipo_hechodelictivo']) ?>" readonly>
        </td>

      </tr>
      <tr>
        <td>Tentativa</td>
        <td>
          <input type="checkbox" name="" value="<?= utf8_encode($row_sumarios['tentativa'])?>" <?php if (!empty($row_sumarios['tentativa'])) {
            if ($row_sumarios['tentativa']=="S") {
              echo 'checked';
            }
          } ?>  onclick="return false;" onkeydown="return false;">
        </td>
      </tr>
      <tr>
        <td>Violencia Familiar (VIF)</td>
        <td>
          <input type="checkbox" name="" value="<?= utf8_encode($row_sumarios['hechodelictivo_vif'])?>" <?php if (!empty($row_sumarios['hechodelictivo_vif'])) {
            if ($row_sumarios['hechodelictivo_vif']=="S") {
              echo 'checked';
            }
          } ?> onclick="return false;" onkeydown="return false;">
        </td>

      </tr>
      <tr>
        <td>Arma o Mecanismo</td>
        <td>
          <input type="text" class="w18" name="" value="<?= utf8_encode($row_sumarios['desc_armamec'])?>" readonly>
        </td>
      </tr>
      <td>Modalidad Delictiva</td>
      <td>
        <input type="text" class="w18" name="" value="<?= utf8_encode($row_sumarios['desc_modalidad'])?>" readonly>
      </td>
      <tr>
        <td>Forma Acción</td>
        <td>
          <input type="text" class="w18" name="" value="<?= utf8_encode($row_sumarios['desc_formaacc'])?>" readonly>
        </td>
      </tr>
      <tr>
        <td>Modo Producción</td>
        <td>
          <input type="text" class="w18" name="" value="<?= utf8_encode($row_sumarios['desc_modoprod'])?>" readonly>
        </td>
      </tr>
      <tr>
        <td>Condición Climática</td>
        <td>
          <input type="text" class="w18" name="" value="<?= utf8_encode($row_sumarios['desc_condclim'])?>" readonly>
        </td>
      </tr>
      <tr>
        <td>Vehiculo Móvil Hecho</td>
        <td>
          <input type="text" class="w18" name="" value="<?= utf8_encode($row_sumarios['desc_vehichecho'])?>" readonly>
        </td>
      </tr>

    </table>



  </body>
</html>
