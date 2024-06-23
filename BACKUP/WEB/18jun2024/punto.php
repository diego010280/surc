<?php
	$x=-23.3938119150996;
	$y=-64.42493319511414;





?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Obtener coordenadas de un marcador</title>

    <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    #map {
      width: 100%;
      height: 80%;
    }
    #coords{width: 500px;}
    </style>
  </head>
  <body>
    <div id="map"></div>

  <input type="text" id="coords" />
  <script>


var marker;          //variable del marcador
var coords = {};    //coordenadas obtenidas con la geolocalización

//Funcion principal
initMap = function ()
{

  //usamos la API para geolocalizar el usuario
      navigator.geolocation.getCurrentPosition(
        function (position){
          coords =  {
            lng:<?php echo $y; ?>, //y
            lat:<?php echo $x; ?> //x
          };
          setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa


        },function(error){console.log(error);});

}



function setMapa (coords)
{
    //Se crea una nueva instancia del objeto mapa
    var map = new google.maps.Map(document.getElementById('map'),
    {
      zoom: 13,
      center:new google.maps.LatLng(coords.lat,coords.lng),

    });

    //Creamos el marcador en el mapa con sus propiedades
    //para nuestro obetivo tenemos que poner el atributo draggable en true
    //position pondremos las mismas coordenas que obtuvimos en la geolocalización
    marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: new google.maps.LatLng(coords.lat,coords.lng),

    });
    //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
    //cuando el usuario a soltado el marcador
    marker.addListener('click', toggleBounce);

    marker.addListener( 'dragend', function (event)
    {
      //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
      document.getElementById("coords").value = this.getPosition().lat()+","+ this.getPosition().lng();

    });
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
if (marker.getAnimation() !== null) {
  marker.setAnimation(null);
} else {
  marker.setAnimation(google.maps.Animation.BOUNCE);
}
}

// Carga de la libreria de google maps

  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>

	<!-- <?php
// $datos = "<script>coords.lat</script>";
// echo 'algo'.$datos;

//$valor = $_POST["coords"];
//echo 'algo'.$valor; 
?> -->
  </body>
</html>
