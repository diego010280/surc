<?php 
session_start();
date_default_timezone_set('America/Argentina/Salta');
//session_unset();

if (empty($_REQUEST['usuariochar']) or empty($_REQUEST['moduloid'])) { //empty ($_REQUEST['usuarioid']) or 
    
	header('Location: /acceso/login.php?err=usnull');
	exit;
	
} else {
    
    /* si esta correcto */
    
	$_SESSION['logged'] = true;
//	$_SESSION['usuario_id'] = htmlspecialchars($_REQUEST['usuarioid']);
	$_SESSION['start'] = time();
	$_SESSION['moduleid']= htmlspecialchars($_REQUEST['moduloid']); 
    
    header('Location: ../ctrlpanel');
	exit;
    
}