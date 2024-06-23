<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');



if (isset($_REQUEST['btn_guardar_gral_upd']) and $_REQUEST['btn_guardar_gral_upd']=='Guardar Cambios') {

  mysqli_query($conex_surc,"SET NAMES 'utf8'");

  $SURC_Sumario_NroSumMP= $_REQUEST['SURC_Sumario_NroSumMP'];
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

  $SURC_Sumario_NomCalle=$_REQUEST['SURC_Sumario_NomCalle'];

  $SURC_Sumario_AltCalle = (empty($_REQUEST['SURC_Sumario_AltCalle'])) ? 0 : intval($_REQUEST['SURC_Sumario_AltCalle']);

  $SURC_Sumario_Piso=$_REQUEST['SURC_Sumario_Piso'];
  $SURC_Sumario_Dpto=$_REQUEST['SURC_Sumario_Dpto'];
  $SURC_Sumario_Mza=$_REQUEST['SURC_Sumario_Mza'];
  $SURC_Sumario_CasaLote=$_REQUEST['SURC_Sumario_CasaLote'];

  $id_loc=explode(" ",$_REQUEST['Localidad_Codigo']);
  $Localidad_Codigo= intval($id_loc[0]);

  $id_barrio=explode(" ",$_REQUEST['Barrio_Codigo']);
  $Barrio_Codigo=intval($id_barrio[0]);

  $SURC_Cuadriculas_Id=$_REQUEST['SURC_Cuadriculas_Id'];

  $SURC_Sumario_CoordX=$_REQUEST['SURC_Sumario_CoordX'];
  $SURC_Sumario_CoordY=$_REQUEST['SURC_Sumario_CoordY'];

  $usuario=mysqli_query($conexion,"SELECT * FROM segusuario.usuarios
                                  where usuario_id='$_SESSION[usuario_id]'") or
                                  die("Problemas con el select usuarios : ".mysqli_error($conexion));
  $row_usuario=mysqli_fetch_array($usuario);

  $SURC_Sumario_CargaUsuario=strtoupper($row_usuario['usuario_cuenta']);
  $SURC_Sumario_FechaSum=date('Y-m-d');
  $SURC_Sumario_HoraSum_sumar=date('H:i:s');
  $SURC_Sumario_HoraSum='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraSum_sumar + 3 hours"));

  mysqli_query($conex_surc, "UPDATE surc.surc_sumario SET
    SURC_Sumario_NroSumMP= '$SURC_Sumario_NroSumMP',
    SURC_Sumario_Anio='$SURC_Sumario_Anio',
    SURC_Sumario_IdOrigSum= '$SURC_OrigenSumario_Id',
    SURC_Sumario_IdTipoSumario= '$SURC_TipoSum_Id',
    SURC_Sumario_IdDependencia= '$DepPol_Codigo',
    SURC_Sumario_IdJuzFis='$SURC_JuzgadoFiscalia_Id',
    SURC_Sumario_FechaDel='$SURC_Sumario_FechaDel',
    SURC_Sumario_HoraDel= '$SURC_Sumario_HoraDel',
    SURC_Sumario_IdLugar= '$SURC_Sumario_IdLugar',
    SURC_Sumario_NomCalle= '$SURC_Sumario_NomCalle',
    SURC_Sumario_AltCalle= '$SURC_Sumario_AltCalle',
    SURC_Sumario_Piso= '$SURC_Sumario_Piso',
    SURC_Sumario_Dpto= '$SURC_Sumario_Dpto',
    SURC_Sumario_Mza= '$SURC_Sumario_Mza',
    SURC_Sumario_CasaLote= '$SURC_Sumario_CasaLote',
    SURC_Sumario_IdLocalidad= '$Localidad_Codigo',
    SURC_Sumario_IdBarrio= '$Barrio_Codigo',
    SURC_Sumario_IdCuadricula= '$SURC_Cuadriculas_Id',
    SURC_Sumario_CoordX= '$SURC_Sumario_CoordX',
    SURC_Sumario_CoordY= '$SURC_Sumario_CoordY',
    SURC_Sumario_CargaUsuario= '$SURC_Sumario_CargaUsuario',
    SURC_Sumario_FechaSum='$SURC_Sumario_FechaSum',
    SURC_Sumario_HoraSum='$SURC_Sumario_HoraSum',
    Surc_Sumario_Modificado='M'

    where SURC_Sumario_Id='$_SESSION[SURC_Sumario_Id]'") or  die("Problemas con el update".mysqli_error($conex_surc));



    if (!empty(mysqli_affected_rows($conex_surc))) {
      header("Location: sum_d_upd.php?accion=mod&tab=0");
    } else {
      header("Location: sum_d_upd.php?accion=no_upd&tab=0");
    }

 }



 ?>
