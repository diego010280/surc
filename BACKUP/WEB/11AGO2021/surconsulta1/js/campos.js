$(function(){
	
	$("#buscar").on('click',function(e) {
		
		if (campovacio()) {
			document.getElementById("buscar").click();
			
		} else {
			e.preventDefault();
			alerta();
		}
	})
})

function campovacio() {
	var ok = false, sum = 0;
	
	$(".campos").each(function() {
		if($.trim($(this).val()) != ''){
			++sum;
		}
	})
	console.log(sum);
	if (sum > 1) {
		ok = true;
	}
	return ok;
}

function alerta(){
	alertify.alert('Filtros de Busqueda', 'Sr. Usuario/a deberá completar al menos un campo del filtro para Buscar!'); 
}