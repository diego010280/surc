<?php
$host = "192.168.0.129";
$user = "connworkbench"; //LOCAL
$pass = "7RHMdBYRrnUrTKeF";//LOCAL

/*$host = "servergx";
$user = "root";
$pass = "desarrollo";
*/
$dbname = "surc";


$conex_surc = new mysqli($host, $user, $pass, $dbname);

if ($conex_surc->connect_error) {
 die("La conexion falló: " . $conex_surc->connect_error);
}


 ?>
