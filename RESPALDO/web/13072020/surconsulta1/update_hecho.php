<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/connauditoria.php');

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

  $sumario_auditoria=mysqli_query($conex_surc,"SELECT * FROM surc.surc_sumario WHERE
        SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]';") or die("Problemas con el select usuarios : ".mysqli_error($conex_surc));

   mysqli_query($conex_surc, "UPDATE surc.surc_sumario SET
    SURC_Sumario_IdHechoDel= NULLIF('$SURC_Sumario_IdHechoDel',''),
    SURC_Sumario_Tentativa= '$SURC_Sumario_Tentativa',
    SURC_HechoDelictivo_VIF= '$SURC_HechoDelictivo_VIF',
    SURC_Sumario_IdArmaMec=NULLIF('$SURC_Sumario_IdArmaMec',''),
    SURC_Sumario_IdFormaAcc= NULLIF('$SURC_Sumario_IdFormaAcc',''),
    SURC_Sumario_IdModalidad= NULLIF('$SURC_Sumario_IdModalidad',''),
    SURC_Sumario_IdModoProd=NULLIF('$SURC_ModoProduccion_Id',''),
    SURC_Sumario_IdCondClim=NULLIF('$SURC_Sumario_IdCondClim',''),
    SURC_Sumario_IdVehicHecho=NULLIF('$SURC_VehiculoHecho_Id',''),
    SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
    SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
    SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
    Surc_Sumario_Modificado='M'

      where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or  die("Problemas con el update".mysqli_error($conex_surc));

  if (!empty(mysqli_affected_rows($conex_surc))) {

    // ultimo id auditoria

    $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
    $row_uid = mysqli_fetch_array($uid);

    $nuevo_id = ($row_uid['max_id']+1);

    // insertar registro
     $activ="Modificacion existosa. ";

     while ($row_sumario_auditoria = mysqli_fetch_array($sumario_auditoria)) {
       if ($row_sumario_auditoria['SURC_Sumario_IdHechoDel']!=$SURC_Sumario_IdHechoDel) {
            $activ=$activ.' '."SURC_Sumario_IdHechoDel".':'.$row_sumario_auditoria['SURC_Sumario_IdHechoDel'].' '.$SURC_Sumario_IdHechoDel;
        }
        if ($row_sumario_auditoria['SURC_Sumario_Tentativa']!=$SURC_Sumario_Tentativa) {
            $activ=$activ.' '."SURC_Sumario_Tentativa".':'.$row_sumario_auditoria['SURC_Sumario_Tentativa'].' '.$SURC_Sumario_Tentativa;
        }
        if ($row_sumario_auditoria['SURC_HechoDelictivo_VIF']!=$SURC_HechoDelictivo_VIF) {
            $activ=$activ.' '."SURC_HechoDelictivo_VIF".':'.$row_sumario_auditoria['SURC_HechoDelictivo_VIF'].' '.$SURC_HechoDelictivo_VIF;
        }
        if ($row_sumario_auditoria['SURC_Sumario_IdArmaMec']!=$SURC_Sumario_IdArmaMec) {
            $activ=$activ.' '."SURC_Sumario_IdArmaMec".':'.$row_sumario_auditoria['SURC_Sumario_IdArmaMec'].' '.$SURC_Sumario_IdArmaMec;
        }
        if ($row_sumario_auditoria['SURC_Sumario_IdFormaAcc']!=$SURC_Sumario_IdFormaAcc) {
            $activ=$activ.' '."SURC_Sumario_IdFormaAcc".':'.$row_sumario_auditoria['SURC_Sumario_IdFormaAcc'].' '.$SURC_Sumario_IdFormaAcc;
        }
        if ($row_sumario_auditoria['SURC_Sumario_IdModalidad']!=$SURC_Sumario_IdModalidad) {
            $activ=$activ.' '."SURC_Sumario_IdModalidad".':'.$row_sumario_auditoria['SURC_Sumario_IdModalidad'].' '.$SURC_Sumario_IdModalidad;
        }
        if ($row_sumario_auditoria['SURC_Sumario_IdModoProd']!=$SURC_ModoProduccion_Id) {
            $activ=$activ.' '."SURC_Sumario_IdModoProd".':'.$row_sumario_auditoria['SURC_Sumario_IdModoProd'].' '.$SURC_ModoProduccion_Id;
        }
        if ($row_sumario_auditoria['SURC_Sumario_IdCondClim']!=$SURC_Sumario_IdCondClim) {
            $activ=$activ.' '."SURC_Sumario_IdCondClim".':'.$row_sumario_auditoria['SURC_Sumario_IdCondClim'].' '.$SURC_Sumario_IdCondClim;
        }
        if ($row_sumario_auditoria['SURC_Sumario_IdVehicHecho']!=$SURC_VehiculoHecho_Id) {
            $activ=$activ.' '."SURC_Sumario_IdVehicHecho".':'.$row_sumario_auditoria['SURC_Sumario_IdVehicHecho'].' '.$SURC_VehiculoHecho_Id;
        }


  }

  mysqli_query($connaud,"SET NAMES 'utf8'");
  mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId,auditoria_action_id, auditoria_descrip)

        VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','5','$activ')");


  //fin registro actividad

    header("Location: sum_d_upd.php?accion=mod&tab=1");
  } else {
    header("Location: sum_d_upd.php?accion=no_upd&tab=1");
  }

 }



 ?>
