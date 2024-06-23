<?php
//Local*****************************//
$host = "localhost";
$user = "polsistemas";
$pass = "z2CEv7awlw1qPzPd";
//**********************************//


// //Produccion***********************//
// $host = "192.168.0.129";
// $user = "usuconsurc";
// $pass = "u8WEpXYuzJrax6bK";
// //********************************//


$dbname = "dbseg";


$conex_dbseg = new mysqli($host, $user, $pass, $dbname);

if ($conex_dbseg->connect_error) {
 die("La conexion falló: " . $conex_dbseg->connect_error);
}


 ?>
