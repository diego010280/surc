<?php
$utilizado='';
$sustraido='';
$secuestrado='';

  $elemento="SELECT * FROM surc.surc_sumarioelemento
        where SURC_Sumario_Id='$row_sumarios[SURC_Sumario_Id]';";

        if ($tipo_elemento=mysqli_query($conex_surc,$elemento)) {
                    $row_tipo_elemento=mysqli_fetch_array($tipo_elemento);
                    // $num_menor_existe=$menor_existe->num_rows;

                    do {
                      if ($row_tipo_elemento['SURC_SumarioElemento_IdForma']==1) {

                          $utilizado='S';

                      }elseif ($row_tipo_elemento['SURC_SumarioElemento_IdForma']==2) {
                        $sustraido='S';
                      }elseif ($row_tipo_elemento['SURC_SumarioElemento_IdForma']==3) {
                        $secuestrado='S';
                      }


                    } while ($row_tipo_elemento=mysqli_fetch_array($tipo_elemento));
          }else {
            die("Problemas con el busqueda elemento : ".mysqli_error($conex_surc));
          }

 ?>
