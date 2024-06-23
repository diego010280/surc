<?php

if (empty($_SESSION['logged']) or !is_numeric($_SESSION['moduleid']) or ($_SESSION['moduleid'] < 1)) {

	header('Location:../acceso/login.php?access=private');
	exit;

} else {

   require_once ('../acceso/segacceso/tiempoespera.php');
    
   if ($tiempotransc > $tiempoespera) {
        
        $_SESSION = array();
		session_destroy();

        header('Location: ../acceso/login.php?access=timeout');
		exit;
        
    } else {
		$_SESSION['start'] = $ahora;
	} 
    
} ?>