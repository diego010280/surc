<?php


//Para producción**************
$host = "192.168.0.199";
$user = "usexptes";
$pass = "7EuP4daxh3QRSZMj";
$dbname = "auditorias";
//*****************************

$conndb_audit = new mysqli($host, $user, $pass, $dbname);

if ($conndb_audit->connect_error) {
 die("La conexion falló: " . $conndb_audit->connect_error);
}


?>
