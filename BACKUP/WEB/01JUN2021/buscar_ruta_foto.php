<?php
  $ruta_foto='';
    $foto="SELECT * FROM rrhh.view_ult_foto
              WHERE rrhh_fotospers_Legajo='$row_rrhh_legajo[legajo]';";

    if ($rrhh_foto=mysqli_query($connrrhh,$foto)) {
            $row_rrhh_foto=mysqli_fetch_array($rrhh_foto);
            $num_rrhh_foto=$rrhh_foto->num_rows;
            if ($num_rrhh_foto>0) {
              $ruta_foto='/rh-sips/'.$row_rrhh_foto['rrhh_fotospers_rutaimagen'];
            }
    }else {
        $errormysql="Error: La ejecución de busqueda ruta foto debido a:".mysqli_error($connrrhh);
        echo $errormysql.'<br>';
    }

 ?>
