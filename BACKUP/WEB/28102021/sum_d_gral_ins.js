var pagina = self.location.pathname.match( /\/([^/]+)$/ )[1];

if (pagina=='sum_d_ins.php') {


      $(document).ready(function() {

        $("#barrios_id").attr("readonly","readonly");
        $("#id_localidad").change(function(){
            let local_id_desc=$("#id_localidad").val();
            let localidad=local_id_desc.split(' '); //es el explode del php
            var local_id=localidad[0];
            console.log(local_id);
            if (local_id!=0) {
              $("#barrios_id").removeAttr("readonly");
              $.post('sum_d_gral_barrio.php',{local_id:local_id}, function(data) {
                $("#barrios_id").html(data);
              })
            }


        })

      })
}
