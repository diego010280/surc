<?php

session_start();

date_default_timezone_set('America/Argentina/Salta');

session_unset();


if (empty ($_REQUEST['usuarioid']) or empty($_REQUEST['usuariochar']) or empty($_REQUEST['moduloid'])) {
    header("Location: acceso/login.php?err=usnull");

} else {

    /* si esta correcto */

	$_SESSION['logged'] = true;
	$_SESSION['usuario_id'] = htmlspecialchars($_REQUEST['usuarioid']);
	$_SESSION['start'] = time();
	$_SESSION['moduleid']= htmlspecialchars($_REQUEST['moduloid']);
	$_SESSION['vif_legajo_id'] = htmlspecialchars($_REQUEST['vif_legajo_id']);
	$_SESSION['id_vif_ap'] = htmlspecialchars($_REQUEST['id_vif_ap']);
echo "legajo vif es ".$_SESSION['vif_legajo_id'];
	
		
	if ($_REQUEST['usuariochar'] == 'usu') {

		header("Location: ../consulta_sum_vif.php"); 

	}
}

?>
