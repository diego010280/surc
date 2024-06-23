#!/usr/bin/php -q

<?php

require_once ('connsurc.php');
date_default_timezone_set('America/Argentina/Salta');

mysqli_query($conex_surc,"UPDATE surc_sumario SET SURC_Sumario_IdTipoActasEscl=1 WHERE SURC_Sumario_IdTipoActasEscl IS NULL") or die("Problemas en el UPDATE".mysqli_error($conex_surc));

$cantidad_lectura =  mysqli_affected_rows($conex_surc);

$fecha= date("Y-m-d H:i:s");

$fp = fopen("/var/www/html/surcscript/fichero.txt", "a");

fputs($fp, "($cantidad_lectura) Cantidad de Archivos modificados realizados el día $fecha .\n");

fclose($fp);

 ?>
