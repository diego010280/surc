<?php

if (empty($_SESSION['logged']) or $_SESSION['moduleid'] < 1 ) {

 header("Location:../acceso/login.php?access=private" ); 

} else {

   require_once ('../acceso/segacceso/tiempoespera.php');
    
   if ($tiempotransc>$tiempoespera){
        
        session_destroy();

        header('Location: ../acceso/login.php?access=timeout');
        
    } else {$_SESSION['start']=$ahora;} 
    
}
?>