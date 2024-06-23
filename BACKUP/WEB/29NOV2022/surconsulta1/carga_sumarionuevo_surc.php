<?php

$ref_carga_complementario='';
$ref_altasumnuevo='';
$ref_altapersonasurc='';
$ref_surcsumpersonas='';
$ref_grabarpersonaextraviada='';
$ref_elemento='';
$ref_ampliacion='';
$ref_diligencias='';
$ref_estados='';
$ref_grabarderivadocambionro='';
$ref_eliminarsumariorepetidos='';
$ref_upd_de_laderivada='';
$ref_eliminarsumario_nuevo='';
$SumarioComplementario='';
$SURC_Sumario_TextoRelato='';
$SURC_Sumario_Id='';
$ref_altacaratula='';


//*********************************************************************************************************************************//
      $denunciaID_MP=trim($Table['denunciaId']);


      $IdOrigSum=intval($Table['tipoDenuncia']);

      $origensumario="SELECT * FROM surc.surc_origensumario
                      where surc.surc_origensumario.SURC_OrigenSumario_Id='$IdOrigSum';";

 if ($surc_origensumario=mysqli_query($conex_surc,$origensumario)) {
            //****************************obtener id origen de sumario*************************************************************//
              $row_surc_origensumario=mysqli_fetch_array($surc_origensumario);
              $num_surc_origensumario=$surc_origensumario->num_rows;

              if ($num_surc_origensumario>0) {
                    $SURC_Sumario_IdOrigSum=$row_surc_origensumario['SURC_OrigenSumario_Id'];
              }else {

                    include ('alta_origensum_mp.php');
                    $SURC_Sumario_IdOrigSum=100;
                    $OrigenSumario = "SIN DEFINICION";
              }

              //echo $SURC_Sumario_IdOrigSum;


          //**********************************************************************************************************************//

          //**********Acta***********************************//

            $SURC_Sumario_NroSumMP=trim($Table['actaNro']);
            // echo "SURC_Sumario_NroSumMP: ".$SURC_Sumario_NroSumMP.'<br>';

            $SURC_Sumario_NroSumMPAct=trim($Table['actaNroActual']);
            // echo "SURC_Sumario_NroSumMPAct: ".$SURC_Sumario_NroSumMPAct.'<br>';

          //*************************************************//

          //*********año************************************//

            $SURC_Sumario_Anio=intval($Table['Anio']);


            $SURC_Sumario_AnioAct=intval($Table['AnioActual']);

            //**************************************************//

            //***********Dependencia****************************//

            $SURC_IdDepDestino=intval($Table['dependenciaActualId']);
            // echo "SURC_IdDepDestino=".$SURC_IdDepDestino.'<br>';


            $SURC_IdDepOrigen=intval($Table['dependenciaCargaId']);
            // echo "SURC_IdDepOrigen=".$SURC_IdDepOrigen.'<br>';

            $SiglaDep=trim($Table['dependenciaCargaSigla']);
            // echo "sigladep: ".$SiglaDep.'<br>';

            $SiglaDepACT=trim($Table['dependenciaActualSigla']);
            // echo "sigladepact: ".$SiglaDepACT.'<br>';


            if (substr($SiglaDepACT,0,2)=='GI') {//consultar si habria que agregar GD
                $SURC_Sumario_NroSumMPAct=$SURC_Sumario_NroSumMP.'-'.$SiglaDep;
                $SURC_Sumario_AnioAct=$SURC_Sumario_Anio;
                // echo "entro a GI:".$SURC_Sumario_NroSumMPAct.'anio actl:'.$SURC_Sumario_AnioAct.'<br>';
            }

            if (substr($SiglaDepACT,0,2)=='GD') {
                $SURC_Sumario_NroSumMPAct=$SURC_Sumario_NroSumMP.'-'.$SiglaDep;
                $SURC_Sumario_AnioAct=$SURC_Sumario_Anio;
            }

            $BandDerPropio= 0;
            if (empty($SURC_IdDepDestino) and (!empty($SURC_Sumario_NroSumMPAct))) {
                  $SURC_IdDepDestino=$SURC_IdDepOrigen;
                  $BandDerPropio=1;
            }

            if (!empty($SURC_IdDepDestino)) {
                          $SURC_IntercDpcia          = $SURC_IdDepOrigen;
                          $SURC_IdDepOrigen          = $SURC_IdDepDestino;
                          $SURC_IdDepDestino         = $SURC_IntercDpcia;
                          $SURC_Sumario_NroSumMPInter= $SURC_Sumario_NroSumMP;
                          $SURC_Sumario_NroSumMP     = $SURC_Sumario_NroSumMPAct;
                          $SURC_Sumario_NroSumMPAct  = $SURC_Sumario_NroSumMPInter;
                          $SURC_Sumario_AnioInter    = $SURC_Sumario_Anio;
                          $SURC_Sumario_Anio         = $SURC_Sumario_AnioAct;
                          $SURC_Sumario_AnioAct      = $SURC_Sumario_AnioInter;

                          // echo "proceso en ifnuevo";
                          // echo "SURC_IdDepOrigen=".$SURC_IdDepOrigen.'<br>';
                          // echo "SURC_IdDepDestino=".$SURC_IdDepDestino.'<br>';
                          // echo "SURC_Sumario_NroSumMP=".$SURC_Sumario_NroSumMP.'<br>';
                          // echo "SURC_Sumario_NroSumMPAct=".$SURC_Sumario_NroSumMPAct.'<br>';
                          // echo "SURC_Sumario_AnioInter=".$SURC_Sumario_AnioInter.'<br>';
                          // echo "SURC_Sumario_Anio=".$SURC_Sumario_Anio.'<br>';
                          // echo "SURC_Sumario_AnioAct=".$SURC_Sumario_AnioAct.'<br>';

                          include ('buscar_dependencia_origen.php');
                          // echo "SURC_Sumario_IdDependencia=".$SURC_Sumario_IdDependencia.'<br>';
                          // echo "SURC_Sumario_DescripDependencia=".$SURC_Sumario_DescripDependencia.'<br>';

                          if (empty($xml_t_errormysql)) {
                            // code...
                              include ('buscar_dependencia_destino.php');
                              // echo "SumarioComplementario=".$SumarioComplementario.'<br>';
                              // echo "SURC_Sumario_IdDepCompl=".$SURC_Sumario_IdDepCompl.'<br>';

                              if (empty($xml_t_errormysql)) {
                                  $SURC_Sumario_TextoRelato = $SumarioComplementario;
                                  // echo "SURC_Sumario_TextoRelato=".$SURC_Sumario_TextoRelato.'<br>';

                                  if ($BandDerPropio==0) {
                                        // echo "bandera es igual a 0 ingreso a carga complementaria".'<br>';
                                          include ('carga_complementario.php');
                                  }



                              }
                          }

            }else {
                  include ('buscar_dependencia_origen.php');
            }

            if (empty($xml_t_errormysql)) {
                    //**********Buscar Delito**********************************//

                    $contador=0;
                    if (!empty($Table1)) {
                      foreach ($Table1 as $nodotable => $valor) {
                        foreach ($valor as $key => $value) {
                            // echo "estes es el array".$nodotable."y su elemento es".$key."=$value"."<br>";

                          if ($contador==0) {

                              switch ($key) {
                                case 'delitoId':
                                    $SURC_IdHechoDelMP=intval($value);
                                    // echo $SURC_IdHechoDelMP."<br>";
                                    break;

                                case 'tentativo':
                                    $SURC_Sumario_Tentativa=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$value))));
                                    // echo $SURC_Sumario_Tentativa."<br>";
                                    break;


                                }//cierra switch

                          }//cierra if contador


                        }//cierra segundo foreach
                          $contador++;
                          if ($contador>0) {
                            break;
                          }
                      }//cierra primer foreach

                      //agregar los delitos nueva tabla
                      include ('buscar_hechodelictivo.php');

                  }else {

                            $SURC_Sumario_IdTipoDelitoMP=78; // A CARATULAR
                            $SURC_IdHechoDelMP=29;
                            $SURC_Sumario_DescripTipoDelitoMP="A CARATULAR";
                        }

            }



        if (empty($xml_t_errormysql)) {

                  //**********************tentativo****************************************//

                  if ($SURC_Sumario_Tentativa=='TRUE') {
                      $SURC_Sumario_Tentativa = "S";
                  }else {
                      $SURC_Sumario_Tentativa = "N";
                  }


                  //*************************hrExacta**********************************************//
                  $Cadena=mb_strtoupper(trim($Table['hrExacta']));

                  if ($Cadena=='SI') {
                      // echo "ingreso hora exacta si".'<br>';

                                $Sumario_FechaDel=trim($Table['fchHrHecho']);
                                $SURC_Sumario_FechaDel=date("Y-m-d",strtotime($Sumario_FechaDel));
                                // echo 'SURC_Sumario_FechaDel:'.$SURC_Sumario_FechaDel.'<br>';
                                $SURC_Sumario_HoraDel='1000-01-01'.' '.date('H:i:s',strtotime("$Sumario_FechaDel + 3 hours"));//cambiar la hora cuando deje funcionar gx
                                // echo 'SURC_Sumario_HoraDel:'.$SURC_Sumario_HoraDel.'<br>';


                }else {
                  // echo "ingreso hora exacta no".'<br>';
                            $Sumario_FechaDel=Trim($Table['fchHrHecho']);
                            $SURC_Sumario_FechaDel=date("Y-m-d",strtotime($Sumario_FechaDel));
                            // echo 'SURC_Sumario_FechaDel:'.$SURC_Sumario_FechaDel.'<br>';

                            $Sumario_HoraDel=trim($Table['hrHechoLibre']);
                            include ('validarhora.php');
                            // $SURC_Sumario_HoraDel='1000-01-01'.' '.'00:00:00';
                            // echo 'SURC_Sumario_HoraDel:'.$SURC_Sumario_HoraDel.'<br>';
                            }





                //******************************************************************************//

                //**************************fiscaliainterviniente*******************************//

                $Sumario_IdJuzFis=intval($Table['FiscaliaIntervinienteId']);
                // echo $Sumario_IdJuzFis.'<br>';

                $SURC_JuzgadoFiscalia_Descrip=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$Table['FiscaliaIntervinienteNombre']))));

                include ('buscar_juzgado_fiscalia.php');

                // echo $SURC_Sumario_IdJuzFis.'procesado'.'<br>';

                // echo utf8_encode($SURC_Sumario_DescripJuzFis).'<br>';


                //******************************************************************************//

                if (empty($xml_t_errormysql)) {
                  // $SURC_Sumario_NomCalle=trim($Table['lugarDelHecho']);
                  // echo "nombre calle lugar hecho como viene:".$SURC_Sumario_NomCalle.'<br>';
                  //************************lugar del hecho***************************************//
                  $SURC_Sumario_NomCalle='';
                  // $SURC_Sumario_NomCalle=mb_strtoupper(utf8_decode(mysqli_real_escape_string($conex_surc,$Table['lugarDelHecho'])));
                  // $SURC_Sumario_NomCalle=mb_strtoupper(utf8_encode(mysqli_real_escape_string($conex_surc,$Table['lugarDelHecho'])));
                  $SURC_Sumario_NomCalle=mb_strtoupper(trim($Table['lugarDelHecho']));
                  $SURC_Sumario_NomCalle=str_replace("'"," ",$SURC_Sumario_NomCalle);
                  $SURC_Sumario_NomCalle=substr($SURC_Sumario_NomCalle,0,40);


                  if (empty($SURC_Sumario_NomCalle)) {
                    // $SURC_Sumario_NomCalle1=mb_strtoupper(utf8_decode(mysqli_real_escape_string($conex_surc,$Table['CalleNombre'])));
                    // $SURC_Sumario_NomCalle2=mb_strtoupper(utf8_decode(mysqli_real_escape_string($conex_surc,$Table['LugarNro'])));

                    $SURC_Sumario_NomCalle1=mb_strtoupper(trim($Table['CalleNombre']));
                    $SURC_Sumario_NomCalle1=str_replace("'"," ",$SURC_Sumario_NomCalle1);
                    $SURC_Sumario_NomCalle2=mb_strtoupper(trim($Table['LugarNro']));
                    $SURC_Sumario_NomCalle2=str_replace("'"," ",$SURC_Sumario_NomCalle2);


                    $SURC_Sumario_NomCalle=$SURC_Sumario_NomCalle1.' '.$SURC_Sumario_NomCalle2;
                    $SURC_Sumario_NomCalle=substr($SURC_Sumario_NomCalle,0,40);

                  }

                  // echo $SURC_Sumario_NomCalle.'<br>';

                  //*****************************************************************************//

                  //**************************localidad******************************************//
                  $SURC_Sumario_DescripLocalidad=trim($Table['LocalidadNombre']);


                  include ('buscar_localidad.php');


                  //****************************************************************************//

                  if (empty($xml_t_errormysql)) {

                    //**************************relato******************************************//
                    $SURC_Sumario_TextoRelato=$SURC_Sumario_TextoRelato.mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$Table['Relato']))));


                    //****************************************************************************//

                    //**************************latitud******************************************//
                    $SURC_Sumario_CoordX=trim($Table['latitud']);


                    //****************************************************************************//

                    //**************************LONGITUD******************************************//
                    $SURC_Sumario_CoordY=trim($Table['longitud']);


                    //****************************************************************************//

                    //**************************via publica***************************************//
                    // foreach ($Table5 as $nodotable => $valor) {
                    //   foreach ($valor as $key => $value) {
                    //     //  echo "estes es el array".$nodotable."y su elemento es ".$key."=$value"."<br>";
                    //     // echo $key.'<br>';
                    //
                    //       if ($key=='viaPublica') {
                    //         // echo "ingreso";
                    //         $Sumario_DescripLugar=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$value))));
                    //         // code...
                    //       }//cierra if
                    //
                    //
                    //     }//cierra segundo for each
                    // }//cierra primer for each

                    $Sumario_DescripLugar=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$Table5['viaPublica']))));
                    // echo $Sumario_DescripLugar;

                    if ($Sumario_DescripLugar== "TRUE") {
                          $SURC_Sumario_Idlugar=1;
                          $SURC_Sumario_DescripLugar="VIA PUBLICA";
                    }else {
                          $SURC_Sumario_Idlugar=36; //SIN DEFINICION
                          $SURC_Sumario_DescripLugar="SIN DEFINICION";
                    }
                    // echo "SURC_Sumario_Idlugar:".$SURC_Sumario_Idlugar.'<br>';

                    //*****************************************************************************//
                    //**************************violencia familiar*********************************//
                    $HechoDelictivo_VIF=mb_strtoupper(trim($Table['esViolenciaFamiliar']));


                    if ($HechoDelictivo_VIF=='TRUE') {
                        $SURC_HechoDelictivo_VIF='S';
                    }else {
                        $SURC_HechoDelictivo_VIF='N';
                    }

                    //****************************************************************************//

                    //**************************MODALIDAD*********************************//
                    $Sumario_IdModalidad=intval($Table5['modalidadId']);

                    include ('buscar_modalidad.php');

                    //****************************************************************************//

                    if (empty($xml_t_errormysql)) {
                      //************************** VIOLENCIA DE GENERO*********************************//

                      $Sumario_ViolGenero=mb_strtoupper(trim($Table['esViolenciaDeGenero']));


                      if ($Sumario_ViolGenero=="TRUE") {
                        $SURC_Sumario_ViolGenero='S';

                      }else {
                        $SURC_Sumario_ViolGenero='N';
                      }


                      //****************************************************************************//

                      //************************** alerta video vigilancia*********************************//

                      $Sumario_AlertaVideoVig=mb_strtoupper(trim($Table['alertadosPorSistemaVideoVigilancia']));

                      if ($Sumario_AlertaVideoVig=='TRUE') {
                        $SURC_Sumario_AlertaVideoVig='S';
                      }else {
                        $SURC_Sumario_AlertaVideoVig='N';
                      }


                      //****************************************************************************//

                      //************************** medida solicitado victima*********************************//

                      $SURC_Sumario_MedidasSolVict=trim($Table['medidasSolicVictima']);


                      //****************************************************************************//

                      //************************** con secuestro *********************************//

                      $Sumario_ConSecuestros=mb_strtoupper(trim($Table['conSecuestro']));


                      if ($Sumario_ConSecuestros=='SI') {
                          $SURC_Sumario_ConSecuestros='S';

                      }else {
                          $SURC_Sumario_ConSecuestros='N';
                      }

                      //**************************Con detenidos**************************************************//

                      $Sumario_ConDetenidos=mb_strtoupper(trim($Table['conDetenidos']));


                      if ($Sumario_ConDetenidos=='SI') {
                        $SURC_Sumario_ConDetenidos='S';
                      }else {
                        $SURC_Sumario_ConDetenidos='N';
                      }


                      //****************************************************************************//

                      //**************************************testigo acta 1***************************************************//

                      $SURC_Sumario_Testigo1=trim($Table['testigoActo1']);

                      //****************************************************************************//

                      //**************************************testigo acta 2***************************************************//

                      $SURC_Sumario_Testigo2=trim($Table['testigoActo2']);

                      //****************************************************************************//


                      $SURC_Sumario_IdTipoSumario=intval($Table11['TipoInformeId']);
                      // echo $SURC_Sumario_IdTipoSumario;

                      $SURC_Sumario_Resultado=mb_strtoupper(utf8_encode(utf8_decode(mysqli_real_escape_string($conex_surc,$Table11['Resultado']))));
                      // echo $SURC_Sumario_Resultado;

                      $SURC_Sumario_NroDciaMPVinculo=trim($Table12['DenunciaPadreId']);


                      //**************************************************************************************************************************//

                      //*********ALTA DE SUMARIO ID*****************************************************************************************************************//

                      include ('alta_sumario_nuevo.php');

                      //**************************************************************************************************************************//



                    }

                  }
                }
        }




























 }else {
      $xml_t_errormysql="Error: La ejecución de la consulta falló debido a:".mysqli_error($conex_surc);
 }








?>
