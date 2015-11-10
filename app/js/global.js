/******************************************************************************
    Para validaciones.
******************************************************************************/

var CONSTANTES = (function() {
     var private = {
         'ID_APORTACION': '1',
         'APORTACION': 'Aportación',
         'ID_REQUISITOS': '2',
         'REQUISITOS': 'Requisitos'
     };

     return {
        get: function(name) { return private[name]; }
    };
})();



/******************************************************************************
    Para validaciones.
******************************************************************************/

// actualiza el estatus en un dialogo para las validaciones
function updateTips( t ) {
  tips
    .text( t )
    .addClass( "ui-state-highlight" );
  setTimeout(function() {
    tips.removeClass( "ui-state-highlight", 1500 );
  }, 500 );
}

// verifica la longitud de un campo
function checkLength( o, n, min, max ) {
  if ( o.val().length > max || o.val().length < min ) {
    o.addClass( "ui-state-error" );
    updateTips( "La longitud de " + n + " debe ser entre " +
      min + " y " + max + "." );
    return false;
  } else {
    return true;
  }
}

// verifica una expresion regular
function checkRegexp( o, regexp, n ) {
  if ( !( regexp.test( o.val() ) ) ) {
    o.addClass( "ui-state-error" );
    updateTips( n );
    return false;
  } else {
    return true;
  }
}

// verifica la seleccion de un capo del tipo select
function checkSelected( o, n, ceroNoValido ){
    var valido = false;
    if( o[0].childElementCount > 0 ){
        if( typeof(ceroNoValido) === 'undefined' ){
            valido = true;
        }else{
            if( o.val() != 0 ){
                valido = true;
            }            
        }        
    }
    if( !valido ){
        o.addClass( "ui-state-error" );
        updateTips( "Se debe seleccionar un valor para " + n + "." );
    }
    return valido;
}



/******************************************************************************
    Para dialogos.
******************************************************************************/

// coloca un titulo al diaglogo que este presente
function colocarTituloPopUp( titulo ){
    $("span.ui-dialog-title").text( titulo ); 
}

// cancela el dialogo del item, divItem
function cancelar(){
    dialogoItem.dialog( "close" );
}

// inicializa el diaglogo mensaje, divMensaje
function inicializaDialogoMensaje(){
    // configura el dialogo para los mensajes
    dialogoMensaje = $( "#divMensaje" ).dialog({        
        autoOpen: false,
        height: 150,
        width: 350,
        modal: true,
        buttons: {
        },
        close: function() {
        }
    });
}

// inicializa el diaglogo para el mensaje de confirma eliminar, divMensajeConfirmacionEliminar
function inicializaDialogoMensajeConfirmacionEliminar(){
    // configura el dialogo para los mensajes de confirmacion
    dialogoMensajeConfirmacionEliminar = $( "#divMensaje" ).dialog({
        autoOpen: false,
        height: 150,
        width: 220,
        modal: true,
        buttons: {
            "Sí": aceptarEliminar,
            "No": cancelarEliminar
        },
        close: function() {
        }
    });
    $( ".txtMensaje" ).text( "¿Desea eliminar el registro?" );
}

// inicializa el diaglogo para el mensaje de confirma eliminar, divMensajeConfirmacionEliminar
function inicializaDialogoMensajeConfirmacionActualizarRegistros(){
    // configura el dialogo para los mensajes de confirmacion
    dialogoMensajeConfirmacionActualizarRegistros = $( "#divMensaje" ).dialog({
        autoOpen: false,
        height: 150,
        width: 220,
        modal: true,
        buttons: {
            "Sí": aceptarActualizarRegistros,
            "No": cancelarActualizarRegistros
        },
        close: function() {
        }
    });
    $( ".txtMensaje" ).text( "¿Desea actualizar los registros?" );
}

// inicializa el diaglogo para el detalle
function inicializaDialogoItem( ancho, alto ){
    if( typeof(ancho) === 'undefined' ){
        ancho = 350;
    }
    if( typeof(alto) === 'undefined' ){
        alto = 415;
    }
    // configura el dialogo para mostrar el detalle
    dialogoItem = $( "#divItem" ).dialog({
        autoOpen: false,
        height: alto,
        width: ancho,
        modal: true,
        buttons: {
            "Aceptar": aceptar,
            "Cancelar": cancelar
        },
        close: function(){
        }
    });
}

function prepararDivItem(data, titulo){
    $("#divItem").html( data );
    ocultarComponentes();
    dialogoItem.dialog( "open" );
    colocarTituloPopUp( titulo );
    colocarComponentesFechas();
    cargarCatalogos();
}

function ocultarComponentes(){}

function colocarComponentesFechas(){}

function cargarCatalogos(){}



/******************************************************************************
    Para manejo excepciones.
******************************************************************************/

// valida si el resultado tiene una excepcion
function validaExcepcion( resultado ){
    if( resultado != null ){
        return resultado.indexOf("Exception") != -1;
    }
    return false;
}

// muestra el mensaje de la excepcion
function mostrarMensajeExcepcion( result ){
    mostrarMensajeError( result );                
    //mostrarMensajeError( result.substring( result.indexOf("message") + 9, result.indexOf(" in ") - 1 ) );                
}

// muestra un mensaje de error en el divMensaje
function mostrarMensajeError( mensaje, titulo ){
    if( titulo == undefined ){
        titulo = "Error";
    }
    mostrarMensaje( mensaje, titulo );
}

// muestra un mensaje de advertencia en el divMensaje
function mostrarMensajeAdvertencia( mensaje, titulo ){
    if( titulo == undefined ){
        titulo = "Advertencia";
    }
    mostrarMensaje( mensaje, titulo );
}

// muestra un mensaje en el divMensaje
function mostrarMensaje( mensaje, titulo ){
    inicializaDialogoMensaje();
    dialogoMensaje.dialog( "open" );
    $( ".txtMensaje" ).text( mensaje );
    colocarTituloPopUp( titulo );
}

function mostrarMensajeDebeGuardarParaReflejarCambios(){
    mostrarMensajeAdvertencia("Debe de presionar el botón Guardar para que se reflejen los cambios en la base de datos.");
}



/******************************************************************************
    Para manejo de funciones de la tabla.
******************************************************************************/

// obtiene el id del objeto seleccionado de la tabla, siendo el id una propiedad llamada id del objeto
function obtenerIDObjetoTabla( nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    var selr = jQuery('#' + nombreTabla).jqGrid('getGridParam','selrow');
    var dato = jQuery('#' + nombreTabla).jqGrid('getRowData', selr);
    return dato.Id;
}

// obtiene los IDs de los objetos seleccionados de la tabla
function obtenerIDsObjetosTablaJSON( nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    var indices = $("#" + nombreTabla).getDataIDs(); // Get All IDs
    var datos = [];
    for (var i = 0; i < indices.length; i++){
        var item = $("#" + nombreTabla).getRowData(indices[i]);
        datos.push( Number(item.Id) );
    }
    return datos;
}

// obtiene el objeto seleccionado de la tabla
function obtenerObjetoTabla( nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    var selr = jQuery('#' + nombreTabla).jqGrid('getGridParam','selrow');
    var dato = jQuery('#' + nombreTabla).jqGrid('getRowData', selr);
    return dato;
}

// obtiene el indice seleccionado de la tabla
function obtenerIndiceTabla( nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    var selr = jQuery('#' + nombreTabla).jqGrid('getGridParam','selrow');
    return selr;
}

// permite refrescar una consulta
function refrescarConsulta( nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    $("#" + nombreTabla).setGridParam({ 
                datatype: 'json',
             });
    $("#" + nombreTabla).trigger('reloadGrid');
}

// funje el clic en el boton superior izquierdo de la tabla, 
// lo cual expande o contrae la tabla
function clicExpandirColapsarTabla( nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    $(".ui-jqgrid-titlebar-close",$('#' + nombreTabla)[0].grid.cDiv).click();
}

// remueve los datos de la tabla
function removerElementosTabla(nombreTabla ){
    if( typeof(nombreTabla) === 'undefined' ){
        nombreTabla = "tabla";
    }
    $("#" + nombreTabla).jqGrid('clearGridData');
}

function seleccionarRegistro( nombreTabla, indice ){
    $("#" + nombreTabla).setSelection( indice );
}

function automatizarSeleccion( nombreTabla, invocacion){
    var numeroRegistros = numeroElementos( nombreTabla );    
    var validarNumeroRegistros = 1;
    if( numeroRegistros == validarNumeroRegistros ){
        var indice = 1;
        seleccionarRegistro( nombreTabla, indice);        
        invocacion();
    }
}



/******************************************************************************
    Para manejo de la funcion eliminar.
******************************************************************************/

// valida la seleccion del elemento de la tabla, y muestra el dialogo de 
// confirmacion para eliminar
function invocaEliminar(){
    var id = obtenerIDObjetoTabla();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    mostrarConfirmacionEliminar();
}

// muestra el dialogo de confirmacion para eliminar, divMensajeConfirmacionEliminar 
function mostrarConfirmacionEliminar( objeto ){
    inicializaDialogoMensajeConfirmacionEliminar();
    dialogoMensajeConfirmacionEliminar.dialog( "open" );    
    colocarTituloPopUp("Advertencia");
}

// cierra el dialogo de confirmacion para eliminar, divMensajeConfirmacionEliminar
function cancelarEliminar(){
    cerrarDialogoEliminar();
}

// cierra el dialogo de confirmacion para eliminar, divMensajeConfirmacionEliminar
function cerrarDialogoEliminar(){
    dialogoMensajeConfirmacionEliminar.dialog( "close" );
}



/******************************************************************************
    Para manejo de la funcion actualizar registros.
******************************************************************************/

// valida la seleccion del elemento de la tabla, y muestra el dialogo de 
// confirmacion para eliminar
function invocaActualizarRegistros(){
    mostrarConfirmacionActualizarRegistros();
}

// muestra el dialogo de confirmacion para eliminar, divMensajeConfirmacionEliminar 
function mostrarConfirmacionActualizarRegistros( objeto ){
    inicializaDialogoMensajeConfirmacionActualizarRegistros();
    dialogoMensajeConfirmacionActualizarRegistros.dialog( "open" );
    colocarTituloPopUp("Advertencia");
}

// cierra el dialogo de confirmacion para eliminar, divMensajeConfirmacionEliminar
function cancelarActualizarRegistros(){
    cerrarDialogoActualizarRegistros();
}

// cierra el dialogo de confirmacion para eliminar, divMensajeConfirmacionEliminar
function cerrarDialogoActualizarRegistros(){
    dialogoMensajeConfirmacionActualizarRegistros.dialog( "close" );
}



/******************************************************************************
    Para manejo de los paneles.
******************************************************************************/

// inicializa el div como un acordion
function inicializaAcordion( nombreDiv ){
    if( typeof(nombreDiv) === 'undefined' ){
        nombreDiv = "divAcordion";
    }
    $( "#" + nombreDiv ).accordion();
}

// va al panel indicado en un acordion
function irPanel( indicePanel ){
    $( "#divAcordion" ).accordion({ active: indicePanel });
}

function ajusteTamanos(){
    if( $( "#divAcordion" ) == null ){
        return;
    }
    var numeroTabs = $( "#divAcordion" ).children(".divSeccionAcordion").length;
    if( numeroTabs == 0 ){
        return;
    }
    var altoVentana = $(window).height();
    var margen = Number( remover( $("body").css("margin"), "px" ) );
    var espacioExtraMargen = 2;
    var espacioExtraExtraMargen = 15;
    var altoAcordion = altoVentana - ( ( margen + espacioExtraMargen ) * 2 ) - espacioExtraExtraMargen;
    $("#divAcordion").css( "height", altoAcordion );
    
    var altoH3 = Number( remover( $(".ui-accordion-header").css("height"), "px" ) );
    var espacioExtraTab = 20;
    var altoTab = altoAcordion - ( ( altoH3 + espacioExtraTab ) * numeroTabs );
    $(".divSeccionAcordion").css( "height", altoTab );
    
    var altoBarraHorizontalDesplazamiento = 18;
    var espacioEntreTabYTabla = 72;
    var altoTabla = altoTab - espacioEntreTabYTabla - altoBarraHorizontalDesplazamiento;
    $('.ui-jqgrid-bdiv').height( altoTabla );
}

function ajusteTamanoCatalogo(){
    var altoVentana = $(window).height();
    var margen = Number( remover( $("body").css("margin"), "px" ) );
    var espacioExtraMargen = 2;
    var espacioExtraExtraMargen = 15;
    var espacioEntreTabYTabla = 57;
    var altoTabla = altoVentana - ( ( margen + espacioExtraMargen ) * 2 ) - espacioExtraExtraMargen - espacioEntreTabYTabla;
    $('.ui-jqgrid-bdiv').height( altoTabla );
}

function remover(valor, remover){
    if( typeof valor == "string" ){
        return valor.replace( remover, "");
    }
    return valor;
}

function altoEspacioPrincipal(){
    var altoVentana = $(window).height() - 20;
    var altoHeader = 55; //$("header").height();
    var altoFooter = $("footer").height();
    var alto = altoVentana - altoHeader - altoFooter;
    return alto;
}

function anchoEspacioPrincipal(){
    var anchoVentana = $(window).width() - 4;
    return anchoVentana;
}



/******************************************************************************
    Labels Function reutilizables.
******************************************************************************/

// label function Tipo Item
function labelFunctionTipo (cellvalue, options, rowObject)
{
    if( rowObject.FkItemAportacion !=  undefined ){
        return CONSTANTES.get("APORTACION");
    }
    if( rowObject.FkItemRequisitos !=  undefined ){
        return CONSTANTES.get("REQUISITOS");
    }
    return "";
}

// label function moneda
function labelFunctionMoneda (cellvalue, options, rowObject)
{
    if( extractObject(rowObject,options.colModel.name) !=  null &&
        !isNaN( Number(extractObject(rowObject,options.colModel.name)) ) ){
        return Number(extractObject(rowObject,options.colModel.name)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    return "";
}



/******************************************************************************
    Funciones genericas.
******************************************************************************/

function extractObject(object, property){
    if( object == null || property == null ){
        return null;
    }
    var text = "";
    var properties = property.split(".");
    var objectTemp = object;
    var property = null;
    for ( var i = 0; i<properties.length; i++ ) 
    {
        property = properties[ i ];
        objectTemp = propertyOfObject( objectTemp, property );
    }
    return objectTemp;
}

function propertyOfObject(object, property){
    if( object == null ){
        return null;
    }else{
        if( object.hasOwnProperty( property ) ){
            return object[ property ];
        }else{
            return null;
        }
    }
}
        
function validarSesion(){
    $.ajax({
        url:"../controller/validarSesion.php",
        success:function( resultado ){
            if( !( resultado == null  || resultado == "" ) ){
                window.location.assign("../../app/view/sesionNoValida.html");
            }
        }
    });
}

function redireccionInicio(){
    window.location.assign("../../index.html");
}

function agregarElementoTabla(tabla, item){
    if( item == null ){
        return;
    }
    $("#"+tabla).jqGrid('addRowData', numeroElementos(tabla) + 1, item);
}

function numeroElementos(tabla){
    return $("#"+tabla).getGridParam("records");
}

function obtenerDatos( arreglo, propiedad, cadenaVacia, acumula ){
    if( typeof(acumula) === 'undefined' ){
        acumula = false;
    }
    if( arreglo == null || !arreglo.hasOwnProperty("length") ){
        return;
    }
    datos = [];
    var valor = null;
    for ( var i = 0; i<arreglo.length; i++ ) 
    {
        valor = extractObject( arreglo[ i ], propiedad );
        if( valor == null && cadenaVacia == true ){
            valor = "";
        }
        if( acumula == true &&
            i != 0 && 
            !isNaN( Number( valor ) ) &&
            !isNaN( Number( datos[ i - 1 ] )   ) ){
                datos[ i ] = Number( valor ) + Number( datos[ i - 1 ] );
        }else{
            datos[ i ] = valor;
        }
    }
    return datos;
}

function colocarDatosEnTabla(idTabla, origen, propiedad){
    var datos = new Array();
    for(var i=0;i<origen.length;i++){
        if( !(propiedad == null) ){
                datos.push( origen[i][propiedad] );
        }else{
            datos.push( origen[i] );
        }
    }        
    $("#"+idTabla).jqGrid('setGridParam', {data: datos});
    $("#"+idTabla)[0].refreshIndex();
    $("#"+idTabla).trigger("reloadGrid");
    return true;
}