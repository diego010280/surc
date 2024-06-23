<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script> -->

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
      integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
      crossorigin="" />

      <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
        integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>

    <style>
      #map { height: 600px;}
    </style>

  </head>
  <body>
    <div id="map">
      <script>
          let map= L.map('map').setView([<?php if (!empty($row_sumarios['Coord_Y'])) {
            echo $row_sumarios['Coord_X'];
          }else {?>
            -24.7859
        <?php  }  ?>,<?php if (!empty($row_sumarios['Coord_Y'])) {
            echo $row_sumarios['Coord_Y'];
        }else {?>
            -65.41166
      <?php } ?>], 15);

          // L.tileLayer('https://api.maptiler.com/maps/streets/256/{z}/{x}/{y}.png?key=Z9utiQmGtSf9uinbfDZT', {
	        // maxZoom: 18,
          // },{
          // attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>,'
          // }).addTo(map);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution:
              '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);

          map.on('click', function(e){
                  setPointData(e.latlng);
                  })

          function setPointData(position) {
            document.getElementById('lat').value = position.lat;
            document.getElementById('lng').value = position.lng;
          }

          var marker = L.marker([<?php if (!empty($row_sumarios['Coord_Y'])) {
            echo $row_sumarios['Coord_X'];
          }else {?>
            -24.7859
        <?php  }  ?>,<?php if (!empty($row_sumarios['Coord_Y'])) {
            echo $row_sumarios['Coord_Y'];
        }else {?>
            -65.41166
      <?php } ?>],{
            draggable: 'true'
          }).addTo(map);

          marker.on('dragend', function() {
            console.log('dragend', marker.getLatLng());
            let position = marker.getLatLng();;
            marker
              .setLatLng(position)
                .bindPopup(position)
                  .update();
                    setPointData(position);
});

      </script>

    </div>

  </body>
</html>
