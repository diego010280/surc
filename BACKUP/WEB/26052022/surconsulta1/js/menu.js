document.addEventListener("DOMContentLoaded", menu, false);
// document.addEventListener("DOMContentLoaded", tracing, false);
// document.addEventListener("DOMContentLoaded", abrirNav, false);
// document.addEventListener("DOMContentLoaded", cerrarNav, false);

function menu(){
  var i, stop = document.getElementsByClassName("stop");
	var irModulo = document.getElementsByClassName("irModulo");


	for (i = 0; i < stop.length; i++){
		stop[i].onclick = function(e){
			e.preventDefault();
		}
	}

	if (irModulo) {

		console.log("ingreso a ir a modulo");

		for (let i = 0; i < irModulo.length; i++) {
			irModulo[i].onclick = function () {
				this.parentNode.submit();
			}
		}
	}
}

// function tracing(){
// 	document.getElementById("autorizado").onclick = function (){
// 		this.parentNode.submit();
// 	}
// }

function abrirNav(){
	var openNav = document.getElementById("openNav");

	if (openNav) {
		openNav.onclick = function (){
			document.getElementById("mySidenav").style.width = "250px";
		}
	}
}

function cerrarNav(){
	var closeNav = document.getElementById("closeNav");

	if (closeNav) {
		closeNav.onclick = function (){
			document.getElementById("mySidenav").style.width = "0";
		}
	}
}
