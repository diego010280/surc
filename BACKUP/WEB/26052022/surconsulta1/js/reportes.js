$(document).ready(function(){
    let ano; 
    let ur;
   
    var now = new Date();
    var dia = ("0" + now.getDate()).slice(-2);
    var mes = ("0" + (now.getMonth() + 1)).slice(-2);
    anio= now.getFullYear();
    var today = (anio)+"-"+(mes)+"-"+(dia);
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
        $("#reportesdelitos").empty();
        if(busq==="0"){
        ano = $("#selectorano").val();
        ur = $("#selectoruurr").val();
       
        $("#tablagraficos").hide();  
        reportedelito2(ano, ur);
        
        }else{
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


function grafica1(matriz, ano){
    
    
    me=['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
     
    if(anio == ano){
        me.length=mes;
    }
    var data=[];
    for(i=0; i<=matriz.length-1; i++){
         data[i] = {
            x: me,
            y: [matriz[i][1],matriz[i][2], matriz[i][3], matriz[i][4],matriz[i][5], matriz[i][6], matriz[i][7], matriz[i][8], matriz[i][9], matriz[i][10], matriz[i][11], matriz[i][12] ],
            name: matriz[i][0],
            type: 'scatter'
          };
    }
     var layout = {
       title: 'Datos estadisticos criminales mas relevantes'
     };
     Plotly.newPlot('graficoreportelineal', data, layout);
}


//////////////////TABLAS///////////////////
////FUNCION REPORTE   
function reportedelito2(ano, ur){
    val=0;
    $("#carg").show();
    $("#sinreg").hide();
    var matriz = new Array(130);
    for (var i=0;i<=129;i++) {
       matriz[i] = new Array(13);
    }
    for (var i=0;i<=129;i++) {
        for (var j=0;j<=12;j++) {
            matriz[i][j] = 0;
         }
     }      
     valor="";
     $.ajax({
        url: 'consultadelmo.php',
        type: 'POST',
        data: {val},
        success: function (respuesta) {
         let datos = JSON.parse(respuesta);
         
         let i=1;
         if(respuesta.length > 2){

            datos.forEach(dato => {
                if(i==1){      
                            if(ur==0){
                                valor +=` EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '${ano}' AND (SURC_Sumario_IdHechoDel = ${dato.delictivo}`;
                            }else{
                                valor +=` EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '${ano}' and UnidadReg_Codigo = '${ur}' AND (SURC_Sumario_IdHechoDel = ${dato.delictivo}`;
                            }              
                        
                    
                }else{
                        valor +=` OR SURC_Sumario_IdHechoDel = ${dato.delictivo}`;                    
                    }
              i++;
               });

         }else{
            valor=`(1`;
         }   
            valor+=`) AND SURC_Sumario_Tentativa <> 'S'`;
          $.ajax({
            url: 'reportedelito2.php',
            type: 'POST',
            data:{valor},
            success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                del="";
                del2="";
                contador=-1;
                valor="";
                h=0;
               if(respuesta.length>2){
                datos.forEach(dato => {
                    cant=dato.cant;
                    mess = dato.mes;
                    del=dato.delito;
                    
                    if(del != del2){
                        contador++;
                        del2=del;
                        matriz[contador][0] = del2;
                    }
                    matriz[contador][mess]=cant;
                });
                
                $("#carg").hide();
                for (var i=0;i<=129;i++) {
                    let suma=0;
                    if(matriz[i][0] != 0){
                    for (var j=1;j<=12;j++){
                        suma=suma + parseInt(matriz[i][j]);   
                    }                     
                      valor += `<tr> 
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
                    }else{
                            h++;
                           matriz[i].splice(0,13);
                   }
               }
                    matriz.length= i-h;
               $("#reportesdelitos").html(valor);
               if(ano<=anio){
                $("#tablagraficos").show(); 
               grafica1(matriz, ano);
               }               
              }else{
                $("#carg").hide();
                $("#sinreg").show();
              }
            }
        });
       }
    });
 }  
 


 function reportedelito3(ano, ur){
    val=1;
    $("#carg").show();
    $("#sinreg").hide();
    var matriz = new Array(130);
    for (var i=0;i<=129;i++) {
       matriz[i] = new Array(13);
    }
    for (var i=0;i<=129;i++) {
        for (var j=0;j<=12;j++) {
            matriz[i][j] = 0;
         }
     }    
     valor="";
     
     $.ajax({
        url: 'consultadelmo.php',
        type: 'POST',
        data: {val},
        success: function (respuesta) {
         let datos = JSON.parse(respuesta);
         let i=1;
        
         if(respuesta.length > 2){

            datos.forEach(dato => {
                if(dato.modalidad!=0){
                if(i==1){      
                            if(ur==0){
                                valor +=` EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '${ano}' AND (surc.vista_estadistica.SURC_Sumario_IdModalidad = ${dato.modalidad}`;
                            }else{
                                valor +=` EXTRACT(YEAR FROM SURC_Sumario_FechaDel) = '${ano}' and UnidadReg_Codigo = '${ur}' AND (surc.vista_estadistica.SURC_Sumario_IdModalidad = ${dato.modalidad}`;
                            }              
                        
                    
                }else{
                        valor +=` OR surc.vista_estadistica.SURC_Sumario_IdModalidad = ${dato.modalidad}`;                    
                    }
              i++;
                }
               });

         }else{
            valor=`(1`;
         }   
            valor+=`)`;
         
          $.ajax({
            url: 'reportedelito3.php',
            type: 'POST',
            data:{valor},
            success: function (respuesta) {
                let datos = JSON.parse(respuesta);
                
                del="";
                del2="";
                contador=-1;
                valor="";
                h=0;
               if(respuesta.length>2){
                datos.forEach(dato => {
                    cant=dato.cant;
                    mess = dato.mes;
                    del=dato.modalidad;
                    
                    if(del != del2){
                        contador++;
                        del2=del;
                        matriz[contador][0] = del2;
                    }
                    matriz[contador][mess]=cant;
                });
                
                $("#carg").hide();
                for (var i=0;i<=129;i++) {
                    let suma=0;
                    if(matriz[i][0] != 0){
                    for (var j=1;j<=12;j++){
                        suma=suma + parseInt(matriz[i][j]);   
                    }                     
                      valor += `<tr> 
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
                    }else{
                            h++;
                           matriz[i].splice(0,13);
                   }
               }
                    matriz.length= i-h;
               $("#reportesdelitos").html(valor);
               if(ano<=anio){
                $("#tablagraficos").show(); 
               grafica1(matriz, ano);
               }               
              }else{
                $("#carg").hide();
                $("#sinreg").show();
              }
            }
        });
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
