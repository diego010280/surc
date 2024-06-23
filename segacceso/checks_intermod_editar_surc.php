<?php
session_start();
date_default_timezone_set('America/Argentina/Salta');
//session_unset();

if (empty($_REQUEST['usuariochar']) or empty($_REQUEST['moduloid'])) { //empty ($_REQUEST['usuarioid']) or 
    
	header('Location: acceso/login.php?err=usnull');
	exit;

} else {

    /* si esta correcto */

	$_SESSION['logged'] = true;
//	$_SESSION['usuario_id'] = htmlspecialchars($_REQUEST['usuarioid']);
	$_SESSION['start'] = time();
	$_SESSION['moduleid']= htmlspecialchars($_REQUEST['moduloid']);
	$_SESSION['vif_legajo_id'] = htmlspecialchars($_REQUEST['vif_legajo_id']);
	$_SESSION['id_vif_ap'] = htmlspecialchars($_REQUEST['id_vif_ap']);
	$_SESSION['modulovif'] = htmlspecialchars($_REQUEST['modulovif']);
	//echo "legajo vif es ".$_SESSION['vif_legajo_id'];
	
	if ($_REQUEST['usuariochar'] == 'usu') {

		header('Location: ../consulta_sum_vif.php');
		exit;
	
	}
} ?>