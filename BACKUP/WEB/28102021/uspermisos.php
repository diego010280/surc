<?php

$modulo=$_SESSION['moduleid'];
$usuarioid= $_SESSION['usuario_id'];
$pgname = basename($_SERVER['PHP_SELF']);


$ejec = false; 
$alta = false; 
$baja = false; 
$modif = false;




$autorizado_a = mysqli_query($conexion,"SELECT permisos.permiso_ejec, permisos.permiso_alta, permisos.permiso_baja, permisos.permiso_mod FROM autorizacion 

INNER JOIN perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
INNER JOIN permisos ON permisos.permiso_perfil_id = perfiles.perfil_id
INNER JOIN objetos ON objetos.objeto_id = permisos.permiso_objeto_id

WHERE autorizacion.autorizacion_usuario_id = '$usuarioid' AND perfiles.perfil_activo = 1 AND objetos.objeto_link LIKE '$pgname' and objetos.objeto_modulo_id = '$modulo';") or die ("Error consulta perfil autorizado");
$row_autorizado_a = mysqli_fetch_array($autorizado_a);

do {
    if ($row_autorizado_a['permiso_ejec'] == 1) {$ejec = true;}
		
	if ($row_autorizado_a['permiso_alta'] == 1) {$alta = true;}
		
	if ($row_autorizado_a['permiso_baja'] == 1) {$baja = true;}

	if ($row_autorizado_a['permiso_mod'] == 1) {$modif = true;}

    } while ($row_autorizado_a = mysqli_fetch_array($autorizado_a));


if ($ejec==false){
    
    
    session_start();

    session_destroy();
    $pg= explode(".", $pgname);
    $cadena= $pg[0];
    $cadena=base64_encode($cadena);
    
    header("Location:../../acceso/login.php?err=fail&pg=$cadena");
    
    
};

?>