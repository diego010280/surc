<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once('connections/connsegusuario.php');

date_default_timezone_set('America/Argentina/Salta');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <script type="text/javascript" defer src="js/jquery-3.2.1.min.js"></script>
    <script src="js/plotly-2.3.0.min.js"></script>
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

  <section class="fondoalerta">
    <article class="segundoalerta">
      <ul id="navegadorrep">
        <li><a class="enla active" href="#" id="reprel">Rep. Hechos Relevantes</a></li>
        <li><a href="#" class="enla" id="topdiez">Rep. Top 10 Hechos</a></li>
      </ul> 
      <div class="tablealerta" id="reprelev" >
        <?php include 'delitos_reporte.php' ?>
        <?php include 'graficoreporte.php' ?>
      </div>

      <div class="tablealerta" id="topten">
        <div class="reportess2" id="reportess1">
        <?php include 'delitos_reporte2.php' ?>
        </div>
        <div class="reportess2" id="reportess2">
        <?php include 'graficoreporte2.php' ?>
        </div>
      </div> 

     </article>
  </section>
<script type="text/javascript" defer src="js/reportes.js"></script>
  <div id="footer"><?php include ('footer.php');?></div>
</body>
</html>
 