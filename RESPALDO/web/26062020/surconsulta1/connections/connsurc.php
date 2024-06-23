<?php
$host = "192.168.0.129";
$user = "connworkbench"; //LOCAL
$pass = "7RHMdBYRrnUrTKeF";//LOCAL

//$user: "policiasistemas"; //WEB
//$pass: "u8WEpXYuzJrax6bK";//WEB


$dbname = "surc";


$conex_surc = new mysqli($host, $user, $pass, $dbname);

if ($conex_surc->connect_error) {
 die("La conexion falló: " . $conex_surc->connect_error);
}


 ?>
