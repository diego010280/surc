<?php
  $letra=utf8_encode(utf8_decode($_REQUEST['letra']));
  $segundaletra=mb_strtoupper($letra);
  echo $segundaletra;
 ?>
 <!DOCTYPE html>
 <html lang="es" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <form class="" action="pruebautf8.php" method="get">
       <input type="text" name="letra" value="">
       <button type="submit" name="prueba">BUSCAR</button>

     </form>

   </body>
 </html>
