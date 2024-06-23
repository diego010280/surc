<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');



if (isset($_REQUEST['btn_guardar_hecho_upd']) and $_REQUEST['btn_guardar_hecho_upd']=='Guardar Cambios') {

  mysqli_query($conex_surc,"SET NAMES 'utf8'");


$SURC_Sumario_IdHechoDel=(empty($_REQUEST['SURC_Sumario_IdHechoDel'])) ? '' : intval($_REQUEST['SURC_Sumario_IdHechoDel']);

if (!empty($_REQUEST['SURC_Sumario_Tentativa']) and ($_REQUEST['SURC_Sumario_Tentativa']=='tentativa')) {

   $SURC_Sumario_Tentativa='S';
} else {

   $SURC_Sumario_Tentativa='N';
 }


 if (!empty($_REQUEST['SURC_HechoDelictivo_VIF']) and ($_REQUEST['SURC_HechoDelictivo_VIF']=='vif')) {
  $SURC_HechoDelictivo_VIF='S';
} else {
  $SURC_HechoDelictivo_VIF='N';
}

$SURC_Sumario_IdArmaMec=(empty($_REQUEST['SURC_Sumario_IdArmaMec'])) ? '' : intval($_REQUEST['SURC_Sumario_IdArmaMec']);
$SURC_Sumario_IdModalidad=(empty($_REQUEST['SURC_Sumario_IdModalidad'])) ? '' : intval($_REQUEST['SURC_Sumario_IdModalidad']);
$SURC_Sumario_IdFormaAcc=(empty($_REQUEST['SURC_Sumario_IdFormaAcc'])) ? '' : intval($_REQUEST['SURC_Sumario_IdFormaAcc']);
$SURC_ModoProduccion_Id=(empty($_REQUEST['SURC_ModoProduccion_Id'])) ? '' : intval($_REQUEST['SURC_ModoProduccion_Id']);
$SURC_Sumario_IdCondClim=(empty($_REQUEST['SURC_Sumario_IdCondClim'])) ? '' : intval($_REQUEST['SURC_Sumario_IdCondClim']);
$SURC_VehiculoHecho_Id=(empty($_REQUEST['SURC_VehiculoHecho_Id'])) ? '' : intval($_REQUEST['SURC_VehiculoHecho_Id']);


$usuario=mysqli_query($conexion,"SELECT * FROM segusuario.usuarios
                                  where usuario_id='$_SESSION[usuario_id]'") or
                                  die("Problemas con el select usuarios : ".mysqli_error($conexion));
$row_usuario=mysqli_fetch_array($usuario);

  $SURC_Sumario_CargaUsuario=mb_strtoupper($row_usuario['usuario_cuenta']);
  $SURC_Sumario_FechaSum=date('Y-m-d');
  $SURC_Sumario_HoraSum_sumar=date('H:i:s');
  $SURC_Sumario_HoraSum='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraSum_sumar + 3 hours"));

   mysqli_query($conex_surc, "UPDATE surc.surc_sumario SET
    SURC_Sumario_IdHechoDel= '$SURC_Sumario_IdHechoDel',
    SURC_Sumario_Tentativa= '$SURC_Sumario_Tentativa',
    SURC_HechoDelictivo_VIF= '$SURC_HechoDelictivo_VIF',
    SURC_Sumario_IdArmaMec='$SURC_Sumario_IdArmaMec',
    SURC_Sumario_IdFormaAcc= '$SURC_Sumario_IdFormaAcc',
    SURC_Sumario_IdModalidad= '$SURC_Sumario_IdModalidad',
    SURC_Sumario_IdModoProd='$SURC_ModoProduccion_Id',
    SURC_Sumario_IdCondClim='$SURC_Sumario_IdCondClim',
    SURC_Sumario_IdVehicHecho='$SURC_VehiculoHecho_Id',
    SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
    SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
    SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
    Surc_Sumario_Modificado='M'

      where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or  die("Problemas con el update".mysqli_error($conex_surc));

  if (!empty(mysqli_affected_rows($conex_surc))) {
    header("Location: sum_d_upd.php?accion=mod&tab=1");
  } else {
    header("Location: sum_d_upd.php?accion=no_upd&tab=1");
  }

 }



 ?>
