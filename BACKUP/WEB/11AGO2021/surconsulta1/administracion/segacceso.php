<?php

if (empty($_SESSION['logged']) or $_SESSION['moduleid'] < 1 ) {

 header("Location:../acceso/login.php?access=private" ); 

} else {
       
    // ver usuario 
    require_once('Connections/connsegusuario.php');
    
    $control= mysqli_query ($connusuario, "SELECT usuario_estado FROM segusuario.usuarios WHERE usuario_id='$_SESSION[usuario_id]'") or  die("Problemas en el select usuarios:".mysqli_error($connusuario));
        
    $row_control = mysqli_fetch_array($control);
    
    if ($row_control['usuario_estado']==0){
        
        header('Location: ../acceso/login.php?err=usinact');
        
    } else {
    

   require_once ('../acceso/segacceso/tiempoespera.php');
    
   if ($tiempotransc>$tiempoespera){
        
        session_destroy();

        header('Location: ../acceso/login.php?access=timeout');
   } else {$_SESSION['start']=$ahora;}
    
    }   
    
}


?>