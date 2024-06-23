<?php

$modulo = $_SESSION['moduleid'];
$usuarioid = $_SESSION['usuario_id'];
$pgname = basename($_SERVER['PHP_SELF']);

$ejec = false; 
$alta = false; 
$baja = false; 
$modif = false;

$autorizado_a = $conexion->query("SELECT permisos.permiso_ejec, permisos.permiso_alta, permisos.permiso_baja, permisos.permiso_mod
	FROM autorizacion 
	JOIN perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
	JOIN permisos ON permisos.permiso_perfil_id = perfiles.perfil_id
	JOIN objetos ON objetos.objeto_id = permisos.permiso_objeto_id
	WHERE autorizacion.autorizacion_usuario_id = '$usuarioid'
	AND perfiles.perfil_activo = 1
	AND objetos.objeto_link LIKE '$pgname'
	AND objetos.objeto_modulo_id = '$modulo'");

while ($row_autorizado_a = $autorizado_a->fetch_assoc()) {
	
    if ($row_autorizado_a['permiso_ejec'] == 1) {$ejec = true;}
	if ($row_autorizado_a['permiso_alta'] == 1) {$alta = true;}
	if ($row_autorizado_a['permiso_baja'] == 1) {$baja = true;}
	if ($row_autorizado_a['permiso_mod'] == 1)  {$modif = true;}

}

$dirbase = substr(dirname($_SERVER['SCRIPT_NAME']), 1);

$querymod = $conexion->query("SELECT modulo_link FROM segusuario.modulos WHERE modulo_id = '$_SESSION[moduleid]'");
$row_qm = $querymod->fetch_assoc();
$querymod->free();

$qmalink = substr($row_qm['modulo_link'], 1, strpos($row_qm['modulo_link'], '/', 1) - 1);

if ($ejec === false ||
	$dirbase !== $qmalink) {
    
    session_start();
	$_SESSION = array();
    session_destroy();
	
    header('Location:../../acceso/login.php?err=fail');
	exit;
    
} ?>