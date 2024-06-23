<?php

session_start();
require_once ('segacceso/segacceso.php');
require_once ('connections/connsegusuario.php');
require_once ('uspermisos.php');
require_once ('connections/connsurc.php');
require_once ('connections/conndbseg.php');

date_default_timezone_set('America/Argentina/Salta');

if (isset($_REQUEST['tab'])) {
	$activo = $_REQUEST['tab'];
} else {
	$activo = 0;
}




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'head.php' ?>
    <link rel="stylesheet" type="text/css" href="css/abm.css?v=2.033">

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
    <article id="artwo">
        <div class="titulo">
            <img src="imagenes/administrador.png" height="32px" width="33px">
            <div class="postitulo">Sumario del Ministerio Público Fiscal</div>
        </div>

        <ul class="tabs group">
          <li <?php if ($activo==0) echo 'class="active"' ?>> <a href="sum_d.php?tab=0">General</a></li>
          <li <?php if ($activo==1) echo 'class="active"' ?> ><a href="sum_d.php?tab=1">Hecho</a> </li>
          <li <?php if ($activo==2) echo 'class="active"' ?>> <a href="sum_d.php?tab=2">Personas</a> </li>
          <li <?php if ($activo==3) echo 'class="active"' ?>> <a href="sum_d.php?tab=3">Elementos</a> </li>
          <li <?php if ($activo==4) echo 'class="active"' ?>> <a href="sum_d.php?tab=4">Ampliaciones</a> </li>
          <li <?php if ($activo==5) echo 'class="active"' ?>> <a href="sum_d.php?tab=5">Actuaciones</a> </li>
          <li <?php if ($activo==6) echo 'class="active"' ?>> <a href="sum_d.php?tab=6">Estado</a> </li>
          <li <?php if ($activo==7) echo 'class="active"' ?>> <a href="sum_d.php?tab=7">Solicitudes</a> </li>
        </ul>


    </article>


  </section>
  <div id="footer"><?php include ('footer.php');?></div>


  </script>

</body>
</html>
