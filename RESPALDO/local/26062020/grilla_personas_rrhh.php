<section id="grilla">
    <table id="tabla_abm">
      <thead>
        <tr>
          <th>Nro. Documento</th>
          <th>Sexo</th>
          <th>Pais</th>
          <th>Clase Persona</th>
          <th>Apellido</th>
          <th>Nombre</th>
          <th colspan="1"></th>
        </tr>
      </thead>
      <tbody>
          <?php
            mysqli_data_seek($personas_rrhh,0);
            while ($row_personas_rrhh=mysqli_fetch_array($personas_rrhh)) {?>
              <tr>
                <td style="width:120px;" align="center"><?= $row_personas_rrhh['persona_nro_doc'] ?></td>
                <td style="width:120px;" align="center"><?= $row_personas_rrhh['persona_sexo'] ?></td>
                <td style="width:120px;" align="center"><?= $row_personas_rrhh['persona_pais_iso_doc'] ?></td>
                <td style="width:150px;" align="center"><?= $row_personas_rrhh['persona_clase'] ?></td>
                <td><?= $row_personas_rrhh['persona_apellido'] ?></td>
                <td><?= $row_personas_rrhh['persona_nombre'] ?></td>
                <td align="center">
                      <a href="alta_personas.php?persona_id=<?php echo $row_personas_rrhh['persona_id'].'&SURC_Persona_Documento='.$dni_buscar; ?>" > <img src="imagenes/iconos/plus.png" width="16" title="Seleccionar">
                      </a>

                </td>
              </tr>
          <?php }   ?>
      </tbody>
    </table>
    <form action="alta_personas.php" id="lupa_persona" method="get">
      <input type="hidden" name="persona_id" value="<?= $row_personas_rrhh['persona_id'] ?>">  </form>
</section>
