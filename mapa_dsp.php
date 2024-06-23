<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin="" />

    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
      integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
      crossorigin="" /> -->


</head>

<body>

  <div id="myMap" style="height: 600px"></div>

  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
   <!-- <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
     integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
     crossorigin=""></script> -->
  <script>
  let myMap = L.map('myMap').setView([<?php echo $row_sumarios['Coord_X']; ?>, <?php echo $row_sumarios['Coord_Y']; ?>], 13)

L.tileLayer(`https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png`, {
maxZoom: 18,
}).addTo(myMap);

// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//   maxZoom: 18,
//   attribution:
//     '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
// }).addTo(myMap);

let marker = L.marker([<?php echo $row_sumarios['Coord_X']; ?>, <?php echo $row_sumarios['Coord_Y']; ?>]).addTo(myMap)

let iconMarker = L.icon({
  iconUrl: 'marker.png',
  iconSize: [60, 60],
  iconAnchor: [30, 60]
})

// let marker2 = L.marker([51.51, -0.09], { icon: iconMarker }).addTo(myMap)
//
// myMap.doubleClickZoom.disable()
// myMap.on('dblclick', e => {
// let latLng = myMap.mouseEventToLatLng(e.originalEvent);
//
// L.marker([latLng.lat, latLng.lng], { icon: iconMarker }).addTo(myMap)
// })
//
// navigator.geolocation.getCurrentPosition(
// (pos) => {
//   const { coords } = pos
//   const { latitude, longitude } = coords
//   L.marker([latitude, longitude], { icon: iconMarker }).addTo(myMap)
//
//   setTimeout(() => {
//     myMap.panTo(new L.LatLng(latitude, longitude))
//   }, 5000)
// },
// (error) => {
//   console.log(error)
// },
// {
//   enableHighAccuracy: true,
//   timeout: 5000,
//   maximumAge: 0
// })
  </script>
</body>

</html>
