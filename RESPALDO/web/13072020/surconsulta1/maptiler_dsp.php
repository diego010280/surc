<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

    <style>
      #map { height: 600px;}
    </style>

  </head>
  <body>
    <div id="map">
      <script>
          var map= L.map('map').setView([<?php echo $row_sumarios['Coord_X']; ?>, <?php echo $row_sumarios['Coord_Y']; ?>], 15);
          L.tileLayer('https://api.maptiler.com/maps/streets/256/{z}/{x}/{y}.png?key=Z9utiQmGtSf9uinbfDZT', {
	        maxZoom: 18,
          },{
          attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>,'
          }).addTo(map);

          var marker = L.marker([<?php echo $row_sumarios['Coord_X']; ?>, <?php echo $row_sumarios['Coord_Y']; ?>]).addTo(map);

      </script>

    </div>

  </body>
</html>
