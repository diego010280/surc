function iniciarMap(){
    var coord = {lat:-24.77503585367712 ,lng:-65.40732497590932};
    var map = new google.maps.Map(document.getElementById('map'),{
      zoom: 10,
      center: coord
    });
    var marker = new google.maps.Marker({
      position: coord,
      map: map
    });
}
