"use strict";

document.addEventListener("DOMContentLoaded", cantdigitos, false);
document.addEventListener("DOMContentLoaded", marcar, false);
document.addEventListener("DOMContentLoaded", ocultar_m, false);
document.addEventListener("DOMContentLoaded", seleccionar, false);
document.addEventListener("DOMContentLoaded", selectContenido, false);
document.addEventListener("DOMContentLoaded", cuadrobusqueda, false);

function cantdigitos() {
	var elemento = document.getElementsByClassName("digitos"),
	n = elemento.length - 1;
	
	for (let i = 0; i <= n; i++) {
		elemento[i].oninput = function () {
			if (elemento[i].value.length > elemento[i].maxLength) elemento[i].value = elemento[i].value.slice(0, elemento[i].maxLength);
		}
	}
}

function marcar() {
	var elemento = document.getElementsByClassName("alternar"),
		n = elemento.length - 1;
	
	for (let i = 0; i <= n; i++) {
		elemento[i].onclick = function () {
			elemento[i].style.background = (elemento[i].style.background=='') ? '#C6E2FF' : '';
		}
	}
}

function ocultar_m() {
	var mensaje = document.getElementById('mensaje'),
		msjtxt = document.getElementById('msjtxt');
	
	window.addEventListener("keydown", () => {
		if (mensaje) {
			mensaje.style.display = "none";
		}
		if (msjtxt) {
			$(msjtxt).hide();
		} 
	})
	window.addEventListener("click", () => {
		if (mensaje) {
			$(mensaje).fadeOut(500);
		}
		if (msjtxt) {
			$(msjtxt).hide();
		}
	})
}

function controlFecha(fecha_validar,fcha_max,fcha_min,obligatorio) {
	fcha_max = fcha_max.split("-");
	fcha_min = fcha_min.split("-");
    let partes = fecha_validar.split('-'),
        fechaGenerada = new Date(partes[0], partes[1]-1, partes[2]),
		msg = "",
		salida = new Array();
		salida[0] = false;
    
    if (partes.length == 3) {
		if (fechaGenerada && partes[2] == fechaGenerada.getDate() && (partes[1]-1) == fechaGenerada.getMonth() && partes[0] == fechaGenerada.getFullYear()) {
			let fchamax = new Date(fcha_max[0],fcha_max[1]-1,fcha_max[2]);
			let fchamin = new Date(fcha_min[0],fcha_min[1]-1,fcha_min[2]);
			
			if (fechaGenerada < fchamin) {
				msg = "El valor debe ser igual o posterior a "+fcha_min[2]+"-"+fcha_min[1]+"-"+fcha_min[0]+"\n";
				salida[1] = msg;
				return (salida);
			} else if (fechaGenerada > fchamax) {
				msg = "El valor debe ser igual o anterior a "+fcha_max[2]+"-"+fcha_max[1]+"-"+fcha_max[0]+"\n";
				salida[1] = msg;
				return (salida);
			}
			salida[0] = true;
			return (salida);
		}
		msg = "Fecha inválida\n";
		salida[1] = msg;
		return (salida);
	} else if (obligatorio) {
		//msg = "Completa este campo\n";	
		salida[1] = '';
		return (salida);
	} else {
		salida[0] = true;
		return (salida);
	}	
}

function seleccionar(){
	var guardar = document.getElementById("guardarRecibidos");
	
	$(".cajaselect").on("change",function(){
		
		if ($(this).is(":checked")){
			$(guardar).show();
		} else {
			if (($(".cajaselect:checked").length) == 0){
				$(guardar).hide();
			}
		}
	})
}

function selectContenido() {
	$(".select").click(function(){
		this.select();
	})
}

function cuadrobusqueda() {
	var selects = document.getElementsByClassName('select'),
		valordatos = document.getElementsByClassName('datos'),
		i, cantSelects = selects.length, identif = new Array();
	
	$(selects).each(function(){identif.push(this.id);})
	
	for (i = 0; i < cantSelects; i++) {
		autocomplete(selects[i],valordatos[i], identif);
	}
}

function autocomplete(inp,datos,identificador) {
	var currentFocus;

	if (datos) {
	
		var arr = datos.textContent.split("#");
		arr.pop();
		var cant_datos = arr.length;
		
		inp.addEventListener("input", function(e) {
			var a, b, i, j, k, l, val = this.value, contador = 0, noencontrados = 0;
			
			closeAllLists();
				  
			if (!val) {return false;}
			currentFocus = -1;
				  
			a = document.createElement("DIV");
			a.setAttribute("id", this.id + "autocomplete-list");
			a.setAttribute("class", "autocomplete-items");
			this.parentNode.appendChild(a);
			
			for (i = 0; i < cant_datos; i++) {
				var texto = val.toUpperCase().split("%"),
					indice = texto.length - 1;
				
				do {
					if (texto[indice] == ''){
						texto.splice(indice,1);
					}
					--indice;
				} while (indice > 0);
				
				var cantElement = texto.length,
					condicion = texto[0];
				
				for (j = 1; j < cantElement; j++){
					condicion += '\\D{0,}\\d{0,3}\\D{0,}\\d{0,3}\\D{0,}?' + texto[j];
				}
				var patron = new RegExp(condicion);
				
				if (patron.test(arr[i].toUpperCase())) {
					var ini = 0,
						pos = [arr[i].toUpperCase().indexOf(texto[0])];
					
					for (k = 1; k < cantElement; k++) {
						pos.push(arr[i].toUpperCase().indexOf(texto[k],pos[k-1] + texto[k-1].length));
					}
					
					b = document.createElement("DIV");
					
					for (l = 0; l < cantElement; l++){
						b.innerHTML += arr[i].substr(ini, pos[l] - ini) + '<span class="azul">' + arr[i].substr(pos[l], texto[l].length) + "</span>";
						ini = pos[l] + texto[l].length;
					}
					b.innerHTML += arr[i].substr(pos[l-1] + texto[l-1].length);
					b.innerHTML += "<input type='hidden' value='" + arr[i] + "' id='" + contador +"ag'>";
					
					b.addEventListener("click", function(e) {
						inp.value = this.getElementsByTagName("input")[0].value;
						closeAllLists();
						inp.focus();
					});
					a.appendChild(b);
					contador += 1;
					
				} else {
					++noencontrados;
				}
			}
			
			var node = document.getElementById(this.id + "autocomplete-list");
			if (noencontrados == cant_datos){
				node.parentNode.removeChild(node);
			
			} else {
				node = node.getElementsByTagName("div");
				var cantnodos = node.length;
				
				for (i = 0; i < cantnodos; i++) {
					node[i].addEventListener('mouseover', function() {
						currentFocus = parseInt(this.querySelector('input').id);
						addActive(node);
					})
				}
			}
		});
		inp.addEventListener("keydown", function(e) {
			//var val = this.value;
			var tecla = (e)? e.keyCode : e.which,
				x = document.getElementById(this.id + "autocomplete-list"),
				caja = x;
			
			if (tecla == 13 && !x) {
				if (this.required == false) {
					this.setCustomValidity('');
				}
			} else {
				
				if (x) x = x.getElementsByTagName("div");

				if ((tecla == 40 || tecla == 38)) {
					e.preventDefault();
					if (tecla == 40) currentFocus++; else currentFocus--;
					var next, sel = caja.querySelector('.autocomplete-active');
					if (!sel) {
						next = (tecla == 40) ? caja.querySelector('.autocomplete-items div') : caja.childNodes[caja.childNodes.length - 1];
					} else {
						next = (tecla == 40) ? sel.nextSibling : sel.previousSibling;
						if (!next) {
							next = 0;
						}
					}
					addActive(x);
					
				} else if (tecla == 13) {
					e.preventDefault();
					if (currentFocus > -1) {
					  if (x) x[currentFocus].click();
					}
				} else if (tecla == 9 && x){
					if (currentFocus > -1) {
					  if (x) x[currentFocus].click();
					}
				} else if (tecla == 27) {
					var node = document.getElementById(this.id + "autocomplete-list");
					node.parentNode.removeChild(node);
				} else {
					this.setCustomValidity('');
				}
				
				if (caja) {
					if (!caja.maxHeight) { caja.maxHeight = parseInt((getComputedStyle(caja, null)).maxHeight); }
					if (!suggestionHeight) var suggestionHeight = caja.querySelector('.autocomplete-items div').offsetHeight;
					if (suggestionHeight)
						if (next) {
							var scrTop = caja.scrollTop, selTop = next.getBoundingClientRect().top - caja.getBoundingClientRect().top;
							if (selTop + suggestionHeight > caja.maxHeight)
								caja.scrollTop = selTop + suggestionHeight + scrTop - caja.maxHeight;
							else if (selTop < 0)
								caja.scrollTop = selTop + scrTop;
						}
				}
			}	
		});
		
		inp.addEventListener("click", function(e) {
			var a, b, i, val = this.value;
				
			if (val) {return false;}
			closeAllLists();
			currentFocus = -1;
			
			a = document.createElement("DIV");
			a.setAttribute("id", this.id + "autocomplete-list");
			a.setAttribute("class", "autocomplete-items");
			this.parentNode.appendChild(a);
			
			var x = document.getElementById(this.id + "autocomplete-list");
			x = x.getElementsByTagName("div");
			
			for (i = 0; i < cant_datos; i++) {
				b = document.createElement("DIV");
				b.innerHTML += arr[i];
				b.innerHTML += "<input type='hidden' value='" + arr[i] + "' id='" + i +"ag'>";
				b.addEventListener("click", function(e) {
					inp.value = this.getElementsByTagName("input")[0].value;
					closeAllLists();
					inp.focus();
				});
				a.appendChild(b);
				
				b.addEventListener('mouseover', function() {
					currentFocus = parseInt(this.querySelector('input').id);
					addActive(x);
				})
			}
		});
		function addActive(x) {
			if (!x) return false;
			removeActive(x);
			if (currentFocus >= x.length) currentFocus = (x.length - 1);
			if (currentFocus < 0) currentFocus = 0;
			x[currentFocus].classList.add("autocomplete-active");
		}
		function removeActive(x) {
			var i;
			for (i = 0; i < x.length; i++) {
			  x[i].classList.remove("autocomplete-active");
			}
		}
		function closeAllLists(elmnt) {
			var x = document.getElementsByClassName("autocomplete-items"), i;
			for (i = 0; i < x.length; i++) {
			  if (elmnt != x[i] && elmnt != inp) {
				x[i].parentNode.removeChild(x[i]);
			  }
			}
		}
		document.addEventListener("click", function (e) {
			if (!identificador.includes(e.target.id)){
				closeAllLists(e.target);
			}
		});
	}
}