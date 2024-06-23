<?php
$esmenor='';
  $existe="SELECT * FROM surc.surc_sumariopersona
        where SURC_Sumario_Id='$row_sumarios[SURC_Sumario_Id]';";

        if ($menor_existe=mysqli_query($conex_surc,$existe)) {
                    $row_menor_existe=mysqli_fetch_array($menor_existe);
                    // $num_menor_existe=$menor_existe->num_rows;

                    do {
                      if (!empty($row_menor_existe['SURC_PersonaSumario_EsMenor'])) {
                          if ($row_menor_existe['SURC_PersonaSumario_EsMenor']=='S') {
                                $esmenor='S';
                                break;
                          }else {
                            $esmenor='N';
                          }

                      }
                    } while ($row_menor_existe=mysqli_fetch_array($menor_existe));
          }else {
            die("Problemas con el busqueda persona : ".mysqli_error($conex_surc));
            
          }


 ?>
