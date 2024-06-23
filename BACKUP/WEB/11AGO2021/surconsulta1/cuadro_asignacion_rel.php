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

  <div class="alerta" id="alerta"  >
  <strong>CARGA REGISTRADA</p></strong> 
  </div>
  <div class="alerta2" id="alerta2"  >
  <strong>CONSULTA BORRADA</p></strong> 
  </div>

  <section class="fondoalerta" id="secciontablero">
    <article class="segundoalerta">     
    <div class="tablealerta"> 
    
    <h1 class="stit">Tabla de mando de registros relevantes</h1>
    <div class="cont_der">
        <button class="boton" id="agconsul">Agregar consulta</button>
    </div>
    <div class="listado">  
    <table style="width:100%" id="tabalerta" class="tab" >
        <tr>
            <th style="width:10%">Nº </th>
            <th style="width:30%">Hecho Delictivo</th>
            <th style="width:30%">Modalidad</th>
            <th style="width:10%">Accion</th>
        </tr> 
        <tbody id="alert_reportes">
        </tbody>
    </table>
    </div>
    <div class="alertasinregistro" id="sinreg3"><p >NO HAY REGISTRO PARA MOSTRAR</p></div>
   </div>
  </article> 
  </section>

  <section class="fondoalerta" id="seccionabm">
      <article class="segundoalerta">     
        <div class="tablealerta middle"> 
         <div class="pos_tit">
                            <h1 class="stit">Agregar variables de consulta</h1>
                      </div>

                      <form  id="enviar"  method="get">
                          <input type="hidden" name="alta" value="alta">
                          <table>
                              <tr>
                                <th>Seleccion Delito:</th>
                                <td>
                                <select class="selectoress" name="hechodelict" id="hechodelict" required>
                                      <option value="">Seleccionar Hecho delictivo</option>
                                    </select>
                                </td>
                              </tr>
                              <tr><td>&nbsp;</td></tr>
                              <tr><td>&nbsp;</td></tr>
                              <tr><input type="hidden" name="comprobar" id="comprobar" value="1"></tr>
                              <tr>
                                <th>Seleccion Modalidad:</th>
                                <td>
                                    <select  class="selectoress" name="modal" id="modal">
                                      <option value="0">Seleccionar Modalidad</option>
                                    </select>
                                </td>
                              </tr>
                              
                          </table>
                              <div class="btn_pos">
                                <button class="boton" form="enviar" >&emsp;Guardar&emsp;</button>&ensp;
                                <button class="boton1" id="regresar">&emsp;Cancelar&emsp;</button>&emsp;
                              </div>
                    </form>
        </div>
      </article> 
  </section>
 
  <script type="text/javascript" defer src="js/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" defer src="js/reportes.js"></script>
  <div id="footer"><?php include ('footer.php');?></div>
</body>
</html>