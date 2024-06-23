<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');


date_default_timezone_set('America/Argentina/Salta');

header("Pragma: public");
header("Expires: 0");
$nombre="consulta sum_pers";
$dia=date('Y-m-d');
$filename=$nombre.$dia.".xls";

// $filename = "Socios.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");





if (isset($_REQUEST['excel_pers']) and $_REQUEST['excel_pers']=='excel_pers') {
  if (empty($_REQUEST['palabra_clave_pers']) and
      empty($_REQUEST['desdehecho']) and empty($_REQUEST['hastahecho']) ) {

        // echo "debe ingresar al menos un valor en el filtro de busquedas";

  } else {

    $palabra_clave_pers   = (empty($_REQUEST['palabra_clave_pers'])) ? '' : utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['palabra_clave_pers']));
    $desdehecho = (empty($_REQUEST['desdehecho'])) ? null : $_REQUEST['desdehecho'];
    $hastahecho = (empty($_REQUEST['hastahecho'])) ? null: $_REQUEST['hastahecho'];

    $sumario_excel=mysqli_query($conex_surc,"SELECT * FROM surc.personaexcel
                    where (concat_ws(' ',Documento,ApellidoyNombre,Alias,Telefono) LIKE '%$palabra_clave_pers%' or '$palabra_clave_pers'='')
                    AND (Fecha_delito>='$desdehecho' or '$desdehecho'='')
                    AND (Fecha_delito<= '$hastahecho' or '$hastahecho'='')
                    ORDER BY Anio DESC,Fecha_delito DESC") or die("Problemas con el select datos personas : ".mysqli_error($conex_surc));

      // $row_sumarios =  mysqli_fetch_array($sumarios);
       // $num_row_sumarios= $sumario_excel->num_rows;

}

}



?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<table style="border: 1px solid #000">
		<tr>
	<th style="background-color:#D8D8D8; height:35px;">Nro</th>
      <th style="background-color:#D8D8D8; height:35px;">Nro.Sumario M.P.</th>
			<th style="background-color:#D8D8D8; height:35px;">Año</th>
			<th style="background-color:#D8D8D8;">Dependencia</th>
			<th style="background-color:#D8D8D8;">Sector</th>
			<th style="background-color:#D8D8D8;">Unidad Regional</th>
			<th style="background-color:#D8D8D8;">Tipo Sumario</th>
	    <th style="background-color:#D8D8D8;">Origen Sumario</th>
			<th style="background-color:#D8D8D8;">Localidad</th>
			<th style="background-color:#D8D8D8;">Barrio</th>
			<th style="background-color:#D8D8D8;">Nom.Calle</th>
      <th style="background-color:#D8D8D8;">Alt.Calle</th>
      <th style="background-color:#D8D8D8;">Coord.X</th>
      <th style="background-color:#D8D8D8;">Coord.Y</th>
      <th style="background-color:#D8D8D8;">Cuadrícula</th>
      <th style="background-color:#D8D8D8;">Hecho Delictivo</th>
      <th style="background-color:#D8D8D8;">Tentativa</th>
      <th style="background-color:#D8D8D8;">Actuaciones</th>
      <th style="background-color:#D8D8D8;">Grupo Delictivo</th>
      <th style="background-color:#D8D8D8;">Fecha Delito</th>
      <th style="background-color:#D8D8D8;">Hora Delito</th>
      <th style="background-color:#D8D8D8;">Dia Semana</th>
      <th style="background-color:#D8D8D8;">Lugar Hecho</th>
      <th style="background-color:#D8D8D8;">Fiscalía</th>
      <th style="background-color:#D8D8D8;">Modalidad</th>
      <th style="background-color:#D8D8D8;">Arma o Mecanismo</th>
      <th style="background-color:#D8D8D8;">Bien Jurídico</th>
      <th style="background-color:#D8D8D8;">Descripción Hecho</th>
      <th style="background-color:#D8D8D8;">Hecho VIF</th>
      <th style="background-color:#D8D8D8;">Tipo Persona</th>
      <th style="background-color:#D8D8D8;">Clase Persona</th>
      <th style="background-color:#D8D8D8;">Vinculo Persona</th>
      <th style="background-color:#D8D8D8;">Documento</th>
      <th style="background-color:#D8D8D8;">Apellido y Nombre</th>
      <th style="background-color:#D8D8D8;">Sexo</th>
      <th style="background-color:#D8D8D8;">Fecha Nacimiento</th>
      <th style="background-color:#D8D8D8;">Edad</th>
      <th style="background-color:#D8D8D8;">Alias</th>
      <th style="background-color:#D8D8D8;">Telefono</th>
      <th style="background-color:#D8D8D8;">Estado Civil</th>


		</tr>


	   <?php
     $i = 0;

     while ($row_sumarios = mysqli_fetch_array($sumario_excel)) {
        ++$i; ?>
        <tr height="10px">
          <td><?= $i ?></td>
          <td><?= $row_sumarios['NroSumario_MP'] ?></td>
          <td><?= $row_sumarios['Anio'] ?></td>
          <td><?= utf8_encode($row_sumarios['Dependencia']) ?></td>
          <td><?= utf8_encode($row_sumarios['Sector']) ?></td>
          <td><?= utf8_encode($row_sumarios['Unidad_Regional']) ?></td>
          <td><?= utf8_encode($row_sumarios['Tipo_Sumario']) ?></td>
          <td><?= utf8_encode($row_sumarios['Origen_Sumario']) ?></td>
          <td><?= utf8_encode($row_sumarios['Localidad']) ?></td>
          <td><?= utf8_encode($row_sumarios['Barrio']) ?></td>
          <td><?= utf8_encode($row_sumarios['Nom_Calle']) ?></td>
          <td><?= $row_sumarios['Alt_Calle'] ?></td>
          <td><?= $row_sumarios['Coord_X'] ?></td>
          <td><?= $row_sumarios['Coord_Y'] ?></td>
          <td><?= utf8_encode($row_sumarios['Cuadricula']) ?></td>
          <td><?= utf8_encode($row_sumarios['Hecho_Delictivo']) ?></td>
          <td><?= utf8_encode($row_sumarios['Tentativa']) ?></td>
          <td><?= utf8_encode($row_sumarios['Actuacion_Esc']) ?></td>
          <td><?= utf8_encode($row_sumarios['Agrupamiento_Delictivo']) ?></td>

          <td><?= $row_sumarios['Fecha_delito'] ?>  </td>
          <td>
            <?php if (!empty($row_sumarios['Hora_Delito'])) {
                echo date('H:i:s',strtotime("$row_sumarios[Hora_Delito] - 3 hours"));}?>

           </td>
          <td>
            <?php
            if (!empty($row_sumarios['Fecha_delito'])) {
              switch ($row_sumarios['Dia_Semana']) {
                case 'Monday':
                  echo "Lunes";
                  break;

                case 'Tuesday':
                    echo "Martes";
                    break;

                case 'Wednesday':
                    echo "Miércoles";
                    break;

                case 'Thursday':
                        echo "Jueves";
                        break;

                case 'Friday':
                    echo "Viernes";
                    break;

                case 'Saturday':
                    echo "Sábado";
                    break;

                case 'Sunday':
                    echo "Domingo";
                    break;
              } {
                // code...
              }
            }
             ?>
          </td>
          <td><?= utf8_encode($row_sumarios['Lugar_Hecho']) ?></td>
          <td><?= utf8_encode($row_sumarios['Fiscalia']) ?></td>
          <td><?= utf8_encode($row_sumarios['Modalidad']) ?></td>
          <td><?= utf8_encode($row_sumarios['Arma_Mecanismo']) ?></td>
          <td><?= utf8_encode($row_sumarios['Bien_Juridico']) ?></td>
          <td nowrap><?= utf8_encode($row_sumarios['Descrip_Hecho']) ?></td>
          <td><?= $row_sumarios['Hecho_VIF'] ?></td>
          <td><?= utf8_encode($row_sumarios['Tipo_Persona']) ?></td>
          <td><?= utf8_encode($row_sumarios['Clase_Persona']) ?></td>
          <td><?= utf8_encode($row_sumarios['Vinculo_Persona']) ?></td>
          <td><?= utf8_encode($row_sumarios['Documento']) ?></td>
          <td><?= utf8_encode($row_sumarios['ApellidoyNombre']) ?></td>
          <td><?= utf8_encode($row_sumarios['Sexo']) ?></td>
          <td><?= utf8_encode($row_sumarios['Fecha_Nac']) ?></td>
          <td><?= utf8_encode($row_sumarios['Edad']) ?></td>
          <td><?= utf8_encode($row_sumarios['Alias']) ?></td>
          <td><?= utf8_encode($row_sumarios['Telefono']) ?></td>
          <td><?= utf8_encode($row_sumarios['Est_Civil']) ?></td>
        </tr>

<?php
}
 ?>


	</table>
</body>
</html>
