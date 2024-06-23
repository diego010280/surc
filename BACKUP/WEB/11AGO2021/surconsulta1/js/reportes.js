$(document).ready(function(){
    let ano; 
    let ur;
   
    var now = new Date();
    var dia = ("0" + now.getDate()).slice(-2);
    var mes = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(mes)+"-"+(dia);
    $("#fechaconsulta").val(today);
    cargartablacomando();
    cargarArea();
    consultarelevante();
    

   
//////////////MANEJADORES DE BUSQUEDAS PARA MUESTRAS GRAFICAS

   $(document).on('click', '#boton2', function(){ 
    busq = $("#del2").val();
    
    if(busq==="0"){
        $("#topdiezdelitos").empty();
    ano = $("#selectorano2").val();
    ur = $("#selectoruurr2").val();
        $("#tablagraficos2").hide();  
        reportedelito4(ano, ur);

    }else{
        $("#topdiezdelitos").empty();
        ano = $("#selectorano2").val();
        ur = $("#selectoruurr2").val();
        $("#tablagraficos2").hide();  
        reportedelito5(ano, ur);
    }
   });

   $(document).on('click', '#agconsul', function(){ 
    $("#seccionabm").show();
    $("#secciontablero").hide();
    cargarHechoDelict();
    cargarModalidad();
    
    
    });
   

    $(document).on('click', '#boton', function(){ 
        busq = $("#del").val();
        if(busq==="0"){
        $("#reportesdelitos").empty();
        $("#reportesdelitos2").empty();
        $("#reportesdelitos3").empty();
        $("#reportesdelitos4").empty();
        $("#reportesdelitos5").empty();
        $("#reportesdelitos6").empty();
        $("#reportesdelitos7").empty();
        $("#reportesdelitos8").empty();
        $("#reportesdelitos9").empty();
        $("#reportesdelitos10").empty();
        $("#reportesdelitos11").empty();
        $("#reportesdelitos12").empty();
        $("#reportesdelitos13").empty();
        $("#reportesdelitos14").empty();
        $("#reportesdelitos15").empty();
        ano = $("#selectorano").val();
        ur = $("#selectoruurr").val();
       
        $("#tablagraficos").hide();  
        reportedelito2(ano, ur);
        
        }else{
             
        $("#reportesdelitos").empty();
        $("#reportesdelitos2").empty();
        $("#reportesdelitos3").empty();
        $("#reportesdelitos4").empty();
        $("#reportesdelitos5").empty();
        $("#reportesdelitos6").empty();
        $("#reportesdelitos7").empty();
        $("#reportesdelitos8").empty();
        $("#reportesdelitos9").empty();
        $("#reportesdelitos10").empty();
        $("#reportesdelitos11").empty();
        $("#reportesdelitos12").empty();
        $("#reportesdelitos13").empty();
        $("#reportesdelitos14").empty();
        $("#reportesdelitos15").empty();
        ano = $("#selectorano").val();
        ur = $("#selectoruurr").val();
      
        $("#tablagraficos").hide();         
        reportedelito3(ano, ur);
        }
    });



////////////GRAFICAS/////////////////////

function grafica2(matriz){
    $("#tablagraficos2").show();
    var trace1 = {
        type: 'bar',
        x: [matriz[0][0], matriz[1][0], matriz[2][0],matriz[3][0], matriz[4][0], matriz[5][0], matriz[6][0],matriz[7][0], matriz[8][0], matriz[9][0]],
        y: [matriz[0][1], matriz[1][1], matriz[2][1],matriz[3][1], matriz[4][1], matriz[5][1], matriz[6][1],matriz[7][1], matriz[8][1], matriz[9][1]],
        marker: {
            color: '#2E4053 ',
            line: {
                width: 2.5,
                color: ' #7F8C8D'
            }
        }
      };
       
      var data = [ trace1 ];
      
      var layout = { 
        font: {size: 10, color:'#6C3483',
                family: 'Raleway, sans-serif'
    },
    showlegend: false,
  xaxis: {
    tickangle: -10
  },
 };
      
      var config = {responsive: true}
      
      Plotly.newPlot('graficoreportebarra', data, layout, config );
}


function grafica1(matriz){
    $("#tablagraficos").show();  
    
   if(matriz[0][0]==0){
       matriz[0][0]="Sin valor estadist."
   }       
   if(matriz[1][0]==0){
       matriz[1][0]="Sin valor estadist."
   }  
   if(matriz[2][0]==0){
       matriz[2][0]="Sin valor estadist."
   }  
   if(matriz[3][0]==0){
       matriz[3][0]="Sin valor estadist."
   }  
   if(matriz[4][0]==0){
       matriz[4][0]="Sin valor estadist."
   }  
   if(matriz[5][0]==0){
       matriz[5][0]="Sin valor estadist."
   }  
   if(matriz[6][0]==0){
       matriz[6][0]="Sin valor estadist."
   }  
   if(matriz[7][0]==0){
       matriz[7][0]="Sin valor estadist."
   }  
   if(matriz[8][0]==0){
       matriz[8][0]="Sin valor estadist."
   }  

   if(matriz[9][0]==0){
       matriz[9][0]="Sin valor estadist."
   }  
   if(matriz[10][0]==0){
       matriz[10][0]="Sin valor estadist."
   }  
   if(matriz[11][0]==0){
       matriz[11][0]="Sin valor estadist."
   }  
   if(matriz[12][0]==0){
       matriz[12][0]="Sin valor estadist."
   }  
   if(matriz[13][0]==0){
       matriz[13][0]="Sin valor estadist."
   }  
   if(matriz[14][0]==0){
       matriz[14][0]="Sin valor estadist."
   }  



    var trace1 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[0][1],matriz[0][2], matriz[0][3], matriz[0][4],matriz[0][5], matriz[0][6], matriz[0][7], matriz[0][8], matriz[0][9], matriz[0][10], matriz[0][11], matriz[0][12] ],
       name: matriz[0][0],
       type: 'scatter'
     };
     
     var trace2 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[1][1],matriz[1][2], matriz[1][3], matriz[1][4],matriz[1][5], matriz[1][6], matriz[1][7], matriz[1][8], matriz[1][9], matriz[1][10], matriz[1][11], matriz[1][12] ],
       name: matriz[1][0],
       type: 'scatter'
     };
     var trace3 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[2][1],matriz[2][2], matriz[2][3], matriz[2][4],matriz[2][5], matriz[2][6],matriz[2][7], matriz[2][8], matriz[2][9], matriz[2][10], matriz[2][11], matriz[2][12] ],
       name: matriz[2][0],
       type: 'scatter'
     };
     
     var trace4 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[3][1],matriz[3][2], matriz[3][3], matriz[3][4],matriz[3][5], matriz[3][6], matriz[3][7], matriz[3][8], matriz[3][9], matriz[3][10], matriz[3][11], matriz[3][12] ],
       name: matriz[3][0],
       type: 'scatter'
     };

     var trace5 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[4][1],matriz[4][2], matriz[4][3], matriz[4][4],matriz[4][5], matriz[4][6], matriz[4][7], matriz[4][8], matriz[4][9], matriz[4][10], matriz[4][11], matriz[4][12] ],
       name: matriz[4][0],
       type: 'scatter'
     };
     
     var trace6 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[5][1],matriz[5][2], matriz[5][3], matriz[5][4],matriz[5][5], matriz[5][6], matriz[5][7], matriz[5][8], matriz[5][9], matriz[5][10], matriz[5][11], matriz[5][12] ],
       name: matriz[5][0],
       type: 'scatter'
     };
     var trace7 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[6][1],matriz[6][2], matriz[6][3], matriz[6][4],matriz[6][5], matriz[6][6], matriz[6][7], matriz[6][8], matriz[6][9], matriz[6][10], matriz[6][11], matriz[6][12] ],
       name: matriz[6][0],
       type: 'scatter'
     };
     
     var trace8 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[7][1],matriz[7][2], matriz[7][3], matriz[7][4],matriz[7][5], matriz[7][6], matriz[7][7], matriz[7][8], matriz[7][9], matriz[7][10], matriz[7][11], matriz[7][12] ],
       name: matriz[7][0],
       type: 'scatter'
     };

     var trace9 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[8][1],matriz[8][2], matriz[8][3], matriz[8][4],matriz[8][5], matriz[8][6], matriz[8][7], matriz[8][8], matriz[8][9], matriz[8][10], matriz[8][11], matriz[8][12] ],
       name: matriz[8][0],
       type: 'scatter'
     };
     
     var trace10 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[9][1],matriz[9][2], matriz[9][3], matriz[9][4],matriz[9][5], matriz[9][6], matriz[9][7], matriz[9][8], matriz[9][9], matriz[9][10], matriz[9][11], matriz[9][12] ],
       name: matriz[9][0],
       type: 'scatter'
     };
     var trace11 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[10][1],matriz[10][2], matriz[10][3], matriz[10][4],matriz[10][5], matriz[10][6], matriz[10][7], matriz[10][8], matriz[10][9], matriz[10][10], matriz[10][11], matriz[10][12] ],
       name: matriz[10][0],
       type: 'scatter'
     };
     
     var trace12 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[11][1],matriz[11][2], matriz[11][3], matriz[11][4],matriz[11][5], matriz[11][6], matriz[11][7], matriz[11][8], matriz[11][9], matriz[11][10], matriz[11][11], matriz[11][12] ],
       name: matriz[11][0],
       type: 'scatter'
     };

     var trace13 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[12][1],matriz[12][2], matriz[12][3], matriz[12][4],matriz[12][5], matriz[12][6], matriz[12][7], matriz[12][8], matriz[12][9], matriz[12][10], matriz[12][11], matriz[12][12] ],
       name: matriz[12][0],
       type: 'scatter'
     };
     var trace14 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[13][1],matriz[13][2], matriz[13][3], matriz[13][4],matriz[13][5], matriz[13][6], matriz[13][7], matriz[13][8], matriz[13][9], matriz[13][10], matriz[13][11], matriz[13][12] ],
       name: matriz[13][0],
       type: 'scatter'
     };
     
     var trace15 = {
       x: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       y: [matriz[14][1],matriz[14][2], matriz[14][3], matriz[14][4],matriz[14][5], matriz[14][6], matriz[14][7], matriz[14][8], matriz[14][9], matriz[14][10], matriz[14][11], matriz[14][12]],
       name: matriz[14][0],
       type: 'scatter'
     };

     var layout = {
       title: 'Datos estadisticos criminales mas relevantes'
     };
     var data = [trace1, trace2, trace3, trace4, trace5, trace6, trace7, trace8, trace9, trace10, trace11, trace12, trace13, trace14, trace15];
     
     Plotly.newPlot('graficoreportelineal', data, layout);
}


//////////////////TABLAS///////////////////
////FUNCION REPORTE   
function reportedelito2(ano, ur){
    $("#carg").show();
    $("#sinreg").hide();
    var matriz = new Array(14);
    for (var i=0;i<=14;i++) {
       matriz[i] = new Array(13);
    }
    for (var i=0;i<=14;i++) {
        for (var j=0;j<=12;j++) {
            matriz[i][j] = 0;
         }
     }
          $.ajax({
            url: 'reportedelito2.php',
            type: 'POST',
            data:{ano, ur},
            success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                del="";
                del2="";
                contador=-1;
               if(respuesta.length>2){
                datos.forEach(dato => {
                    cant=dato.cant;
                    mes = dato.mes;
                    del=dato.delito;
                    
                    if(del != del2){
                        contador++;
                        del2=del;
                        matriz[contador][0] = del2;
                    }
                    matriz[contador][mes]=cant;
                });
                $("#carg").hide();
                for (var i=0;i<=14;i++) {
                    let suma=0;
                    if(matriz[i][0] != 0){
                    for (var j=1;j<=12;j++){
                        suma=suma + parseInt(matriz[i][j]);   
                    }                     

                      valor = `<tr> 
                      <td>${matriz[i][0]}</td>
                      <td>${matriz[i][1]}</td>
                      <td>${matriz[i][2]}</td>
                      <td>${matriz[i][3]}</td>
                      <td>${matriz[i][4]}</td>
                      <td>${matriz[i][5]}</td>
                      <td>${matriz[i][6]}</td>
                      <td>${matriz[i][7]}</td>
                      <td>${matriz[i][8]}</td>
                      <td>${matriz[i][9]}</td>
                      <td>${matriz[i][10]}</td> 
                      <td>${matriz[i][11]}</td> 
                      <td>${matriz[i][12]}</td>
                      <td>${suma}</td>
                      </tr>`
                      
                      switch(i){
                          case 0:
                           $("#reportesdelitos").html(valor);
                           break;
                           case 1:
                               $("#reportesdelitos2").html(valor);
                               break;
                           case 2:
                               $("#reportesdelitos3").html(valor);
                               break;
                           case 3:
                           $("#reportesdelitos4").html(valor);
                           break;
                           case 4:
                               $("#reportesdelitos5").html(valor);
                               break;
                           case 5:
                               $("#reportesdelitos6").html(valor);
                               break;
                           case 6:
                               $("#reportesdelitos7").html(valor);
                               break;
                           case 7:
                                $("#reportesdelitos8").html(valor);
                                break;
                           case 8:
                               $("#reportesdelitos9").html(valor);
                               break;
                           case 9:
                               $("#reportesdelitos10").html(valor);
                               break;
                           case 10:
                               $("#reportesdelitos11").html(valor);
                               break;
                           case 11:
                               $("#reportesdelitos12").html(valor);
                               break;
                           case 12:
                               $("#reportesdelitos13").html(valor);
                               break;
                           case 13:
                               $("#reportesdelitos14").html(valor);
                               break;
                           case 14:
                               $("#reportesdelitos15").html(valor);
                               break;       
                        }
                    }                   
               }
               grafica1(matriz);
              }else{
                $("#carg").hide();
                $("#sinreg").show();
              }
            }
        });
  }  
 


  function reportedelito3(ano, ur){
    $("#carg").show();
    $("#sinreg").hide();  
    var matriz = new Array(14);
    for (var i=0;i<=14;i++) {
       matriz[i] = new Array(13);
    }
    for (var i=0;i<=14;i++) {
        for (var j=0;j<=12;j++) {
            matriz[i][j] = 0;
         }
     }
          $.ajax({
            url: 'reportedelito3.php',
            type: 'POST',
            data:{ano, ur},
            success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                mod="";
                mod2="";
                contador=-1;
               if(respuesta.length>2){
                datos.forEach(dato => {
                    cant=dato.cant;
                    mes = dato.mes;
                    mod=dato.modalidad;
                    if(mod != mod2){
                        contador++;
                        mod2=mod;
                        matriz[contador][0] = mod2;
                    }
                    matriz[contador][mes]=cant;
                });
                $("#carg").hide();
                for (var i=0;i<=14;i++) {
                    if(matriz[i][0] != 0){ 
                      valor = `<tr> 
                      <td>${matriz[i][0]}</td>
                      <td>${matriz[i][1]}</td>
                      <td>${matriz[i][2]}</td>
                      <td>${matriz[i][3]}</td>
                      <td>${matriz[i][4]}</td>
                      <td>${matriz[i][5]}</td>
                      <td>${matriz[i][6]}</td>
                      <td>${matriz[i][7]}</td>
                      <td>${matriz[i][8]}</td>
                      <td>${matriz[i][9]}</td>
                      <td>${matriz[i][10]}</td> 
                      <td>${matriz[i][11]}</td> 
                      <td>${matriz[i][12]}</td>
                      </tr>`
  
                      switch(i){
                          case 0:
                           $("#reportesdelitos").html(valor);
                           break;
                           case 1:
                               $("#reportesdelitos2").html(valor);
                               break;
                           case 2:
                               $("#reportesdelitos3").html(valor);
                               break;
                           case 3:
                           $("#reportesdelitos4").html(valor);
                           break;
                           case 4:
                               $("#reportesdelitos5").html(valor);
                               break;
                           case 5:
                               $("#reportesdelitos6").html(valor);
                               break;
                           case 6:
                               $("#reportesdelitos7").html(valor);
                               break;
                           case 7:
                                $("#reportesdelitos8").html(valor);
                                break;
                           case 8:
                               $("#reportesdelitos9").html(valor);
                               break;
                           case 9:
                               $("#reportesdelitos10").html(valor);
                               break;
                           case 10:
                               $("#reportesdelitos11").html(valor);
                               break;
                           case 11:
                               $("#reportesdelitos12").html(valor);
                               break;
                           case 12:
                               $("#reportesdelitos13").html(valor);
                               break;
                           case 13:
                               $("#reportesdelitos14").html(valor);
                               break;
                           case 14:
                               $("#reportesdelitos15").html(valor);
                               break;        
                              
                      }
  
  
  
                    }                   
               }
               grafica1(matriz);
              }else{
                $("#carg").hide();
                $("#sinreg").show();
              }
              
             }
        });
  }  

  function reportedelito4(ano, ur){
    
    var matriz = new Array(10);
    for (var i=0;i<=9;i++) {
       matriz[i] = new Array(2);
    }
    for (var i=0;i<=9;i++) {
        for (var j=0;j<=1;j++) {
            matriz[i][j] = 0;
         }
     }
    $("#carg2").show();
    $("#sinreg2").hide();
    let valor='';
    i=1;  
          $.ajax({
            url: 'reportedelito4.php',
            type: 'POST',
            data:{ano, ur},
            success: function (respuesta) {
             let datos = JSON.parse(respuesta);
            
             if(respuesta.length > 2){
                datos.forEach(dato => {
                    matriz[i-1][0]= dato.delito;
                    matriz[i-1][1]= dato.cant;
                  valor += `<tr>
                  <td class="td0">${i}</td> 
                  <td class="td1">${dato.delito}</td>
                  <td class="td2">${dato.cant}</td>
                  </tr>`;
                  i++;
                   });
                  
              $("#carg2").hide();
              $('#topdiezdelitos').html(valor);
                   
              grafica2(matriz);
             }else{
                $("#carg2").hide();
                $("#sinreg2").show();
             }
            
       }
    });
  }  
 




  function reportedelito5(ano, ur){
    var matriz = new Array(10);
    for (var i=0;i<=9;i++) {
       matriz[i] = new Array(2);
    }
    for (var i=0;i<=9;i++) {
        for (var j=0;j<=1;j++) {
            matriz[i][j] = 0;
         }
     }
    $("#carg2").show();
    $("#sinreg2").hide();
    let valor='';
    i=1;  
          $.ajax({
            url: 'reportedelito5.php',
            type: 'POST',
            data:{ano, ur},
            success: function (respuesta) {
             let datos = JSON.parse(respuesta);
            
             if(respuesta.length > 2){
                datos.forEach(dato => {
                    matriz[i-1][0]= dato.delito;
                    matriz[i-1][1]= dato.cant;
                  valor += `<tr>
                  <td class="td0">${i}</td> 
                  <td class="td1">${dato.delito}</td>
                  <td class="td2">${dato.cant}</td>
                  </tr>`;
                  i++;
                   });
                  
              $("#carg2").hide();
              
              $('#topdiezdelitos').html(valor);
                   
              grafica2(matriz);
             }else{
                $("#carg2").hide();
                $("#sinreg2").show();
             }
        }
    });
  }


function consultarelevante(){
    let valor=``;
    $("#noregcarg").show();
    $("#noreg").hide();
          $.ajax({
            url: 'consulta_alerta.php',
            type: 'POST',
            success: function (respuesta) {
             let datos = JSON.parse(respuesta);
             let i=1;
             if(respuesta.length > 2){

                datos.forEach(dato => {
                    if(i==1){
                        if(dato.modalidad == 0){
                            valor +=`(SURC_Sumario_IdHechoDel = ${dato.delictivo}`;
                        }else{
                            valor +=`((SURC_Sumario_IdHechoDel = ${dato.delictivo} AND SURC_Sumario_IdModalidad = ${dato.modalidad})`;     
                        }
                        
                    }else{

                        if(dato.modalidad == 0){
                            valor +=` OR SURC_Sumario_IdHechoDel = ${dato.delictivo}`;
                        }else{
                            valor +=` OR (SURC_Sumario_IdHechoDel = ${dato.delictivo} AND SURC_Sumario_IdModalidad = ${dato.modalidad})`;     
                        }
                    }
                  i++;
                   });

             }else{
                valor=`(1`;
             }
                let uurr="";            
                let sector=$("#selectorsec").val();
                let zona=$("#selectorzon").val();
                let fecha=$("#fechaconsulta").val();
               
                if(sector=='0' || sector==null){
                    sector="";
                }    

                if(zona=='0' || zona==null){
                    zona="";
                    uurr="1";
                }    
                valor+=`) AND SURC_Sumario_FechaSum = '${fecha}' AND (ref_dependencias.SURC_Sectores_IdCCO = '${zona}' OR '${zona}'='') AND (ref_dependencias.SURC_Sectores_Id='${sector}' OR '${sector}'='') AND(dbseg.ref_dependencias.UnidadReg_Codigo='${uurr}' OR '${uurr}'='')`;
                

             $.ajax({ 
                url: 'consultasrelevantes.php',
                type: 'POST',
                data: {valor},
                success: function (respuesta) {                
                    let datos = JSON.parse(respuesta);
                    if(respuesta.length > 2){
                        
                    j=1;    
                    datos.forEach(dato => {
                       


                      a=new Date(dato.horasum);
                      valor += `<tr>
                      <td >${j}</td> 
                      <td >${dato.numero}</td>
                      <td >${dato.dependencia}</td>
                      <td >${dato.delictivo}</td>
                      <td >${dato.modalidad}</td>
                      <td ><b> ${dato.fechasum}</b> ${a.getHours()-3}:${a.getMinutes()}:${a.getSeconds()}</td>
                      <td ><b>${dato.fechadel}</b></td>
                      </tr>`;
                      j++;
                    });
                    $("#noregcarg").hide();
                    $('#reportesalertas').html(valor);

                    }else{
                        $("#noregcarg").hide();
                        $("#noreg").show();
                    }                    
                }
            }); 
      }        
  });  
}

  function cargartablacomando(){
    $("#sinreg3").hide();
    let valor='';
    
          $.ajax({
            url: 'consultacomando.php',
            type: 'POST',
            success: function (respuesta) {
             let datos = JSON.parse(respuesta);
             let i=1;
             
             if(respuesta.length > 2){
                datos.forEach(dato => {
                  valor += `<tr id="${dato.id}">
                  <td class="td0">${i}</td> 
                  <td >${dato.delictivo}</td>
                  <td >${dato.modalidad}</td>
                  <td><input type="image" src="imagenes/iconos/basura.png" width="17" class="borrarconsulta"></td>
                  </tr>`;
                  i++;
                   });
                   $('#alert_reportes').empty();
                $('#alert_reportes').html(valor);
                
             }else{
                $('#alert_reportes').empty();
                $("#sinreg3").show();
                
             }
        }
    });
  }


  ///////////////NAVEGADOR////////////////

  $(document).on('click', '#reprel', function(){
      $("#reprelev").show();
      $("#topten").hide();
      $( "#topdiez" ).removeClass( "enla active" ).addClass( "enla" );
      $( "#reprel" ).removeClass( "enla" ).addClass( "enla active" );

  });

  $(document).on('click', '#topdiez', function(){
    $("#reprelev").hide();
    $("#topten").show();
    $( "#reprel" ).removeClass( "enla active" ).addClass( "enla" );
    $( "#topdiez" ).removeClass( "enla" ).addClass( "enla active" );

});



$(document).on('click', '#regresar', function(){
    $("#seccionabm").hide();
    $("#secciontablero").show();

});






//////////////FORMULARIO CARGA CONSULTAS

$('#enviar').submit(function(e){
e.preventDefault();
if (confirm("Confirmar")){

const recibidos = {
    delito : $("#hechodelict").val(),
    modalidad : $("#modal").val(),
    comprobar:$("#comprobar").val()
    }; 

  
    $.post('cargavalores.php', recibidos, function(respuesta){
      
        $('#alerta').fadeTo(2000,500).slideUp(500,function(){
            $('#alerta').slideUp(500);
        });
     });
     $("#hechodelict").val(0);
      $("#modal").val(0);
     $("#seccionabm").hide();
    $("#secciontablero").show();
    cargartablacomando();
    }
});


$(document).on('click', '#consulta', function(){ 
    $("#reportesalertas").empty()
consultarelevante();
});

///////////////CARGA SELECTORES

function cargarHechoDelict(){
    $.ajax({
        url: 'cargahechodelict.php',
        type: 'POST',
        success: function (respuesta) {
                let datos = JSON.parse(respuesta);  
                              
                let valor = "";
                datos.forEach(dato => { 
                    valor += `
                <option value="${dato.valor}">${dato.nombre}</option>                 
                `});            
                 $('#hechodelict').html("<option value=''>Seleccionar Hecho delictivo</option>"+ valor);
                                    
        }
    });

}


function cargarModalidad(){
    $.ajax({
        url: 'cargamodalidad.php',
        type: 'POST',
        success: function (respuesta) {
                let datos = JSON.parse(respuesta);  
                             
                let valor = "";
                datos.forEach(dato => { 
                    valor += `
                <option value="${dato.valor}">${dato.nombre}</option>                 
                `});            
                 $('#modal').html("<option value='0'>Seleccionar Modalidad</option>"+ valor);
                                    
        }
    });

}



function cargarSector(valor){
    $.ajax({
        url: 'consultasectores.php',
        type: 'POST',
        data:{valor},
        success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                let valor = "";
                datos.forEach(dato => {
                    
                        valor +=`<option value="${dato.valor}">${dato.nombre}</option>`;
                    
                });            
                 $('#selectorsec').html("<option value='0'>Seleccionar Sector</option>"+ valor); 
        }
    });

}


function cargarArea(){
    $.ajax({
        url: 'consultasectores.php',
        type: 'POST',
        success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                let valor = "";
                datos.forEach(dato => {
                  
                    valor += `<option value="${dato.valor}">${dato.nombre}</option>`;
                   
            });            
                 $('#selectorzon').html("<option value='0'>Seleccionar Zona</option>"+ valor); 
                 }
    });

}



//////////FUNCIONALIDAD BORRADO

$(document).on('click', '.borrarconsulta', function(){

    if (confirm("Confirmar borrado")){
       
        let elemento = $(this)[0].parentElement.parentElement;
        id=$(elemento).attr('id');
            
       $.post('eliminarconsulta.php',{id},function(respuesta){
            cargartablacomando();
            $('#alerta2').fadeTo(2000,500).slideUp(500,function(){
                $('#alerta2').slideUp(500);
            });
        });
    }
});

$(document).on('change', '#selectorzon', function(){
valor=$("#selectorzon").val();    
cargarSector(valor);

});



//////////////////////////////////////////////////////////////////////////////////////////


  

 ////FUNCION REPORTE   
 function reportedelito(ano, ur){
        
    let delitos = ["1", "2", "3", "6", "7","23", "24", "34", "35", "36", "37", "43", "44", "94", "100"];
        let delito;
        j=0;
        for(let i=0; i<=14; i++){
         delito=delitos[i];
          $.ajax({
            url: 'estadisticareporte.php',
            type: 'POST',
            data:{delito, ano, ur},
            success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                enero =0; febrero=0; marzo=0; abril=0; mayo=0; junio=0; julio=0; agosto=0; septiembre=0; octubre=0; noviembre=0; diciembre=0;
                del="";
                j++;
                if(respuesta.length>2){
                datos.forEach(dato => {
                    del=dato.delito;
                    switch (parseInt(dato.mes)) {
                        case 1:
                          enero=dato.cant;
                         break;
                          
                        case 2:
                        febrero=dato.cant;
                        break;
                       
                        case 3:
                        marzo=dato.cant;
                        break;
                        
                        case 4:
                        abril=dato.cant;
                        break;
                        
                        case 5:
                        mayo=dato.cant;
                        break;
                       
                        case 6:
                        junio=dato.cant;
                        break;
                        
                        case 7:
                        julio=dato.cant;
                        break;
                        
                        case 8:
                        agosto=dato.cant;
                        break;
                        
                        case 9:
                        septiembre=dato.cant;
                        
                        break;
                        case 10:
                        octubre=dato.cant;
                        break;
                        
                        case 11:
                        noviembre=dato.cant;
                        break;
                        
                        case 12:
                        diciembre=dato.cant;
                        break;
                      }
                });
                valor = `<tr> 
                    <td>${del}</td>
                    <td>${enero}</td>
                    <td>${febrero}</td>
                    <td>${marzo}</td>
                    <td>${abril}</td>
                    <td>${mayo}</td>
                    <td>${junio}</td>
                    <td>${julio}</td>
                    <td>${agosto}</td>
                    <td>${septiembre}</td>
                    <td>${octubre}</td> 
                    <td>${noviembre}</td> 
                    <td>${diciembre}</td>
                    </tr>`
                    
                   switch(j){
                       case 1:
                        $("#reportesdelitos").html(valor);
                        break;
                        case 2:
                            $("#reportesdelitos2").html(valor);
                            break;
                        case 3:
                            $("#reportesdelitos3").html(valor);
                            break;
                        case 4:
                        $("#reportesdelitos4").html(valor);
                        break;
                        case 5:
                            $("#reportesdelitos5").html(valor);
                            break;
                        case 6:
                            $("#reportesdelitos6").html(valor);
                            break;
                        case 7:
                            $("#reportesdelitos7").html(valor);
                            break;
                        case 8:
                             $("#reportesdelitos8").html(valor);
                             break;
                        case 9:
                            $("#reportesdelitos9").html(valor);
                            break;
                        case 10:
                            $("#reportesdelitos10").html(valor);
                            break;
                        case 11:
                            $("#reportesdelitos11").html(valor);
                            break;
                        case 12:
                            $("#reportesdelitos12").html(valor);
                            break;
                        case 13:
                            $("#reportesdelitos13").html(valor);
                            break;
                        case 14:
                            $("#reportesdelitos14").html(valor);
                            break;
                        case 15:
                            $("#reportesdelitos15").html(valor);
                            break;        
                           
                   }
                }                          
            }
        });
  }  
   
    
}


function reportemodalidad(ano, ur){
    let modalidades = ["1", "17", "35", "49", "50","58", "68", "71", "79", "96", "100", "101", "107", "121", "122"];
        let modalidad;
        j=0;
        for(let i=0; i<=14; i++){
         modalidad=modalidades[i];
          $.ajax({
            url: 'estadisticareportemod.php',
            type: 'POST',
            data:{modalidad, ano, ur},
            success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                
                enero =0; febrero=0; marzo=0; abril=0; mayo=0; junio=0; julio=0; agosto=0; septiembre=0; octubre=0; noviembre=0; diciembre=0;
                mod="";
                j++;
                if(respuesta.length>2){
                datos.forEach(dato => {
                    
                    mod=dato.modalidad;
                    switch (parseInt(dato.mes)) {
                        case 1:
                          enero=dato.cant;
                         break;
                          
                        case 2:
                        febrero=dato.cant;
                        break;
                       
                        case 3:
                        marzo=dato.cant;
                        break;
                        
                        case 4:
                        abril=dato.cant;
                        break;
                        
                        case 5:
                        mayo=dato.cant;
                        break;
                       
                        case 6:
                        junio=dato.cant;
                        break;
                        
                        case 7:
                        julio=dato.cant;
                        break;
                        
                        case 8:
                        agosto=dato.cant;
                        break;
                        
                        case 9:
                        septiembre=dato.cant;
                        
                        break;
                        case 10:
                        octubre=dato.cant;
                        break;
                        
                        case 11:
                        noviembre=dato.cant;
                        break;
                        
                        case 12:
                        diciembre=dato.cant;
                        break;
                      }
                });
                valor = `<tr> 
                    <td>${mod}</td>
                    <td>${enero}</td>
                    <td>${febrero}</td>
                    <td>${marzo}</td>
                    <td>${abril}</td>
                    <td>${mayo}</td>
                    <td>${junio}</td>
                    <td>${julio}</td>
                    <td>${agosto}</td>
                    <td>${septiembre}</td>
                    <td>${octubre}</td> 
                    <td>${noviembre}</td> 
                    <td>${diciembre}</td>
                    </tr>`
                    
                   switch(j){
                       case 1:
                        $("#reportesdelitos").html(valor);
                        break;
                        case 2:
                            $("#reportesdelitos2").html(valor);
                            break;
                        case 3:
                            $("#reportesdelitos3").html(valor);
                            break;
                        case 4:
                        $("#reportesdelitos4").html(valor);
                        break;
                        case 5:
                            $("#reportesdelitos5").html(valor);
                            break;
                        case 6:
                            $("#reportesdelitos6").html(valor);
                            break;
                        case 7:
                            $("#reportesdelitos7").html(valor);
                            break;
                        case 8:
                             $("#reportesdelitos8").html(valor);
                             break;
                        case 9:
                            $("#reportesdelitos9").html(valor);
                            break;
                        case 10:
                            $("#reportesdelitos10").html(valor);
                            break;
                        case 11:
                            $("#reportesdelitos11").html(valor);
                            break;
                        case 12:
                            $("#reportesdelitos12").html(valor);
                            break;
                        case 13:
                            $("#reportesdelitos13").html(valor);
                            break;
                        case 14:
                            $("#reportesdelitos14").html(valor);
                            break;
                        case 15:
                            $("#reportesdelitos15").html(valor);
                            break;        
                           
                   }
                }                          
            }
        });
  }     

}













});
