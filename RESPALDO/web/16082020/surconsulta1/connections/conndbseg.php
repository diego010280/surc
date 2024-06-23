<?php
$host = "192.168.0.129";
$user = "connworkbench"; //LOCAL
$pass = "7RHMdBYRrnUrTKeF";//LOCAL

//$user: "policiasistemas"; //WEB
//$pass: "u8WEpXYuzJrax6bK";//WEB

$dbname = "dbseg";


$conex_dbseg = new mysqli($host, $user, $pass, $dbname);

if ($conex_dbseg->connect_error) {
 die("La conexion falló: " . $conex_dbseg->connect_error);
}


 ?>
