<?php

// desarrollo
 // $host = "localhost";
 // $user = "polsistemas";
 // $pass = "z2CEv7awlw1qPzPd";


//produccion
$host = "192.168.0.199";
$user = "ussegu";
$pass = "6cSNpcpNDrN8ybRX";

$dbname = "rrhh";


$connrrhh = new mysqli($host, $user, $pass, $dbname);

if ($connrrhh->connect_error) {
 die("La conexion falló: " . $connrrhh->connect_error);
}


?>
