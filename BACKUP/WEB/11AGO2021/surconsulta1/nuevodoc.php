<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once('connections/connsegusuario.php');
require_once('uspermisos.php');

date_default_timezone_set('America/Argentina/Salta');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php' ?>
</head>
<body>

    <header>
		  <div id="main">
			<div id="logo"><?php include 'logotipo.php' ?></div>
			<div id="opt-usuario"><?php include 'datoscuenta.php' ?></div>
			  </div>
	</header>

	<nav id="nav">
  		<?php include 'menu.php' ?>
  	</nav>
    
	<section>
	
	<section/>
       
        
    <div id="footer"><?php include ('footer.php');?></div>
        
    
    
    
    
    
</body>
</html>