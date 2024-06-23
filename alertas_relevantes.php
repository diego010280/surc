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
  <div class="tablealerta"> 
    <nav class="selectoralerta">
               <div class="selectorbusq">
                   <table class="tablaselectores">
                       <tr>
                           <td>
                           <label for="Selectorzona" class="labelalerta">Zona</label>
                           </td>
                           <td class="selectortdsector">
                           <label for="Selectorsector" class="labelalerta">Sector</label>
                           </td>
                           <td>
                           <label for="Selectorfecha" class="labelalerta">Fecha</label>
                           </td>
                          </tr>
                       <tr>
                           <td class="selectortdsector">
                           <div class="selectorsel"> 
                                <select  class="selectoress" name="selectorzon" id="selectorzon">
                                   </select>
                              </div>
                           </td>
                           <td class="selectortdsector">
                           <div class="selectorsel"> 
                                <select class="selectoress" name="selectorsec" id="selectorsec">
                                </select>
                              </div>
                           </td>
                           <td class="selectortdsector">
                           <div class="selectorsel"> 
                                <input class="selectoress" type="date" name="fechaconsulta" id="fechaconsulta" value="">
                              </div>
                           </td>
                       </tr>
                        
                   </table>
                  
                </div>
                <input class="boton" type="button" value="Consulta" id="consulta">         
    </nav>   

  <div class="listado">  
    <table style="width:100%" id="tabalerta" class="tab" >
       
           <tr>
            <th style="width:5%"></th>
            <th style="width:10%">Nº Act.</th>
            <th style="width:20%">Dependencia</th>
            <th style="width:25%">Hecho Delic.</th>
            <th style="width:15%">Modalidad</th>
            <th style="width:20%">Fecha y Hora Carga</th>
            <th style="width:5%">Fecha Hecho</th>
            </tr> 
       
        <tbody id="reportesalertas">
        </tbody>
    </table>
    <div class="alertasinregistro" id="noreg"><p>NO HAY REGISTRO PARA MOSTRAR</p></div>
    <div class="cargando" id="noregcarg"> <img src="imagenes/iconos/cargando.gif" alt="cargando"></div>
    </div>
   </div>
  </article> 
  </section>
  <script type="text/javascript" defer src="js/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" defer src="js/reportes.js"></script>
  <div id="footer"><?php include ('footer.php');?></div>
</body>
</html>