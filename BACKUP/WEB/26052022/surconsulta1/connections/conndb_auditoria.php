<?php


//Para producción**************
$host = "localhost";
$user = "usexptes";
$pass = "7EuP4daxh3QRSZMj";
$dbname = "auditorias";
//*****************************

$conndb_audit = new mysqli($host, $user, $pass, $dbname);

if ($conndb_audit->connect_error) {
 die("La conexion falló: " . $conndb_audit->connect_error);
}


?>
