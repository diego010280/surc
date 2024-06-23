<?php
session_start();
date_default_timezone_set('America/Argentina/Salta');
//session_unset();

if (empty($_REQUEST['usuariochar']) or empty($_REQUEST['moduloid']) or empty($_REQUEST['vif_legajo_id'])) { //empty ($_REQUEST['usuarioid']) or 
    
	$_SESSION = array();
	session_destroy();
	
	header('Location: ../../acceso/login.php?err=usnull');
	exit;

} else {

    /* si esta correcto */

	$_SESSION['logged'] = true;
//	$_SESSION['usuario_id'] = htmlspecialchars($_REQUEST['usuarioid']);
	$_SESSION['start'] = time();
	$_SESSION['moduleid']= htmlspecialchars($_REQUEST['moduloid']);
	$_SESSION['vif_legajo_id'] = htmlspecialchars($_REQUEST['vif_legajo_id']);
	$_SESSION['modulovif'] = htmlspecialchars($_REQUEST['modulovif']);
	
	//echo $_SESSION['modulovif'];
		
	if ($_REQUEST['usuariochar'] == 'usu') {

		header('Location: ../consulta_sum_vif.php');
		exit;

	}
}

?>
