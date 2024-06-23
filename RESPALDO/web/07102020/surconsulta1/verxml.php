<?php

if (!empty($_REQUEST['ubicacion'])) {
    $ubicacion_archivo="../xml/".$_REQUEST['ubicacion'];

    if (!empty($_REQUEST['xml'])) {
      $nombre_archivo="denuncia_".$_REQUEST['xml'].".xml";
      header("Content-disposition: attachment; filename=$nombre_archivo");

      header("Content-Type: text/xml");
         // header("Content-Length: ".strlen($cuerpo));
      header("Pragma: no-cache");
      header("Expires: 0");
      readfile($ubicacion_archivo);
    }
}



// $ubicacion_archivo="../xml/deposito/xml_archivados/Anio 2020/OCTUBRE/denuncia_2707843.xml";


// $nombre_archivo="denuncia_2707843.xml";



 ?>
