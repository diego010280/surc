<table id="tabla_abm">
  <thead>
    <tr>
      <th>Num.MP</th>
      <th>Año</th>
      <th>Dependencia</th>
      <th>UU.RR</th>
      <th>Tipo Sumario</th>
      <th>Origen Sumario</th>
      <th>Grupo Delictivo</th>
      <th>Fecha Delito</th>
      <th>Usuario</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
	<?php
	if (!empty($num_sumarios)) {
		while ($row_sumarios = mysqli_fetch_array($sumarios)) { ?>
			<tr>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['Anio'] ?></td>
				<td><?= $row_sumarios['DepPol_Descrip'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
				<td><?= $row_sumarios['NroSumario_MP'] ?></td>
			</tr>
		<?php
		}
	} else { ?>
		<tr><td colspan="12">Sin registros para visualizar</td></tr>
	<?php
	} ?>
  </tbody>

</table>
