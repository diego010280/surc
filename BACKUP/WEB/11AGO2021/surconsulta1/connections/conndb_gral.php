<?php


//Para producción**************
$host = "192.168.0.199";
$user = "usexptes";
$pass = "7EuP4daxh3QRSZMj";
$dbname = "db_gral";
//*****************************

$conndb_gral = new mysqli($host, $user, $pass, $dbname);

if ($conndb_gral->connect_error) {
 die("La conexion falló: " . $conndb_gral->connect_error);
}


?>
