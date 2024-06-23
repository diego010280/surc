<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/estilomap.css">
    <!-- <script src="js/map.js"></script> -->
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
      <td>Clasificación Delito (M.P.)</td>
      <td>Dependencia Policial</td>
      <td>Fiscalía</td>
    </tr>
    <tr>
      <td> <input type="text" name="SURC_TipoDelito_Descripc" class="w18" value="<?= utf8_encode($row_sumarios['Caratula']) ?>" readonly> </td>
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
      <td>Lugar de Ocurrencia</td>
      <td>Nomb. Calle</td>
      <td>Alt. Calle</td>
      <td>Piso</td>
      <td>Dpto.</td>
      <td>Mza.</td>
      <td>Lote</td>
    </tr>
    <tr>
      <td> <input type="text" name="SURC_Sumario_FechaDel" class="w5" value="<?= date("d-m-Y",strtotime($row_sumarios['Fecha_Delito'])) ?>" readonly> </td>
      <td> <input type="text" name="SURC_Sumario_HoraDel" class="w4" value="<?php if (!empty($row_sumarios['Hora_Delito'])) {
          echo date('H:i:s',strtotime("$row_sumarios[Hora_Delito] - 3 hours"));}?>" readonly> </td>
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
          <div id="map">
            <script type="text/javascript">
            function iniciarMap(){
                var coord = {lat:<?php echo $row_sumarios['Coord_X']; ?> ,lng:<?php echo $row_sumarios['Coord_Y']; ?>};
                var map = new google.maps.Map(document.getElementById('map'),{
                  zoom: 10,
                  center: coord
                });
                var marker = new google.maps.Marker({
                  position: coord,
                  map: map
                });
            }

            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=iniciarMap"></script>

          </div>

        </td>
      </tr>
  </table>



  <!-- <tr>
    <td id="map">

    </td>
        </tr> -->

  <!-- <div class="btn_pos">
      <form action="consulta_sum.php" method="get">
          <input type="hidden" name="nrosumario_mp" value="<?php //echo $_SESSION['nrosumario_mp']; ?>">
          <input type="hidden" name="go_back" value="<?php //echo $_SESSION['go_back']; ?>">
          <input type="hidden" name="palabra_clave" value="<?php //echo $_SESSION['palabra_clave']; ?>">
          <input type="hidden" name="anio" value="<?php //echo $_SESSION['anio']; ?>">
          <input type="hidden" name="SURC_TipoSum_Id" value="<?php //echo $_SESSION['SURC_TipoSum_Id']; ?>">
          <input type="hidden" name="SURC_OrigenSumario_Id" value="<?php //echo $_SESSION['SURC_OrigenSumario_Id']; ?>">
          <input type="hidden" name="SURC_CCO_Id" value="<?php //echo $_SESSION['SURC_CCO_Id']; ?>">
          <input type="hidden" name="SURC_Sectores_Id" value="<?php //echo $_SESSION['SURC_Sectores_Id']; ?>">
          <input type="hidden" name="DepPol_Codigo" value="<?php ////echo $_SESSION['DepPol_Codigo']; ?>">
          <input type="hidden" name="DepPol_Codigo1" value="<?php //echo $_SESSION['DepPol_Codigo1']; ?>">
          <input type="hidden" name="desdehecho" value="<?php //echo $_SESSION['desdehecho']; ?>">
          <input type="hidden" name="hastahecho" value="<?php //echo $_SESSION['hastahecho']; ?>">
          <input type="hidden" name="desdecarga" value="<?php //echo $_SESSION['desdecarga']; ?>">
          <input type="hidden" name="hastacarga" value="<?php //echo $_SESSION['hastacarga']; ?>">
          <input type="hidden" name="SURC_TipoGrDelito_Id" value="<?php// echo $_SESSION['SURC_TipoGrDelito_Id']; ?>">
          <input type="hidden" name="SURC_HechoDelictivo_Id" value="<?php// echo $_SESSION['SURC_HechoDelictivo_Id']; ?>">
          <input type="hidden" name="SURC_Modalidad_Id" value="<?php //echo $_SESSION['SURC_Modalidad_Id']; ?>">
          <input type="hidden" name="UnidadReg_Codigo" value="<?php //echo $_SESSION['UnidadReg_Codigo']; ?>">
          <input type="hidden" name="posi" value="<?php //echo $_SESSION['posi']; ?>">
          <input type="hidden" name="total_registros" value="<?php //echo $_SESSION['total_registros']; ?>">

          <button type="submit"  class="btnGyC" >Volver</button>

      </form>
  </div> -->

  <!-- <?php
/*  unset($_SESSION['SURC_Sumario_Id']);
  unset($_SESSION['nrosumario_mp']);
  unset($_SESSION['palabra_clave']);
  unset($_SESSION['anio']);
  unset($_SESSION['SURC_TipoSum_Id']);
  unset($_SESSION['SURC_OrigenSumario_Id']);
  unset($_SESSION['SURC_CCO_Id']);
  unset($_SESSION['SURC_Sectores_Id']);
  unset($_SESSION['DepPol_Codigo']);
  unset($_SESSION['DepPol_Codigo1']);
  unset($_SESSION['desdehecho']);
  unset($_SESSION['hastahecho']);
  unset($_SESSION['desdecarga']);
  unset($_SESSION['hastacarga']);
  unset($_SESSION['SURC_TipoGrDelito_Id']);
  unset($_SESSION['SURC_HechoDelictivo_Id']);
  unset($_SESSION['SURC_Modalidad_Id']);
  unset($_SESSION['UnidadReg_Codigo']);
  unset($_SESSION['go_back']);
  unset($_SESSION['UnidadReg_Codigo']);
  unset($_SESSION['posi']);
  unset($_SESSION['total_registros']);

  */

   ?> -->


  </body>
</html>
