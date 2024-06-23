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
          let map= L.map('map').setView([-24.7859, -65.41166], 15);
          L.tileLayer('https://api.maptiler.com/maps/streets/256/{z}/{x}/{y}.png?key=Z9utiQmGtSf9uinbfDZT', {
	        maxZoom: 18,
          },{
          attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>,'
          }).addTo(map);

          map.on('click', function(e){
                  setPointData(e.latlng);
                  })

          function setPointData(position) {
            document.getElementById('lat').value = position.lat;
            document.getElementById('lng').value = position.lng;
          }

          var marker = L.marker([-24.7859, -65.41166],{
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
