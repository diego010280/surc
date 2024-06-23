<?php
//require_once ('Connections/connsegusuario.php');

$modulo=$_SESSION['moduleid'];
$usuarioid= $_SESSION['usuario_id'];

$abm_consulta_obj = false;
$abm_alta_obj = false;
$abm_baja_obj = false;
$abm_modifica_obj = false;
$niveldeperfil = false;

$A_izq=0;
$A_der=0;

$autorizado_a = mysqli_query($conexion,"SELECT permisos.permiso_ejec, permisos.permiso_alta,
permisos.permiso_baja, permisos.permiso_mod, perfiles.perfil_EsAdm,
autorizacion.autorizacion_organismos_id AS Aut_idorg, autorizacion_izq_der.GEN_Organismos_Izquierdo AS Aut_izq,
autorizacion_izq_der.GEN_Organismos_Derecho AS Aut_der, autorizacion_izq_der.GEN_Organismos_Descripcion AS Desc_depend,
objetos.objeto_id


FROM segusuario.autorizacion

INNER JOIN segusuario.perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
INNER JOIN segusuario.permisos ON permisos.permiso_perfil_id = perfiles.perfil_id
INNER JOIN segusuario.objetos ON objetos.objeto_id = permisos.permiso_objeto_id
INNER JOIN segusuario.autorizacion_izq_der ON autorizacion_izq_der.Organismo_id = autorizacion.autorizacion_organismos_id
WHERE autorizacion.autorizacion_usuario_id = '$usuarioid' AND perfiles.perfil_activo = 1 AND objetos.objeto_link LIKE '$pgname' and objetos.objeto_modulo_id = '$modulo' ORDER BY autorizacion_izq_der.GEN_Organismos_Izquierdo ;") or die ("Error consulta perfil autorizado".mysqli_error($conexion));
$row_autorizado_a = mysqli_fetch_array($autorizado_a);

do {

if ($row_autorizado_a['permiso_ejec'] == 1) {
$abm_consulta_obj = true;

}

} while ($row_autorizado_a = mysqli_fetch_array($autorizado_a));

?>
