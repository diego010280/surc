<?php

//$host = "localhost";
//$user = "polsistemas";
//$pass = "z2CEv7awlw1qPzPd";
$dbname = "segusuario";

$host = "localhost";
$user = "usexptes";
$pass = "7EuP4daxh3QRSZMj";

$conexion = new mysqli($host, $user, $pass, $dbname);

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}


?>