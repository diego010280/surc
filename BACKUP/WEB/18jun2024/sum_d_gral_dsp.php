<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/estilomap.css">
    <script src="js/hora.js?v=2.0.126"></script>
  </head>
  <body>

    <!-- <form class="" action="consulta_d.php" method="post" autocomplete="off" id="general"> -->
    <!-- <input type="hidden" name="SURC_Sumario_Id" value="<?= $SURC_Sumario_Id ?>"> -->
    <table class="plus conmargen">
      <tr>
          <td>
              <b> Datos del Sumario </b>
              <br>
          </td>
		  <?php if (!empty($_SESSION['vif_legajo_id']) and (empty($_SESSION['id_vif_ap']))) { ?>
		  <td>
			<form action="../vif/segacceso/checks_intermod.php" method="post">
				<button class="btnGyCvif" name="boton_surc_vif">GUARDAR EN VIF&nbsp;&raquo;</button>
				<input type="hidden" name="usuarioid" value="<?= $_SESSION['usuario_id'] ?> "> 
				<input type="hidden" name="usuariochar" value="usu"> 
				<input type="hidden" name="moduloid" value="<?= $_SESSION['modulovif']  ?>">
				<input type="hidden" name="sumario_id" value="<?= $row_sumarios['SURC_Sumario_Id'] ?> ">
				<input type="hidden" name="vif_legajo_id" value="<?php echo ($_SESSION['vif_legajo_id']) ?>">				
			</form>
		  </td>
		  <?php
		  }
		  ?>
		  <?php if (!empty($_SESSION['id_vif_ap'])) { ?>
		  <td>
			<form action="../vif/segacceso/checks_intermod_editar.php" method="post">
				<button class="btnGyCvif" name="boton_surc_vif">GUARDAR EN VIF&nbsp;&raquo;</button>
				<input type="hidden" name="usuarioid" value="<?= $_SESSION['usuario_id'] ?> "> 
				<input type="hidden" name="usuariochar" value="usu"> 
				<input type="hidden" name="moduloid" value="<?= $_SESSION['modulovif'] ?>">
				<input type="hidden" name="sumario_id" value="<?= $row_sumarios['SURC_Sumario_Id'] ?> ">
				<input type="hidden" name="vif_legajo_id" value="<?php echo ($_SESSION['vif_legajo_id']) ?>">
				<input type="hidden" name="vif_ap_id" value="<?php echo ($_SESSION['id_vif_ap']) ?>">				
			</form>
		  </td>
		  <?php
		  }
		  ?>
      </tr>
    </table>
  <table class="plus conmargen">

      <tr>
        <td>Fecha Sum.</td>
        <td>Hora Sum.</td>
        <td>Nro.Sum. (M.P.)</td>
        <td>Año</td>
        <td>Nro. XML</td>
        <td>Origen Sumario</td>
        <td>Tipo Sumario </td>
      </tr>
      <tr>
        <td> <input type="text" name="SURC_Sumario_FechaSum" maxlength="12" class="w5" value="<?= date("d-m-Y",strtotime($row_sumarios['Fecha_Carga'])) ?>" readonly> </td>
        <td> <input type="text" name="SURC_Sumario_HoraSum" class="w4" value="<?php if (!empty($row_sumarios['Hora_Carga'])) {
            echo date('H:i:s',strtotime("$row_sumarios[Hora_Carga] - 3 hours"));}?>" readonly> </td>
        <td> <input type="text" name="SURC_Sumario_NroSumMP" class="wchico" value="<?= $row_sumarios['NroSumario_MP'] ?>" readonly> </td>
        <td> <input type="text" name="SURC_Sumario_Anio" maxlength="4" style="width:60px" value="<?= $row_sumarios['Anio'] ?>" readonly> </td>
        <td> <input type="text" name="SURC_Sumario_NroDenunciaMP" class="wchico"value="<?= $row_sumarios['xml'] ?>" readonly> </td>
        <td> <input type="text" name="SURC_OrigenSumario_Descrip" class="w18" value="<?= utf8_encode($row_sumarios['Origen_Sumario']) ?>" readonly> </td>
        <td> <input type="text" name="SURC_TipoSum_Descrip" class="w18" value="<?= utf8_encode($row_sumarios['Tipo_Sumario']) ?>" readonly> </td>

      </tr>

  </table>
  <table class="plus conmargen">
    <tr>
      <td>Clasificación Delito SURC (M.P.)</td>
      <?php if (!empty($row_caratula['surc_caratulas_desc'])) {?>
        <td style="color:red;">Delitos del XML (M.P.) para tener en cuenta</td>
    <?php  } ?>


    </tr>
    <tr>
      <td> <input type="text" name="SURC_TipoDelito_Descripc" class="w18" value="<?= utf8_encode($row_sumarios['Caratula']) ?>" readonly> </td>
      <?php if (!empty($row_caratula['surc_caratulas_desc'])) {?>
        <td>
          <input type="text" name="" style="color:red;" class="w50" value="<?= utf8_encode($row_caratula['surc_caratulas_desc']) ?>"readonly>
        </td>
    <?php  } ?>

    </tr>
  </table>

    <table class="plus conmargen">
      <tr>
        <td>Dependencia Policial</td>
        <td>Fiscalía</td>
      </tr>
      <tr>
        <td> <input type="text" name="DepPol_Descrip" class="w21" value="<?= utf8_encode($row_sumarios['Dependencia']) ?>" readonly> </td>
        <td> <input type="text" name="SURC_JuzgadoFiscalia_Descrip" class="w21" value="<?= utf8_encode($row_sumarios['Fiscalia']) ?>" readonly> </td>
      </tr>

    </table>

  <table class="plus conmargen">
    <tr>
      <td> <b>Datos del Hecho</b>
            <br>
      </td>
    </tr>
  </table>

  <table class="plus conmargen">
    <tr>
      <td>Fecha Delito</td>
      <td>Hora Delito</td>
      <td id="tit_horaimprecisa" 
        <?php
          if (!empty($row_sumarios['Hora_Delito'])) {
           echo 'class="hide"';
          }
        ?> 
        >Hora Imprecisa</td>
    </tr>
    <tr>
      <td> <input type="text" name="SURC_Sumario_FechaDel" class="w5" value="<?= date("d-m-Y",strtotime($row_sumarios['Fecha_Delito'])) ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_HoraDel" class="w4" value="<?php if (!empty($row_sumarios['Hora_Delito'])) {
          echo date('H:i',strtotime("$row_sumarios[Hora_Delito] - 3 hours"));}?>" readonly> </td> 
          
      <td id="val_horaimprecisa" 
        <?php
          if (!empty($row_sumarios['Hora_Delito'])) {
           echo 'class="hide"';
          }
        ?> 
        >        
        <input type="text" name="SURC_Sumario_horaimpr" id="select_horaimprecisa" class="w18" value="<?php
        if ($row_sumarios['SURC_Sumario_horaimpr'] == 1) {
          echo 'Mañana';
        }elseif ($row_sumarios['SURC_Sumario_horaimpr'] == 2) {
          echo 'Tarde';
        }elseif ($row_sumarios['SURC_Sumario_horaimpr'] == 3) {
          echo 'Noche';
        }?>" readonly>
      </td>
           
    </tr>
  </table>

    <table class="plus conmargen">
    <tr>
      <td>Lugar de Ocurrencia</td>
      <td>Nomb. Calle</td>
      <td>Alt. Calle</td>
      <td>Piso</td>
      <td>Dpto.</td>
      <td>Mza.</td>
      <td>Lote</td>
    </tr>
    <tr>
      
      <td> <input type="text" name="SURC_Lugar_Descrip" class="w18" value="<?= utf8_encode($row_sumarios['Lugar_Hecho']) ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_NomCalle" class="w21" value="<?= utf8_encode($row_sumarios['Nom_Calle']) ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_AltCalle" class="wchico" value="<?= $row_sumarios['Alt_Calle'] ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_Piso" class="wchico" value="<?= $row_sumarios['Piso'] ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_Dpto" class="wchico" value="<?= $row_sumarios['Dpto'] ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_Mza" class="wchico" value="<?= $row_sumarios['Mza'] ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_CasaLote" class="wchico" value="<?= $row_sumarios['lote'] ?>" readonly> </td>
    </tr>

    </table>

  <table class="plus conmargen">
    <tr>
      <td>Localidad</td>
      <td>Barrio</td>
      <td>Cuadrícula</td>
    </tr>
    <tr>
      <td> <input type="text" name="Localidad_Descrip" class="w18" value="<?= utf8_encode($row_sumarios['Localidad']) ?>" readonly> </td>
      <td> <input type="text" name="Barrio_Descrip" class="w18" value="<?= utf8_encode($row_sumarios['Barrio']) ?>" readonly> </td>
      <td> <input type="text" name="Localidad_Descrip" class="w18" value="<?= utf8_encode($row_sumarios['Cuadricula']) ?>" readonly> </td>
    </tr>
  </table>


  <table class="plus conmargen" style="width:100%;">
    <tr>
      <td>Texto o Relato</td>
    </tr>
    <tr>
      <td> <textarea name="SURC_Sumario_TextoRelato" rows="10" style="overflow-y:scroll; min-width:100%; text-align:justify;" readonly ><?= utf8_encode($row_sumarios['Descrip_Hecho']) ?></textarea> </td>
    </tr>
  </table>

  <?php if ($num_row_ampliacion>0) {?>
    <table class="plus conmargen" style="width:100%;">
      <tr>
        <td><b>Ampliaciones Realizadas</b></td>
      </tr>
    </table>
      <?php include 'sum_d_ampl_dsp.php'; ?>
  <?php } else {?>
    <table class="plus conmargen">
      <tr>
        <td><b>Ampliaciones Realizadas</b></td>

      </tr>
      <tr>
        <td>
            <input type="text" name="" class="w21" value="No se registraron ampliaciones..." readonly>

        </td>
      </tr>
    </table>
  <?php } ?>

  <table class="plus conmargen">
      <tr>
        <td>  <b>Ubicación</b>
        </td>
      </tr>
      <tr>
          <td>Latitud (Coordenada "X")</td>
          <td>
            <input type="text" name="SURC_Sumario_CoordX" class="w18" value="<?= utf8_encode($row_sumarios['Coord_X']) ?>" readonly>
          </td>
          <td><br><br></td>
          <td>Longitud (Coordenadas "Y")</td>
          <td>
            <input type="text" name="SURC_Sumario_CoordY" class="w18" value="<?= utf8_encode($row_sumarios['Coord_Y']) ?>" readonly>
          </td>

      </tr>

  </table>
  <table class="plus conmargen" style="width:50%;">
      <tr>
        <td>
          <!-- <img src="imagenes/sin_mapa.png" alt=""> -->
          <?php include 'maptiler_dsp.php'; ?>

        </td>
      </tr>
  </table>




  </body>
</html>
