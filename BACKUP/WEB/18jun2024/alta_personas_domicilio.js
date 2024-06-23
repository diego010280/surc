var pagina = self.location.pathname.match( /\/([^/]+)$/ )[1];

if (pagina=='alta_personas_domicilio.php') {

      $(document).ready(function() {

        $("#idpais").change(function(){
            var pais_id=$("#idpais").val();

            $.get('sum_d_gral_barrio.php',{idpais:idpais}, function(data) {
              $("#id_provincia").html(data);
            })

        })

      })
}
