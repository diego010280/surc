<?php
//Local*****************************//
$host = "localhost";
$user = "polsistemas";
$pass = "z2CEv7awlw1qPzPd";

//**********************************//



// //Produccion*************************//
// $host = "192.168.0.129";
// $user = "connworkbench";
// $pass = "7RHMdBYRrnUrTKeF";
// //**********************************//

$dbname = "surc";


$conex_surc = new mysqli($host, $user, $pass, $dbname);

if ($conex_surc->connect_error) {
 die("La conexion falló: " . $conex_surc->connect_error);
}



 ?>
