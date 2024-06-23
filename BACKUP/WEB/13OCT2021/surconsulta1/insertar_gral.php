<?php
session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');
require_once ('connections/connauditoria.php');
date_default_timezone_set('America/Argentina/Salta');


$SURC_Sumario_NroSumMP='';
$SURC_Sumario_Anio='';
$SURC_OrigenSumario_Id='';
$SURC_TipoSum_Id='';
$DepPol_Codigo='';
$SURC_JuzgadoFiscalia_Id='';
$SURC_Sumario_FechaDel='';
$SURC_Sumario_HoraDel_sumar='';
$SURC_Sumario_IdLugar='';
$SURC_Sumario_NomCalle='';
$SURC_Sumario_AltCalle='';
$SURC_Sumario_Piso='';
$SURC_Sumario_Dpto='';
$SURC_Sumario_Mza='';
$SURC_Sumario_CasaLote='';
$Localidad_Codigo='';
$SURC_Sumario_TextoRelato='';
$Barrio_Codigo='';
$SURC_Cuadriculas_Id='';
$SURC_Sumario_CoordX='';
$SURC_Sumario_CoordY='';
$SURC_Sumario_IdHechoDel='';
$activ='';

if (isset($_REQUEST['btn_guardar_gral_upd']) and $_REQUEST['btn_guardar_gral_upd']=='Guardar Cambios') {

        mysqli_query($conex_surc,"SET NAMES 'utf8'");

        $SURC_Sumario_NroSumMP=mb_strtoupper($_REQUEST['SURC_Sumario_NroSumMP']);
        $SURC_Sumario_Anio=$_REQUEST['SURC_Sumario_Anio'];
        $SURC_OrigenSumario_Id=$_REQUEST['SURC_OrigenSumario_Id'];


        $SURC_Sumario_IdTipoSumario=$_REQUEST['SURC_TipoSum_Id'];

        $id_tipodelitomp=explode(" ",$_REQUEST['SURC_Sumario_IdTipoDelitoMP']);
        $SURC_Sumario_IdTipoDelitoMP=intval($id_tipodelitomp[0]);


        if (!empty($SURC_Sumario_IdTipoDelitoMP)) {

          $hechodelictivo="SELECT * FROM surc.surc_hechodelictivo
                          where surc.surc_hechodelictivo.SURC_HechoDelictivo_IdTipoDeli='$SURC_Sumario_IdTipoDelitoMP';";

          $surc_hechodelictivo=mysqli_query($conex_surc,$hechodelictivo) or die ('Problemas con busqueda hecho delictivo:'.mysqli_error($conex_surc));
          $row_surc_hechodelictivo=mysqli_fetch_array($surc_hechodelictivo);
          $num_surc_hechodelictivo=$surc_hechodelictivo->num_rows;

          if ($num_surc_hechodelictivo>0) {
              $SURC_Sumario_IdHechoDel=$row_surc_hechodelictivo['SURC_HechoDelictivo_Id'];
          }else {
            $SURC_Sumario_IdHechoDel='';
          }

      }else {
        $SURC_Sumario_IdHechoDel='';
      }




    $id_deppol=explode(" ",$_REQUEST['DepPol_Codigo']);
    $SURC_Sumario_IdDependencia=intval($id_deppol[0]);


    $id_juzg=explode(" ",$_REQUEST['SURC_JuzgadoFiscalia_Id']);
    $SURC_JuzgadoFiscalia_Id= intval($id_juzg[0]);

    $SURC_Sumario_FechaDel=$_REQUEST['SURC_Sumario_FechaDel'];
    echo $SURC_Sumario_FechaDel.'<br>';

    $SURC_Sumario_HoraDel_sumar=$_REQUEST['SURC_Sumario_HoraDel'];

    if (!empty($SURC_Sumario_HoraDel_sumar)) {

        if ($SURC_Sumario_HoraDel_sumar=='21:00') {
          $SURC_Sumario_HoraDel_sumar='21:00:01';
        }

        $SURC_Sumario_HoraDel='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraDel_sumar + 3 hours"));
      }else {
        $SURC_Sumario_HoraDel='1000-01-01'.' '.'00:00:00';
      }


      $SURC_Sumario_IdLugar = intval($_REQUEST['SURC_Sumario_IdLugar']);

      $SURC_Sumario_NomCalle=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_NomCalle']))));

      $SURC_Sumario_AltCalle = (empty($_REQUEST['SURC_Sumario_AltCalle'])) ? 0 : intval($_REQUEST['SURC_Sumario_AltCalle']);

      $SURC_Sumario_Piso=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_Piso']))));

      $SURC_Sumario_Dpto=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_Dpto']))));

      $SURC_Sumario_Mza=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_Mza']))));

      $SURC_Sumario_CasaLote=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_CasaLote']))));


      $id_loc=explode(" ",$_REQUEST['Localidad_Codigo']);
      $Localidad_Codigo= intval($id_loc[0]);

      $SURC_Sumario_TextoRelato=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$_REQUEST['SURC_Sumario_TextoRelato']))));

      $id_barrio=explode(" ",$_REQUEST['Barrio_Codigo']);
      $Barrio_Codigo=intval($id_barrio[0]);
      // $Barrio_Codigo=intval($_REQUEST['Barrio_Codigo']);

      $SURC_Cuadriculas_Id=intval($_REQUEST['SURC_Cuadriculas_Id']);

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

      //**************verificar si existe caracteristicas del sumario*****************************************//

      $max_surc_sumario = "SELECT MAX(surc.surc_sumario.SURC_Sumario_Id) as 'id' FROM surc.surc_sumario";

      $existe_unique="SELECT COUNT(*) as 'valor' FROM surc.surc_sumario
                       WHERE (surc.surc_sumario.SURC_Sumario_Anio='$SURC_Sumario_Anio') and (surc.surc_sumario.SURC_Sumario_IdDependencia='$SURC_Sumario_IdDependencia')
                       and (surc.surc_sumario.SURC_Sumario_NroSumMP like '$SURC_Sumario_NroSumMP') and (surc.surc_sumario.SURC_Sumario_IdTipoSumario='$SURC_Sumario_IdTipoSumario');";

      if ($yaexiste_unique=mysqli_query($conex_surc,$existe_unique)) {

          $row_yaexiste_unique=mysqli_fetch_array($yaexiste_unique);

          if ($row_yaexiste_unique['valor']==0) {
            if ($Id_surc_sumario = mysqli_query($conex_surc,$max_surc_sumario)) {
                            // echo "ingreso".'<br>';

                           if ($row = mysqli_fetch_array($Id_surc_sumario)) {
                           $id_sumario = trim($row[0]);
                           $SURC_Sumario_Id=$id_sumario+1;
                           }

                           // // echo 'SURC_Sumario_Id es igual a'.$SURC_Sumario_Id.'<br>';
                           // $SURC_Sumario_HoraSum_sumar=date('H:i:s');
                           // // echo "SURC_Sumario_HoraSum_sumar:".$SURC_Sumario_HoraSum_sumar.'<br>';
                           // $SURC_Sumario_HoraSum='1000-01-01'.' '.date('H:i:s',strtotime("$SURC_Sumario_HoraSum_sumar + 3 hours"));
                           // $SURC_Sumario_HoraSum=trim($SURC_Sumario_HoraSum);
                           // // echo "SURC_Sumario_HoraSum:".$SURC_Sumario_HoraSum.'<br>';

                           $insert_surc_sumario="INSERT INTO surc_sumario(
                             SURC_Sumario_Id, SURC_Sumario_NroSumMP,
                             SURC_Sumario_Anio, SURC_Sumario_IdDependencia,SURC_Sumario_IdTipoSumario,
                             SURC_Sumario_IdTipoDelitoMP,SURC_Sumario_CoordX,SURC_Sumario_CoordY,
                             SURC_Sumario_NomCalle,SURC_Sumario_FechaSum,SURC_Sumario_HoraSum,
                             SURC_Sumario_AltCalle,SURC_Sumario_Piso,SURC_Sumario_Dpto,
                             SURC_Sumario_Mza,SURC_Sumario_CasaLote,
                             SURC_Sumario_FechaDel,SURC_Sumario_HoraDel,SURC_Sumario_IdLocalidad,
                             SURC_Sumario_IdJuzFis,SURC_Sumario_IdOrigSum,SURC_Sumario_TextoRelato,
                             SURC_Sumario_IdHechoDel,SURC_Sumario_IdLugar,SURC_Sumario_IdArmaMec,
                             SURC_Sumario_IdCondClim,SURC_Sumario_IdModoProd,
                             SURC_Sumario_IdFormaAcc,SURC_Sumario_IdVehicHecho,
                             SURC_Sumario_IdCuadricula,SURC_Sumario_CargaUsuario,
                             SURC_Sumario_IdTipoActasEscl)

                             VALUES (
                             '$SURC_Sumario_Id','$SURC_Sumario_NroSumMP',
                             '$SURC_Sumario_Anio','$SURC_Sumario_IdDependencia','$SURC_Sumario_IdTipoSumario',
                             '$SURC_Sumario_IdTipoDelitoMP',NULLIF('$SURC_Sumario_CoordX',''),NULLIF('$SURC_Sumario_CoordY',''),
                             NULLIF('$SURC_Sumario_NomCalle',''),'$SURC_Sumario_FechaSum','$SURC_Sumario_HoraSum',
                             NULLIF('$SURC_Sumario_AltCalle',''),NULLIF('$SURC_Sumario_Piso',''),NULLIF('$SURC_Sumario_Dpto',''),
                             NULLIF('$SURC_Sumario_Mza',''),NULLIF('$SURC_Sumario_CasaLote',''),
                             NULLIF('$SURC_Sumario_FechaDel',''),'$SURC_Sumario_HoraDel','$Localidad_Codigo',
                             '$SURC_JuzgadoFiscalia_Id','$SURC_OrigenSumario_Id','$SURC_Sumario_TextoRelato',
                             NULLIF('$SURC_Sumario_IdHechoDel',''),'$SURC_Sumario_IdLugar',12,
                             7,5,
                             3,11,
                             1000,'$SURC_Sumario_CargaUsuario',
                             1
                             )";

                             if (mysqli_query($conex_surc,$insert_surc_sumario)) {


                               // ultimo id auditoria

                               $uid= mysqli_query($connaud, "SELECT MAX(auditoria_id) as max_id FROM auditoria ");
                               $row_uid = mysqli_fetch_array($uid);

                               $nuevo_id = ($row_uid['max_id']+1);

                               // insertar registro
                                $activ="Alta existosa de sumario en Sistema SURC N° ".$SURC_Sumario_Id.' .';

                                mysqli_query($connaud,"SET NAMES 'utf8'");
                                mysqli_query($connaud, "INSERT INTO auditoria(auditoria_id, auditoria_usuario_id,auditoria_moduloId,auditoria_action_id, auditoria_descrip)

                                      VALUES ('$nuevo_id', '$_SESSION[usuario_id]','$_SESSION[moduleid]','3','$activ')");

                                header("Location: sum_d_upd.php?accion=ins&tab=0&SURC_Sumario_Id=$SURC_Sumario_Id");

                             }else {
                               // header("Location: sum_d_ins.php?accion=no_ins&tab=0");
                               die ('Problemas alta:'.mysqli_error($conex_surc));
                             }
          }else {
            header("Location: sum_d_ins.php?accion=no_ins&tab=0");
          }
      }else {

        $xml_t_errormysql="Error: La ejecución de la consulta buscando si existe el unique compuesto surc_sumario:".mysqli_error($conex_surc);
        header("Location: sum_d_ins.php?accion=no_ins_dupl&tab=0");
      }
      //******************************************************************************************************//



    }else {
      header("Location: sum_d_ins.php.php?accion=no_ins&tab=0");
    }

}

 ?>
