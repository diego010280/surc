<?php



 $host = "192.168.0.129";
 $user = "connworkbench";
 $pass = "7RHMdBYRrnUrTKeF";

$dbname = "contra";


$conex_contra = new mysqli($host, $user, $pass, $dbname);

if ($conex_contra->connect_error) {
 die("La conexion falló: " . $conex_contra->connect_error);
}





date_default_timezone_set('America/Argentina/Salta');


$detenidos= mysqli_query($conex_contra,"SELECT 
Contra_Persona_ApellidoNombre,
Contra_Persona_Documento,
Contra_Persona_Alias,
Contra_Persona_Sexo,
Contra_Persona_FechNacim,
Contra_Persona_Edad,
Nac_Descrip,
Contra_Persona_Telefono,
Contra_Estado_Descrip,
Contra_Movim_FechaDet,
Contra_Movim_HoraDet,
DepPol_Descrip,
Contra_Movim_Observacion,
Contra_Persona_Foto1,
Contra_Persona_Foto2,
Contra_Persona_Foto3, 
Contra_Persona_Foto4,
Contra_Persona_Foto5 

FROM contra.contra_movimiento

inner join contra.contra_persona on contra.contra_persona.Contra_Persona_Id=contra.contra_movimiento.Contra_Movim_IdPersona

left join dbseg.ref_nacionalidad on dbseg.ref_nacionalidad.Nac_Codigo=contra.contra_persona.Contra_Persona_IdNacion

left join contra.contra_estado on contra.contra_estado.Contra_Estado_Id=contra.contra_movimiento.Contra_Movim_IdEstado

left join dbseg.ref_dependencias on dbseg.ref_dependencias.DepPol_Codigo=contra.contra_movimiento.Contra_Movim_IdDependencia

where Contra_Persona_Sexo like 'M' and Contra_Movim_FechaDet >= '2021-01-01' and Contra_Movim_FechaDet <='2021-03-17' 
ORDER BY Contra_Movim_FechaDet ") 
or die("Problemas con el select  : ".mysqli_error($conex_surc));;

$row_detenidos = mysqli_fetch_array($detenidos);
$num_row_detenidos= $detenidos->num_rows;
//2021-03-17

?>

<!DOCTYPE html>
<html lang="es">
<body>

<table border="1">

<tr>

<td>Apellido y Nombre</td>
<td>DNI</td>
<td>Alias</td>
<td>Sexo</td>
<td>Fecha Nac.</td>
<td>Edad</td>
<td>Nacionalidad</td>
<td>Telefono</td>
<td>Estado</td>
<td>Fecha de Detencion</td>
<td>Hora Detencion</td>
<td>Dependencia Policial</td>
<td>Observacion</td>
<td>Foto 1</td>
<td>Foto 2</td>
<td>Foto 3</td>
<td>Foto 4</td>
<td>Foto 5</td>

</tr>

<?php do { ?>
<tr>

<td><?php echo utf8_encode($row_detenidos['Contra_Persona_ApellidoNombre']);  ?></td>
<td><?php echo $row_detenidos['Contra_Persona_Documento'];  ?></td>
<td><?php echo utf8_encode($row_detenidos['Contra_Persona_Alias']);  ?></td>
<td><?php echo $row_detenidos['Contra_Persona_Sexo'];  ?></td>
<td><?php echo date('d-m-Y', strtotime($row_detenidos['Contra_Persona_FechNacim']));  ?></td>
<td><?php echo $row_detenidos['Contra_Persona_Edad'];  ?></td>
<td><?php echo utf8_encode($row_detenidos['Nac_Descrip']);  ?></td>
<td><?php echo $row_detenidos['Contra_Persona_Telefono'];  ?></td>
<td><?php echo utf8_encode($row_detenidos['Contra_Estado_Descrip']);  ?></td>
<td><?php echo date('d-m-Y', strtotime($row_detenidos['Contra_Movim_FechaDet']));  ?></td>
<td><?php echo utf8_encode($row_detenidos['Contra_Movim_HoraDet']);  ?></td>
<td><?php echo utf8_encode($row_detenidos['DepPol_Descrip']);  ?></td>
<td><?php echo utf8_encode($row_detenidos['Contra_Movim_Observacion']);  ?></td>
<td><!-- fotos --> 
<?php
if ($row_detenidos['Contra_Persona_Foto1']!='') {
echo '<img height="80" width="80" src="data:image/jpeg;base64,'.base64_encode($row_detenidos['Contra_Persona_Foto1']).'"/>';
} 

?>

</td>
<td>
<?php
if ($row_detenidos['Contra_Persona_Foto2']!='') {
echo '<img height="80" width="80" src="data:image/jpeg;base64,'.base64_encode($row_detenidos['Contra_Persona_Foto2']).'"/>';
} 

?>
</td>
<td>

<?php
if ($row_detenidos['Contra_Persona_Foto3']!='') {
echo '<img height="80" width="80" src="data:image/jpeg;base64,'.base64_encode($row_detenidos['Contra_Persona_Foto3']).'"/>';
} 

?>

</td>
<td>

<?php
if ($row_detenidos['Contra_Persona_Foto4']!='') {
echo '<img height="80" width="80" src="data:image/jpeg;base64,'.base64_encode($row_detenidos['Contra_Persona_Foto4']).'"/>';
} 

?>

</td>
<td>

<?php
if ($row_detenidos['Contra_Persona_Foto5']!='') {
echo '<img height="80" width="80" src="data:image/jpeg;base64,'.base64_encode($row_detenidos['Contra_Persona_Foto5']).'"/>';
} 

?>

</td>


</tr>
<?php } while($row_detenidos =  mysqli_fetch_array($detenidos)); ?>


</table>   
	 
	 
        
    
    
    
    
    
</body>
</html>