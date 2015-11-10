var idIntegrante = undefined;
var datosGrafica = null;
var datosGraficaGeneral = null;
var datosGraficaComparativa = null;
var itemAportacionGeneral = null;
var chart = null;
var chartGeneral = null;
var chartComparativo = null;

var PANELES = (function() {
     var private = {
         'ASOCIACION': 0,
         'INTEGRANTE': 1,
         'PROYECTO': 2,
         'ITEMS_PROYECTO': 3,
         'INTEGRANTE_ITEMS': 4
     };

     return {
        get: function(name) { return private[name]; }
    };
})();

Chart.defaults.global.tooltipTemplate = "<%if (label){%><%=label%>: <%}%><%=formatearNumeroAMoneda(value)%>";
Chart.defaults.global.multiTooltipTemplate = "<%=formatearNumeroAMoneda(value)%>";

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    $( "#btnRegresar" ).click( mostrarTabla );
    $( "#btnRegresarGraficoGeneral" ).click( mostrarTabla );
    $( "#btnRegresarGraficoComparativo" ).click( mostrarTabla );    
    
    jQuery("#tablaIntegrantes").jqGrid({
        url:'../controller/integrantes.php?a=qu',
        datatype: "json",
        colNames:['ID', 'Usuario', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Fecha Nacimiento', 'R.F.C.', 'C.U.R.P.', 'Domicilio', 'Estado Civil', 'Correo Electrónico', 'Ocupación', 'Quien Recomienda', 'Observaciones'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Usuario.Usuario',index:'Usuario.Usuario', width:130},
            {name:'Nombre',index:'Nombre', width:160},
            {name:'ApellidoPaterno',index:'ApellidoPaterno', width:160},
            {name:'ApellidoMaterno',index:'ApellidoMaterno', width:160},
            {name:'FechaNacimiento',index:'FechaNacimiento', width:100, align:"center"},
            {name:'Rfc',index:'Rfc', width:100},
            {name:'Curp',index:'Curp', width:100},
            {name:'Domicilio',index:'Domicilio', width:350},
            {name:'EstadoCivil',index:'EstadoCivil', width:100},
            {name:'CorreoElectronico',index:'CorreoElectronico', width:160},
            {name:'Ocupacion',index:'Ocupacion', width:160},
            {name:'QuienRecomienda',index:'QuienRecomienda', width:200},            
            {name:'Observaciones',index:'Observaciones', width:350}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTablaIntegrantes'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Integrantes",
        jsonReader: { 
            root: "Integrantes"
        },
        multiselect: false,
        shrinkToFit: false,
        loadComplete: function(data) {
            automatizarSeleccion( "tablaIntegrantes", invocarMostrarAsociaciones );
        }
    });
    jQuery("#tablaIntegrantes").jqGrid('setGridWidth','100%');
    jQuery("#tablaIntegrantes").jqGrid('navGrid','#piePaginaTablaIntegrantes',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: function () {
            $("#tablaAsociaciones").setGridParam({datatype: 'json'}); 
            $("#tablaAsociaciones").trigger('reloadGrid');
        }
    });
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        id:"btnMostrarAsociaciones",
        caption:"Mostrar Asociaciones", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocarMostrarAsociaciones, 
        position:"last"
    });
    
    // crea la tabla
    jQuery("#tablaAsociaciones").jqGrid({
        datatype: "local",
        colNames:['ID','Asociación', 'Contacto', 'Domicilio', 'Teléfono', 'Correo Electrónico'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Nombre',index:'Nombre', width:390},
            {name:'Contacto',index:'Contacto', width:200},
            {name:'Domicilio',index:'Domicilio', width:350},
            {name:'Telefono',index:'Telefono', width:160},
            {name:'CorreoElectronico',index:'CorreoElectronico', width:160}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTablaAsociaciones'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Asociaciones",
        jsonReader: { 
            root: "Asociacions"
        },
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaAsociaciones").jqGrid('setGridWidth','100%');
    jQuery("#tablaAsociaciones").jqGrid('navGrid','#piePaginaTablaAsociaciones',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaAsociaciones").jqGrid('navButtonAdd','#piePaginaTablaAsociaciones',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarAsociaciones
    });
    jQuery("#tablaAsociaciones").jqGrid('navButtonAdd','#piePaginaTablaAsociaciones',{
        id:"btnMostrarProyectos",
        caption:"Mostrar Proyectos", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocarMostrarProyectos, 
        position:"last"
    });
    
    // crea la tabla
    jQuery("#tablaProyectos").jqGrid({
        datatype: "local",
        colNames:['ID', 'Nombre', 'Descripción', 'Contacto', 'Teléfono', 'Correo Electrónico', 'Fecha Alta', 'Fecha Inicio', 'Fecha Fin', 'Asociación'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Nombre',index:'Nombre', width:200},
            {name:'Descripcion',index:'Descripcion', width:300},
            {name:'Contacto',index:'Contacto', width:200},
            {name:'Telefono',index:'Telefono', width:160},
            {name:'CorreoElectronico',index:'CorreoElectronico', width:160},
            {name:'FechaAlta',index:'FechaAlta', width:100, align:"center"},
            {name:'FechaInicio',index:'FechaInicio', width:100, align:"center"},
            {name:'FechaFin',index:'FechaFin', width:100, align:"center"},
            {name:'Asociacion.Nombre',index:'Asociacion.Nombre', width:200}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTablaProyectos'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Proyectos",
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaProyectos").jqGrid('setGridWidth','100%');
    jQuery("#tablaProyectos").jqGrid('navGrid','#piePaginaTablaProyectos',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaProyectos").jqGrid('navButtonAdd','#piePaginaTablaProyectos',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarProyectos
    });
    jQuery("#tablaProyectos").jqGrid('navButtonAdd','#piePaginaTablaProyectos',{
        id:"btnMostrarItems",
        caption:"Mostrar Ítems", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocarMostrarItems, 
        position:"last"
    });

    // crea la tabla
    jQuery("#tablaItems").jqGrid({
        datatype: "local",
        colNames:['ID', 'Proyecto', 'Nombre', 'Descripción', 'Responsable', 'Tipo', 'Monto', 'Fecha Inicio', 'Fecha Fin'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Proyecto.Nombre',index:'Proyecto.Nombre', width:200},
            {name:'Nombre',index:'Nombre', width:200},
            {name:'Descripcion',index:'Descripcion', width:300},
            {name:'Responsable',index:'Responsable', width:200},
            {name:'Tipo',index:'Tipo', width:160, formatter:labelFunctionTipo},
            {name:'ItemAportacion.Monto',index:'ItemAportacion.Monto', width:160, align:"right", formatter:labelFunctionMoneda},
            {name:'ItemAportacion.FechaInicio',index:'ItemAportacion.FechaInicio', width:100, align:"center"},
            {name:'ItemAportacion.FechaFin',index:'ItemAportacion.FechaFin', width:100, align:"center"}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTablaItems'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Ítems",
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaItems").jqGrid('setGridWidth','100%');
    jQuery("#tablaItems").jqGrid('navGrid','#piePaginaTablaItems',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaItems").jqGrid('navButtonAdd','#piePaginaTablaItems',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarItems
    });
    jQuery("#tablaItems").jqGrid('navButtonAdd','#piePaginaTablaItems',{
        id:"btnMostrarIntegranteItems",
        caption:"Mostrar Integrante - Ítems", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocarMostrarIntegranteItems, 
        position:"last"
    });
        
    // crea la tabla
    jQuery("#tablaIntegranteItemsAportacion").jqGrid({
        datatype: "local",
        colNames:['ID', 'Monto', 'Fecha', 'Nota', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Monto Aportación Total', 'Fecha Inicio', 'Fecha Fin'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Monto',index:'Monto', width:160, align:"right", formatter:labelFunctionMoneda},
            {name:'Fecha',index:'Fecha', width:100, align:"center"},
            {name:'Nota',index:'Nota', width:100, align:"center"},
            {name:'Integrante.Nombre',index:'Integrante.Nombre', width:160},
            {name:'Integrante.ApellidoPaterno',index:'Integrante.ApellidoPaterno', width:160},
            {name:'Integrante.ApellidoMaterno',index:'Integrante.ApellidoMaterno', width:160},
            {name:'Item.ItemAportacion.Monto',index:'Item.ItemAportacion.Monto', width:160, align:"right", formatter:labelFunctionMoneda},
            {name:'Item.ItemAportacion.FechaInicio',index:'Item.ItemAportacion.FechaInicio', width:100, align:"center"},
            {name:'Item.ItemAportacion.FechaFin',index:'Item.ItemAportacion.FechaFin', width:100, align:"center"}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTablaIntegranteItemsAportacion'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Integrante - Ítems",
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('setGridWidth','100%');
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navGrid','#piePaginaTablaIntegranteItemsAportacion',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navButtonAdd','#piePaginaTablaIntegranteItemsAportacion',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarIntegranteItems
    });
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navButtonAdd','#piePaginaTablaIntegranteItemsAportacion',{
        id:"btnVerGrafica",
        caption:"Ver Gráfica", 
        buttonicon:"ui-icon-add", 
        onClickButton: verGrafica, 
        position:"last"
    });
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navButtonAdd','#piePaginaTablaIntegranteItemsAportacion',{
        id:"btnVerGraficaGeneral",
        caption:"Ver Gráfica General", 
        buttonicon:"ui-icon-add", 
        onClickButton: verGraficaGeneral, 
        position:"last"
    });
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navButtonAdd','#piePaginaTablaIntegranteItemsAportacion',{
        id:"btnVerGraficaComparativa",
        caption:"Ver Gráfica Comparativa", 
        buttonicon:"ui-icon-add", 
        onClickButton: verGraficaComparativa, 
        position:"last"
    });
    
    inicializaAcordion();
    
    mostrarTabla();
    ajusteTamanos();    
});   

function verGraficaGeneral(){
    if( datosGraficaGeneral == null ||
        itemAportacionGeneral == null ){
        return;
    }
    if( chartGeneral == null ){
        var datosParaGraficar = obtenerDatosParaGraficar(itemAportacionGeneral, datosGraficaGeneral);
        graficarGeneral( datosParaGraficar );
    }else{
        mostrarSeccion("divGraficoGeneral");
    }
}

function verGrafica(){
    if( datosGrafica == null  || 
        datosGrafica[0] == null ||
        datosGrafica[0].Item == null ){
        return;
    }
    if( chart == null ){
        var datosParaGraficar = obtenerDatosParaGraficar(datosGrafica[0].Item.ItemAportacion, datosGrafica.slice( 0 ));
        graficar( datosParaGraficar );
    }else{
        mostrarSeccion("divGrafico");
    }
}

function verGraficaComparativa(){
    if( datosGraficaComparativa == null ){
        return;
    }
    if( chartComparativo == null ){
        var datosParaGraficar = obtenerDatosParaGraficarComparativo(datosGraficaComparativa, obtenerIDObjetoTablaIntegrantes());
        graficarComparativo( datosParaGraficar );
    }else{
        mostrarSeccion("divGraficoComparativo");
    }
}

function obtenerDatosParaGraficarComparativo(aportaciones, idIntegrante){
    if( aportaciones == null ){
        return;
    }
    var datosParaGraficar = new Object();
    var etiquetas = [];
    var items = [];
    for(var j = 0; j < aportaciones.length; j++){
        var aportacion = aportaciones[ j ];
        if( aportacion == null ){
            continue;
        }
        if( idIntegrante == aportacion.FkIntegrante ){
            etiquetas.push( aportacion.FkIntegrante );
        }else{
            etiquetas.push( "" );
        }
        items.push( aportacion.Monto );
    }
    datosParaGraficar.etiquetas = etiquetas;
    datosParaGraficar.serie1 = items;
    return datosParaGraficar;
}

function obtenerDatosParaGraficar(itemAportacion, aportaciones){
    if( itemAportacion == null || aportaciones == null ){
        return;
    }
    
    var datosParaGraficar = new Object();
    
    var iteraciones = NaN;
    var fechaInicio = crearFecha( itemAportacion.FechaInicio );
    var fechaFin = crearFecha( itemAportacion.FechaFin );
    var milisegundos = fechaFin - fechaInicio;
    var dias = milisegundos / 1000 / 60 / 60 / 24;
    var meses = NaN;
    var diasPorMesPromedio = 30.41666666666667;
    var etiquetas = [];
    
    var items = [];
    
    if( dias > diasPorMesPromedio ){
        // aplica grafico por mes
        meses = dias / 30;
        iteraciones = Math.round( meses );
                
        var fechaIteracion = fechaInicio;
        var acumulaAportaciones = 0;
        for(var i = 0; i < iteraciones; i++){
            var huboAportacion = false;
            var sinFecha = false;
            
            for(var j = 0; j < aportaciones.length; j++){
                var aportacion = aportaciones[ j ];
                if( aportacion == null ){
                    continue;
                }                
                var fechaAportacion = crearFecha( aportacion.Fecha );
                if( !(fechaAportacion == null) ){
                    if( esMenorOIgual( fechaAportacion, fechaIteracion ) ){
                        acumulaAportaciones = Number(acumulaAportaciones) + Number(aportacion.Monto);
                        items.push( acumulaAportaciones );
                        etiquetas.push( formatoFechaMmm_YY( fechaIteracion ) );
                        aportaciones[ j ] = null;
                    }else{
                        if( !sinFecha && !etiquetaAnteriorIgual( etiquetas, fechaIteracion) ){
                            huboAportacion = true;
                            acumulaAportaciones = Number(acumulaAportaciones) + 0;
                            items.push( acumulaAportaciones );
                            etiquetas.push( formatoFechaMmm_YY( fechaIteracion ) );
                            break;
                        }else{
                            break;
                        }
                    }
                }else{
                    sinFecha = true;
                    huboAportacion = true;
                    acumulaAportaciones = Number(acumulaAportaciones) + Number(aportacion.Monto);
                    items.push( acumulaAportaciones );
                    etiquetas.push( formatoFechaMmm_YY( fechaIteracion ) );
                    aportaciones[ j ] = null;
                }
            }
                
            if( !huboAportacion && !etiquetaAnteriorIgual( etiquetas, fechaIteracion) ){
                acumulaAportaciones = Number(acumulaAportaciones) + 0;
                items.push( acumulaAportaciones );
                etiquetas.push( formatoFechaMmm_YY( fechaIteracion ) );                
            }
            fechaIteracion.setMonth( fechaIteracion.getMonth() + 1 );
        }
    }        
    if( isNaN( iteraciones ) ){
        // aplica grafico por dias, entonces sera solo por aportaciones
        iteraciones = Math.round( dias );
    }
    
    datosParaGraficar.etiquetas = etiquetas;
    datosParaGraficar.serie1 = acompleta( etiquetas, itemAportacion.Monto, iteraciones );
    datosParaGraficar.serie2 = items;

    return datosParaGraficar;
}

function graficar(datosParaGraficar){    
    var lineChartData = {
        datasets : [
            {
                label: "Ideal",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                
            },
            {
                label: "Aportaciones",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
            }
        ]
    }
    lineChartData.labels = datosParaGraficar.etiquetas;
    lineChartData.datasets[0].data = datosParaGraficar.serie1;
    lineChartData.datasets[1].data = datosParaGraficar.serie2;
    
    mostrarSeccion("divGrafico");
    if( chart == null ){           
        var ctx = document.getElementById("grafico").getContext("2d");
        chart = new Chart(ctx).Line(lineChartData,{responsive:true});
    }
}

function graficarComparativo(datosParaGraficar){    
    var barChartData = {
        datasets : [            
            {
                label: "Aportaciones",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)"
            }
        ]
    }
    barChartData.labels = datosParaGraficar.etiquetas;
    barChartData.datasets[0].data = datosParaGraficar.serie1;    
    
    mostrarSeccion("divGraficoComparativo");
    if( chartComparativo == null ){
        var ctx = document.getElementById("graficoComparativo").getContext("2d");
        chartComparativo = new Chart(ctx).Bar(barChartData,{responsive:true});
    }
}


function graficarGeneral(datosParaGraficar){    
    var lineChartData = {
        datasets : [
            {
                label: "Ideal",
                fillColor : "rgba(220,220,220,0.2)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                
            },
            {
                label: "Aportaciones",
                fillColor : "rgba(151,187,205,0.2)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
            }
        ]
    }
    lineChartData.labels = datosParaGraficar.etiquetas;
    lineChartData.datasets[0].data = datosParaGraficar.serie1;
    lineChartData.datasets[1].data = datosParaGraficar.serie2;
    
    mostrarSeccion("divGraficoGeneral");
    if( chartGeneral == null ){           
        var ctx = document.getElementById("graficoGeneral").getContext("2d");
        chartGeneral = new Chart(ctx).Line(lineChartData,{responsive:true});
    }
}

function ocultarTodo(){    
    $( "#divGrafico" ).hide();
    $( "#divGraficoGeneral" ).hide();
    $( "#divGraficoComparativo" ).hide();
    $( "#divTabla" ).hide(); 
}

function mostrarTabla(){ 
    mostrarSeccion("divTabla");
}

function mostrarSeccion(idSeccion){
    ocultarTodo();
    $( "#" + idSeccion ).show();
}

function crearFecha( fechaString ){
    if( fechaString == null || fechaString == "" || fechaString.length != 10 ){
        return null;
    }
    var ano = fechaString.substring(0,4);
    var mes = fechaString.substring(5,7);
    var dia = fechaString.substring(8);
    var fecha = new Date( ano, Number(mes)-1, dia );
    return fecha;
}

function etiquetaAnteriorIgual( etiquetas, fecha ){
    if( etiquetas == null || etiquetas.length == 0 ){
        return false;
    }
    var etiquetaAnterior = etiquetas[ etiquetas.length - 1 ];
    return etiquetaAnterior == formatoFechaMmm_YY( fecha );
}

function esMenorOIgual( fechaA, fechaB){
    colocarFechaInicioMes( fechaA );
    colocarFechaInicioMes( fechaB );
    return fechaA <= fechaB;
}

function colocarFechaInicioMes( fecha ){
    fecha.setDate( 1 );
    fecha.setHours( 0 );
    fecha.setMinutes( 0 );
    fecha.setMilliseconds( 0 );
}

var MESES = (function() {
     var private = {
         0: "Ene",
         1: "Feb",
         2: "Mar",
         3: "Abr",
         4: "May",
         5: "Jun",
         6: "Jul",
         7: "Ago",
         8: "Sep",
         9: "Oct",
         10: "Nov",
         11: "Dic",
     };

     return {
        get: function(name) { return private[name]; }
    };
})();

function formatoFechaMmm_YY(dateIn) {    
    var yy = dateIn.getFullYear().toString().substring(2,4);
    var mmm = MESES.get( dateIn.getMonth() ); // getMonth() is zero-based
    //var dd  = dateIn.getDate();
    return mmm + " " + yy;
}

function acompleta( etiquetas, monto, iteraciones ){
    var datos = [];
    var numeroElementos = etiquetas.length;
    var aportacionIdeal = monto / iteraciones;
    var elemento = null;
    var aportacion = NaN;
    for ( var i = 0 , j = 0; i < numeroElementos ; i++ )
    {
        if( elemento == null || 
            elemento != etiquetas[i] ){
            aportacion = aportacionIdeal * j + aportacionIdeal;
            j++;
        }
        datos.push( aportacion );
        elemento = etiquetas[i];
    }
    return datos;
}

function invocarMostrarAsociaciones(){
    removerElementosTabla("tablaAsociaciones");
    var id = obtenerIDObjetoTablaIntegrantes();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/seguimientointegranteitems.php",
        data: { a: "qa",
                id: id },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosAsociaciones(resultado) ){
                irPanel( PANELES.get("INTEGRANTE") );
                automatizarSeleccion( "tablaAsociaciones", invocarMostrarProyectos );
            }            
        }
    });
}

function invocarMostrarProyectos(){
    removerElementosTabla("tablaProyectos");
    //$("#tablaIntegrantes").jqGrid('setGridState', 'visible');
    var idIntegrante = obtenerIDObjetoTablaIntegrantes();
    var idAsociacion = obtenerIDObjetoTablaAsociaciones();    
    if( idAsociacion == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/integrantesproyectos.php",
        data: { a: "qip",
                idIntegrante: idIntegrante,
                idAsociacion: idAsociacion },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosProyectos(resultado) ){
                irPanel( PANELES.get("PROYECTO") );
                automatizarSeleccion( "tablaProyectos", invocarMostrarItems );
            }            
        }
    });
}

function invocarMostrarItems(){
    removerElementosTabla("tablaItems");
    //$("#tablaIntegrantes").jqGrid('setGridState', 'visible');
    var id = obtenerIDObjetoTablaProyectos();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/items.php",
        data: { a: "qp",
                id: id },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosItems(resultado) ){
                irPanel( PANELES.get("ITEMS_PROYECTO") );
                automatizarSeleccion( "tablaItems", invocarMostrarIntegranteItems );
            }            
        }
    });
}

function invocarMostrarIntegranteItems(){
    removerElementosTabla("tablaIntegranteItemsAportacion");
    var idIntegrante = obtenerIDObjetoTablaIntegrantes();
    var idItem = obtenerIDObjetoTablaItems();
    var item = obtenerObjetoTablaItems();
    if( item == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }    
    var accion = null;
    var url = null;
    if( item.Tipo == CONSTANTES.get("APORTACION") ){
        url = "../controller/aportaciones.php";
        accion = "q";
    }
    if( item.Tipo == CONSTANTES.get("REQUISITOS") ){
        /*
        url = "../controller/requesitos.php";
        accion = "q";
        */
        mostrarMensajeError("Lo sentimos, por el momento esta opción no está implementada.");
    }
    // ir por los datos a la base de datos de las aportaciones del usuario
    $.ajax({
        url: url,
        data: { a: accion,
                idIntegrante: idIntegrante,
                idItem: idItem },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( item.Tipo == CONSTANTES.get("APORTACION") ){
                if( colocarDatosIntegranteItemsAportacion(resultado) ){
                    irPanel( PANELES.get("INTEGRANTE_ITEMS") );
                }
            }
        }
    });
    // ir por los datos a la base de datos de las aportaciones en general
    accion = "qg";
    $.ajax({
        url: url,
        data: { a: accion,
                idIntegrante: idIntegrante,
                idItem: idItem },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( item.Tipo == CONSTANTES.get("APORTACION") ){
                colocarDatosIntegrantesItemsAportacion(resultado);
            }
        }
    });
    // ir por los datos a la base de datos por el item aportacion en general
    accion = "qgia";
    $.ajax({
        url: url,
        data: { a: accion,
                idIntegrante: idIntegrante,
                idItem: idItem },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( item.Tipo == CONSTANTES.get("APORTACION") ){
                colocarDatosItemAportacionGeneral(resultado);
            }
        }
    });
    // ir por los datos a la base de datos por el item aportacion comparativo
    accion = "qgc";
    $.ajax({
        url: url,
        data: { a: accion,
                idItem: idItem },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( item.Tipo == CONSTANTES.get("APORTACION") ){
                colocarDatosItemAportacionComparativa(resultado);
            }
        }
    });
}

function obtenerIDObjetoTablaAsociaciones(){
    return obtenerIDObjetoTabla('tablaAsociaciones');
}

function obtenerIDObjetoTablaIntegrantes(){
    return obtenerIDObjetoTabla("tablaIntegrantes");
}

function obtenerIDObjetoTablaProyectos(){
    return obtenerIDObjetoTabla('tablaProyectos');
}

function obtenerIDObjetoTablaItems(){
    return obtenerIDObjetoTabla('tablaItems');
}

function obtenerObjetoTablaIntegrantes(){
    return obtenerObjetoTabla('tablaIntegrantes');
}

function obtenerObjetoTablaItems(){
    return obtenerObjetoTabla('tablaItems');
}

function obtenerIDObjetoTablaIntegranteItemsAportacion(){
    return obtenerIDObjetoTabla("tablaIntegranteItemsAportacion");
}

function colocarDatosAsociaciones(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.IntegranteAsociacions == null || resultadoObject.IntegranteAsociacions.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        return colocarDatosEnTabla("tablaAsociaciones",resultadoObject.IntegranteAsociacions,"Asociacion");
    }
}

function colocarDatosProyectos(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.IntegranteProyectos == null || resultadoObject.IntegranteProyectos.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        return colocarDatosEnTabla("tablaProyectos",resultadoObject.IntegranteProyectos,"Proyecto");
    }
}

function colocarDatosItems(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.Items == null || resultadoObject.Items.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        return colocarDatosEnTabla("tablaItems",resultadoObject.Items);
    }
}

function colocarDatosIntegranteItemsAportacion(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.Aportacions == null || resultadoObject.Aportacions.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        datosGrafica = resultadoObject.Aportacions;
        return colocarDatosEnTabla("tablaIntegranteItemsAportacion",resultadoObject.Aportacions);;
    }
}

function colocarDatosIntegrantesItemsAportacion(resultado){    
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        datosGraficaGeneral = new Array();        
        for(var i=0;i<resultadoObject.length;i++){
            datosGraficaGeneral.push( JSON.parse( resultadoObject[i] ) );
        }
        return true;
    }
}

function colocarDatosItemAportacionGeneral(resultado){    
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        itemAportacionGeneral = resultadoObject;
        return true;
    }
}

function colocarDatosItemAportacionComparativa(resultado){    
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{         
        datosGraficaComparativa = new Array();        
        for(var i=0;i<resultadoObject.length;i++){
            datosGraficaComparativa.push( JSON.parse( resultadoObject[i] ) );
        }
        return true;
    }
}