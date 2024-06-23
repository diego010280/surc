document.addEventListener("DOMContentLoaded", hora, false);

function hora() {
    var horadelito=document.getElementById("HoraDel"),
        horaimprecisa=document.getElementById("horaimprecisa"),
        tdtitulo=document.getElementById("tit_horaimprecisa"),
        tdvalor=document.getElementById("val_horaimprecisa"),
        selector_hora=document.getElementById("select_horaimprecisa");
      console.log("ingreso a script de hora"); 

        // console.log(tdtitulo);
        // console.log(tdvalor);
        //console.log(selector_hora);
        // console.log(entradahora);
    
    if (horadelito) {

        horadelito.onchange= function () {
            var valhoradelito=horadelito.value;
            console.log("hizo cambio en hora");
            
            if (valhoradelito=='') {
                tdtitulo.classList.remove("hide");
                tdvalor.classList.remove("hide");
                selector_hora.value='';
                horadelito.value='';
                                
            }else{
                tdtitulo.classList.add("hide");
                tdvalor.classList.add("hide");
                selector_hora.value='';
                
            }
        }

    }

    if (selector_hora) {

        selector_hora.onchange= function () {
            var opcion= selector_hora.value;
          
            if (opcion=='') {
                
                horadelito.disabled=false;
            }else{
                horadelito.disabled=true;
            }
            
        }
        
    }


    
        
    
    
}