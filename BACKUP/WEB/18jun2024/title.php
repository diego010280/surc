<?php

$pgname = basename($_SERVER['PHP_SELF']);


$descrip= mysqli_query ($conexion, "SELECT objeto_descrip FROM objetos WHERE objeto_link LIKE '$pgname' ");

$row_descrip = mysqli_fetch_array($descrip);   
$num_descrip = $descrip->num_rows;

if ($num_descrip>0){ echo $row_descrip['objeto_descrip'];} else { echo 'SIPS'; }



?>