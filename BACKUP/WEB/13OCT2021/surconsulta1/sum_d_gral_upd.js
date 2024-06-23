var pagina = self.location.pathname.match( /\/([^/]+)$/ )[1];

if (pagina=='sum_d_upd.php') {

      $(document).ready(function() {

        $("#id_localidad").change(function(){
            let local_id_desc=$("#id_localidad").val();
            let localidad=local_id_desc.split(' '); //es el explode del php
            var local_id=localidad[0];

            
            $.post('sum_d_gral_barrio.php',{local_id:local_id}, function(data) {
              $("#barrios_id").html(data);
            })

        })

      })
}
