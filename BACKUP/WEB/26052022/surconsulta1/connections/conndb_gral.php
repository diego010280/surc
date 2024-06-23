<?php


//Para producción**************
$host = "localhost";
$user = "usexptes";
$pass = "7EuP4daxh3QRSZMj";
$dbname = "db_gral";
//*****************************

$conndb_gral = new mysqli($host, $user, $pass, $dbname);

if ($conndb_gral->connect_error) {
 die("La conexion falló: " . $conndb_gral->connect_error);
}


?>
