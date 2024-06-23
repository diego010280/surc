<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');


date_default_timezone_set('America/Argentina/Salta');

$opciones = array(
	'options' => array(
		'min_range' => 1,
		'max_range' => 100
	)
);
$num_motivo = 0;

if (filter_var($_REQUEST['local_id'],FILTER_VALIDATE_INT,$opciones) !== false) {

$local_id = $_REQUEST['local_id'];
$barrio = mysqli_query($conex_dbseg,"SELECT * FROM dbseg.ref_barrio WHERE Localidad_Codigo = '$local_id';") or die ('Problemas con select ref_barrio'.mysqli_error($conex_dbseg));
$row=mysqli_fetch_array($barrio);
$num_barrio = $barrio->num_rows;
}
?>



	<input type="text" list="idbarrios" name="" value="" placeholder="<?php if ($num_barrio>0) echo 'Seleccionar...'; ?>">
	<?php
		echo '<datalist id="idbarrios">';
		do {?>
			<option value="<?php echo $row['Barrio_Codigo']." ".utf8_encode($row['Barrio_Descrip']); ?>"></option>
	<?php } while ($row=mysqli_fetch_array($barrio));
			echo '</datalist>';
	 ?>
