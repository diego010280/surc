<?php

// desarrollo
 //$host = "localhost";
 //$user = "polsistemas";
 //$pass = "z2CEv7awlw1qPzPd";


// produccion
$host = "localhost";
$user = "ussegu";
$pass = "6cSNpcpNDrN8ybRX";

$dbname = "auditorias";


$connaud = new mysqli($host, $user, $pass, $dbname);

if ($connaud->connect_error) {
 die("La conexion falló: " . $connaud->connect_error);
}


?>
