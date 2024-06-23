<?php

// desarrollo
// $host = "localhost";
// $user = "polsistemas";
// $pass = "z2CEv7awlw1qPzPd";


// produccion

$host = "192.168.0.199";
$user = "usexptes";
$pass = "7EuP4daxh3QRSZMj";



$dbname = "xml";


$conex_xml = new mysqli($host, $user, $pass, $dbname);

if ($conex_xml->connect_error) {
 die("La conexion falló: " . $conex_xml->connect_error);
}

$conex_xml->set_charset("utf8");

 ?>
