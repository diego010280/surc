<?php 
session_start();
require_once '../../acceso/segacceso/tiempoespera.php';
    
if ($tiempotransc > $tiempoespera) {
    
	$_SESSION = array();
    session_destroy();

    header('Location: ../../acceso/login.php?access=timeout');
	exit;
        
} else {
        
//  $usid = $_SESSION['usuario_id'];

	header('Location:/acceso/segacceso/checks.php'); //?usid=$usid
	exit;
        
}