<?php


$modulo=$_SESSION['moduleid'];
$usuarioid= $_SESSION['usuario_id'];
$pgname = basename($_SERVER['PHP_SELF']);




$abm_consulta = false;
  $_SESSION['abm_consulta']= false;
$abm_alta = false;
$_SESSION['abm_alta']= false;
$abm_baja = false;
$_SESSION['abm_baja']= false;
$abm_modifica = false;
$_SESSION['abm_modifica']= false;
$niveldeperfil = false;

$A_izq=0;
$A_der=0;

$autorizado_a = mysqli_query($connusuario,"SELECT permisos.permiso_ejec, permisos.permiso_alta,
permisos.permiso_baja, permisos.permiso_mod, perfiles.perfil_EsAdm,
autorizacion.autorizacion_organismos_id AS Aut_idorg, autorizacion_izq_der.GEN_Organismos_Izquierdo AS Aut_izq,
autorizacion_izq_der.GEN_Organismos_Derecho AS Aut_der, autorizacion_izq_der.GEN_Organismos_Descripcion AS Desc_depend,
objetos.objeto_id


FROM segusuario.autorizacion

INNER JOIN segusuario.perfiles ON perfiles.perfil_id = autorizacion.autorizacion_perfil_id
INNER JOIN segusuario.permisos ON permisos.permiso_perfil_id = perfiles.perfil_id
INNER JOIN segusuario.objetos ON objetos.objeto_id = permisos.permiso_objeto_id
INNER JOIN segusuario.autorizacion_izq_der ON autorizacion_izq_der.Organismo_id = autorizacion.autorizacion_organismos_id
WHERE autorizacion.autorizacion_usuario_id = '$usuarioid' AND perfiles.perfil_activo = 1 AND objetos.objeto_link LIKE '$pgname' and objetos.objeto_modulo_id = '$modulo' ORDER BY autorizacion_izq_der.GEN_Organismos_Izquierdo ;") or die ("Error consulta perfil autorizado".mysqli_error($connusuario));
$row_autorizado_a = mysqli_fetch_array($autorizado_a);




do {

if ($row_autorizado_a['permiso_ejec'] == 1) {


    $abm_consulta = true;
    $_SESSION['abm_consulta']=true;

    if ($row_autorizado_a['permiso_alta'] == 1) {$abm_alta = true;
      $_SESSION['abm_alta']=true;}

    if ($row_autorizado_a['permiso_baja'] == 1) {$abm_baja = true;
      $_SESSION['abm_baja']=true;}

    if ($row_autorizado_a['permiso_mod'] == 1) {$abm_modifica = true;
      $_SESSION['abm_modifica']=true;}

    if (empty($niveldeperfil) or $niveldeperfil<$row_autorizado_a['perfil_EsAdm']) { $niveldeperfil = $row_autorizado_a['perfil_EsAdm'];}

    $_SESSION['Aut_idorg']=$row_autorizado_a['Aut_idorg'];



    if ($row_autorizado_a['Aut_izq'] >= $A_izq and $row_autorizado_a['Aut_der'] <= $A_der) { } else {

        $A_izq=$row_autorizado_a['Aut_izq'];
        $A_der=$row_autorizado_a['Aut_der'];
        $A_idorg=$row_autorizado_a['Aut_idorg'];
    $Aut_org[] = array ('Aut_idorg' => $row_autorizado_a['Aut_idorg'], 'Aut_izq' => $A_izq, 'Aut_der' => $A_der, 'A_descdepend'=> $row_autorizado_a['Desc_depend']);

    }


$objetoid = $row_autorizado_a['objeto_id'];

} else {  header('Location: ../acceso/login.php?access=private'); }



} while ($row_autorizado_a = mysqli_fetch_array($autorizado_a));

// echo('<pre>');
// var_dump($Aut_org);
// echo('</pre>');
//
// echo "nivelperfil:".$niveldeperfil.'<br>';
// echo "izquierdo:".$A_izq.'<br>';
// echo $A_der.'<br>';
// echo $A_idorg.'<br>';
?>
