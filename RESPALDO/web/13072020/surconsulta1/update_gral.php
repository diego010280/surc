<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/connauditoria.php');
date_default_timezone_set('America/Argentina/Salta');



if (isset($_REQUEST['btn_guardar_gral_upd']) and $_REQUEST['btn_guardar_gral_upd']=='Guardar Cambios') {

  mysqli_query($conex_surc,"SET NAMES 'utf8'");

  $SURC_Sumario_NroSumMP=mb_strtoupper($_REQUEST['SURC_Sumario_NroSumMP']);
  $SURC_Sumario_Anio=$_REQUEST['SURC_Sumario_Anio'];
  $SURC_OrigenSumario_Id=$_REQUEST['SURC_OrigenSumario_Id'];


  $SURC_TipoSum_Id=$_REQUEST['SURC_TipoSum_Id'];

  $DepPol_Codigo=$_REQUEST['DepPol_Codigo'];

  $id_juzg=explode(" ",$_REQUEST['SURC_JuzgadoFiscalia_Id']);
  $SURC_JuzgadoFiscalia_Id= intval($id_juzg[0]);

  $SURC_Sumario_FechaDel=$_REQUEST['SURC_Sumario_FechaDel'];

  $SURC_Sumario_HoraDel_sumar=$_REQUEST['SURC_Sumario_HoraDel'];
  $SURC_Sumario_HoraDel='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraDel_sumar + 3 hours"));


  $SURC_Sumario_IdLugar = intval($_REQUEST['SURC_Sumario_IdLugar']);

  $SURC_Sumario_NomCalle=mb_strtoupper($_REQUEST['SURC_Sumario_NomCalle']);

  $SURC_Sumario_AltCalle = (empty($_REQUEST['SURC_Sumario_AltCalle'])) ? 0 : intval($_REQUEST['SURC_Sumario_AltCalle']);

  $SURC_Sumario_Piso=mb_strtoupper($_REQUEST['SURC_Sumario_Piso']);
  $SURC_Sumario_Dpto=mb_strtoupper($_REQUEST['SURC_Sumario_Dpto']);
  $SURC_Sumario_Mza=mb_strtoupper($_REQUEST['SURC_Sumario_Mza']);
  $SURC_Sumario_CasaLote=mb_strtoupper($_REQUEST['SURC_Sumario_CasaLote']);

  $id_loc=explode(" ",$_REQUEST['Localidad_Codigo']);
  $Localidad_Codigo= intval($id_loc[0]);

  $SURC_Sumario_TextoRelato=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_TextoRelato']))));

  $id_barrio=explode(" ",$_REQUEST['Barrio_Codigo']);
  $Barrio_Codigo=intval($id_barrio[0]);

  $SURC_Cuadriculas_Id=$_REQUEST['SURC_Cuadriculas_Id'];

  $SURC_Sumario_CoordX=$_REQUEST['SURC_Sumario_CoordX'];
  $SURC_Sumario_CoordY=$_REQUEST['SURC_Sumario_CoordY'];

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
    SURC_Sumario_NroSumMP= '$SURC_Sumario_NroSumMP',
    SURC_Sumario_Anio='$SURC_Sumario_Anio',
    SURC_Sumario_IdOrigSum= NULLIF('$SURC_OrigenSumario_Id',''),
    SURC_Sumario_IdTipoSumario= NULLIF('$SURC_TipoSum_Id',''),
    SURC_Sumario_IdDependencia= NULLIF('$DepPol_Codigo',''),
    SURC_Sumario_IdJuzFis=NULLIF('$SURC_JuzgadoFiscalia_Id','0'),
    SURC_Sumario_FechaDel='$SURC_Sumario_FechaDel',
    SURC_Sumario_HoraDel= '$SURC_Sumario_HoraDel',
    SURC_Sumario_IdLugar= NULLIF('$SURC_Sumario_IdLugar','0'),
    SURC_Sumario_NomCalle= '$SURC_Sumario_NomCalle',
    SURC_Sumario_AltCalle= '$SURC_Sumario_AltCalle',
    SURC_Sumario_Piso= '$SURC_Sumario_Piso',
    SURC_Sumario_Dpto= '$SURC_Sumario_Dpto',
    SURC_Sumario_Mza= '$SURC_Sumario_Mza',
    SURC_Sumario_CasaLote= '$SURC_Sumario_CasaLote',
    SURC_Sumario_IdLocalidad= NULLIF('$Localidad_Codigo','0'),
    SURC_Sumario_IdBarrio= NULLIF('$Barrio_Codigo','0'),
    SURC_Sumario_IdCuadricula= NULLIF('$SURC_Cuadriculas_Id',''),
    SURC_Sumario_CoordX= '$SURC_Sumario_CoordX',
    SURC_Sumario_CoordY= '$SURC_Sumario_CoordY',
    SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
    SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
    SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
    SURC_Sumario_TextoRelato=NULLIF('$SURC_Sumario_TextoRelato',''),
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
         if ($row_sumario_auditoria['SURC_Sumario_NroSumMP']!=$SURC_Sumario_NroSumMP) {
              $activ=$activ.' '."SURC_Sumario_NroSumMP".':'.$row_sumario_auditoria['SURC_Sumario_NroSumMP'].' '.$SURC_Sumario_NroSumMP;
          }
          if ($row_sumario_auditoria['SURC_Sumario_Anio']!=$SURC_Sumario_Anio) {
              $activ=$activ.' '."SURC_Sumario_Anio".':'.$row_sumario_auditoria['SURC_Sumario_Anio'].' '.$SURC_Sumario_Anio;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdOrigSum']!=$SURC_OrigenSumario_Id) {
              $activ=$activ.' '."SURC_Sumario_IdOrigSum".':'.$row_sumario_auditoria['SURC_Sumario_IdOrigSum'].' '.$SURC_OrigenSumario_Id;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdTipoSumario']!=$SURC_TipoSum_Id) {
              $activ=$activ.' '."SURC_Sumario_IdTipoSumario".':'.$row_sumario_auditoria['SURC_Sumario_IdTipoSumario'].' '.$SURC_TipoSum_Id;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdDependencia']!=$DepPol_Codigo) {
              $activ=$activ.' '."SURC_Sumario_IdDependencia".':'.$row_sumario_auditoria['SURC_Sumario_IdDependencia'].' '.$DepPol_Codigo;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdJuzFis']!=$SURC_JuzgadoFiscalia_Id) {
              $activ=$activ.' '."SURC_Sumario_IdJuzFis".':'.$row_sumario_auditoria['SURC_Sumario_IdJuzFis'].' '.$SURC_JuzgadoFiscalia_Id;
          }
          if ($row_sumario_auditoria['SURC_Sumario_FechaDel']!=$SURC_Sumario_FechaDel) {
              $activ=$activ.' '."SURC_Sumario_FechaDel".':'.$row_sumario_auditoria['SURC_Sumario_FechaDel'].' '.$SURC_Sumario_FechaDel;
          }
          if ($row_sumario_auditoria['SURC_Sumario_HoraDel']!=$SURC_Sumario_HoraDel) {
              $activ=$activ.' '."SURC_Sumario_HoraDel".':'.$row_sumario_auditoria['SURC_Sumario_HoraDel'].' '.$SURC_Sumario_HoraDel;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdLugar']!=$SURC_Sumario_IdLugar) {
              $activ=$activ.' '."SURC_Sumario_IdLugar".':'.$row_sumario_auditoria['SURC_Sumario_IdLugar'].' '.$SURC_Sumario_IdLugar;
          }
          if ($row_sumario_auditoria['SURC_Sumario_NomCalle']!=$SURC_Sumario_NomCalle) {
              $activ=$activ.' '."SURC_Sumario_NomCalle".':'.$row_sumario_auditoria['SURC_Sumario_NomCalle'].' '.$SURC_Sumario_NomCalle;
          }
          if ($row_sumario_auditoria['SURC_Sumario_AltCalle']!=$SURC_Sumario_AltCalle) {
              $activ=$activ.' '."SURC_Sumario_AltCalle".':'.$row_sumario_auditoria['SURC_Sumario_AltCalle'].' '.$SURC_Sumario_AltCalle;
          }
          if ($row_sumario_auditoria['SURC_Sumario_Piso']!=$SURC_Sumario_Piso) {
              $activ=$activ.' '."SURC_Sumario_Piso".':'.$row_sumario_auditoria['SURC_Sumario_Piso'].' '.$SURC_Sumario_Piso;
          }
          if ($row_sumario_auditoria['SURC_Sumario_Dpto']!=$SURC_Sumario_Dpto) {
              $activ=$activ.' '."SURC_Sumario_Dpto".':'.$row_sumario_auditoria['SURC_Sumario_Dpto'].' '.$SURC_Sumario_Dpto;
          }
          if ($row_sumario_auditoria['SURC_Sumario_Mza']!=$SURC_Sumario_Mza) {
              $activ=$activ.' '."SURC_Sumario_Mza".':'.$row_sumario_auditoria['SURC_Sumario_Mza'].' '.$SURC_Sumario_Mza;
          }
          if ($row_sumario_auditoria['SURC_Sumario_CasaLote']!=$SURC_Sumario_CasaLote) {
              $activ=$activ.' '."SURC_Sumario_CasaLote".':'.$row_sumario_auditoria['SURC_Sumario_CasaLote'].' '.$SURC_Sumario_CasaLote;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdLocalidad']!=$Localidad_Codigo) {
              $activ=$activ.' '."SURC_Sumario_IdLocalidad".':'.$row_sumario_auditoria['SURC_Sumario_IdLocalidad'].' '.$Localidad_Codigo;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdBarrio']!=$Barrio_Codigo) {
              $activ=$activ.' '."SURC_Sumario_IdBarrio".':'.$row_sumario_auditoria['SURC_Sumario_IdBarrio'].' '.$Barrio_Codigo;
          }
          if ($row_sumario_auditoria['SURC_Sumario_IdCuadricula']!=$SURC_Cuadriculas_Id) {
              $activ=$activ.' '."SURC_Sumario_IdCuadricula".':'.$row_sumario_auditoria['SURC_Sumario_IdCuadricula'].' '.$SURC_Cuadriculas_Id;
          }
          if ($row_sumario_auditoria['SURC_Sumario_CoordX']!=$SURC_Sumario_CoordX) {
              $activ=$activ.' '."SURC_Sumario_CoordX".':'.$row_sumario_auditoria['SURC_Sumario_CoordX'].' '.$SURC_Sumario_CoordX;
          }
          if ($row_sumario_auditoria['SURC_Sumario_CoordY']!=$SURC_Sumario_CoordY) {
              $activ=$activ.' '."SURC_Sumario_CoordY".':'.$row_sumario_auditoria['SURC_Sumario_CoordY'].' '.$SURC_Sumario_CoordY;
          }
          if ($row_sumario_auditoria['SURC_Sumario_TextoRelato']!=$SURC_Sumario_TextoRelato) {
              $activ=$activ.' '."SURC_Sumario_TextoRelato".': Texto de Relato Modificado';
          }

    }

    mysqli_query($connaud,"SET NAMES 'utf8'");
    mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId,auditoria_action_id, auditoria_descrip)

          VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','5','$activ')");


    //fin registro actividad

      header("Location: sum_d_upd.php?accion=mod&tab=0");
    } else {
      header("Location: sum_d_upd.php?accion=no_upd&tab=0");
    }

 }



 ?>
