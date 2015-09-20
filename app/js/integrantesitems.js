var idIntegrante = undefined;
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

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // crea la tabla
    jQuery("#tablaAsociaciones").jqGrid({
        url:'../controller/asociaciones.php?a=q',
        datatype: "json",
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
        onClickButton: function () {
            $("#tablaAsociaciones").setGridParam({datatype: 'json'}); 
            $("#tablaAsociaciones").trigger('reloadGrid');
        }
    });
    jQuery("#tablaAsociaciones").jqGrid('navButtonAdd','#piePaginaTablaAsociaciones',{
        id:"btnMostrarIntegrantes",
        caption:"Mostrar Integrantes", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocarMostrarIntegrantes, 
        position:"last"
    });
    
    jQuery("#tablaIntegrantes").jqGrid({
        datatype: "local",
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
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaIntegrantes").jqGrid('setGridWidth','100%');
    jQuery("#tablaIntegrantes").jqGrid('navGrid','#piePaginaTablaIntegrantes',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarIntegrantes
    });
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
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
        id:"btnEliminarIntegranteItems",
        caption:"Eliminar Integrante", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocaEliminarIntegranteItems, 
        position:"last"
    });
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navButtonAdd','#piePaginaTablaIntegranteItemsAportacion',{
        id:"btnActualizarRegistros",
        caption:"Guardar", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocaActualizarRegistros, 
        position:"last"
    });
    jQuery("#tablaIntegranteItemsAportacion").jqGrid('navButtonAdd','#piePaginaTablaIntegranteItemsAportacion',{
        id:"btnAgregarIntegranteItems",
        caption:"Agregar Aportación", 
        buttonicon:"ui-icon-add", 
        onClickButton: agregar, 
        position:"last"
    });
    
    inicializaAcordion();
    
    inicializaDialogoItem(undefined, 460);
    
    ajusteTamanos();
});   

function colocarComponentesFechas(){
    $( "#txtFecha" ).datepicker({ changeYear: true, yearRange: "2014:2034", dateFormat: "yy-mm-dd" });
}

function aceptar(){
    var valid = true;
    // colocar cajas de texto en variables
    id = $( "#txtId" ),
    idItem = $( "#txtIdItem" ),
    idIntegrante = $( "#txtIdIntegrante" ),
    monto = $( "#txtMonto" ),
    fecha = $( "#txtFecha" ),
    nota = $( "#txtNota" ),
    allFields = $( [] ).add( idItem ).add( idIntegrante ).add( monto ).add( fecha ).add( nota ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
        
    valid = valid && checkLength( idItem, "Nombre", 1, 12 );
    valid = valid && checkLength( idIntegrante, "Integrante", 1, 12 );    
    valid = valid && checkLength( monto, "Monto", 0, 12 );
    valid = valid && checkLength( fecha, "Fecha", 0, 12 );
    valid = valid && checkLength( nota, "Nota", 0, 255 );
    
    if ( valid ) {
        var item = {
            Id: id.val(),
            FkItem: idItem.val(),
            FkIntegrante: idIntegrante.val(),
            Monto: monto.val(),
            Fecha: fecha.val(),
            Nota: nota.val()
        };
        var accion = "a";
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/aportaciones.php",
            data: { a: accion,
                    objeto: JSON.stringify( item ) },
            success:function( resultado ){
                if( validaExcepcion( resultado ) ){
                    mostrarMensajeExcepcion( resultado );    
                }
                dialogoItem.dialog( "close" );
                invocarMostrarIntegranteItems();
            }
        });
    }
    return valid;
}

function invocaEliminarIntegranteItems(){
    var id = obtenerIDObjetoTablaIntegranteItemsAportacion();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    mostrarConfirmacionEliminar();
}

function agregar(){
    $.get("aportacion.html?a=add", function(data){
        objDetalle = undefined;
        prepararDivItem( data, "Agregar" );
        var objeto = obtenerDatosParaAportacion();
        colocarValores( objeto );
        colocarFoco();
    });
}

function colocarFoco(){
    $( "#txtMonto" ).focus();
}

function obtenerDatosParaAportacion(){
    var objeto = new Object();
    var idIntegrante = obtenerIDObjetoTablaIntegrantes();
    var integrante = obtenerObjetoTablaIntegrantes();
    var idItem = obtenerIDObjetoTablaItems();
    var item = obtenerObjetoTablaItems();
    
    objeto.idIntegrante = idIntegrante;
    objeto.integrante = integrante.Nombre + " " + integrante.ApellidoPaterno + " " + integrante.ApellidoMaterno;
    objeto.idItem = idItem;
    objeto.nombre = item.Nombre;
    return objeto;
}

function colocarValores( objeto ){
    $( "#txtIdIntegrante" ).val( objeto.idIntegrante );    
    $( "#txtIntegrante" ).val( objeto.integrante );
    $( "#txtIdItem" ).val( objeto.idItem );    
    $( "#txtNombre" ).val( objeto.nombre );    
}

function invocarMostrarIntegrantes(){
    removerElementosTabla("tablaIntegrantes");
    var id = obtenerIDObjetoTablaAsociaciones();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/integrantesasociaciones.php",
        data: { a: "q",
                id: id },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosIntegrantes(resultado) ){
                irPanel( PANELES.get("INTEGRANTE") );
            }            
        }
    });
}

function invocarMostrarProyectos(){
    removerElementosTabla("tablaProyectos");
    //$("#tablaIntegrantes").jqGrid('setGridState', 'visible');
    var id = obtenerIDObjetoTablaIntegrantes();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    idIntegrante = id;
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/integrantesproyectos.php",
        data: { a: "qp",
                id: id },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosProyectos(resultado) ){
                irPanel( PANELES.get("PROYECTO") );
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
    // ir por los datos a la base de datos
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

function colocarDatosIntegrantes(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.IntegranteAsociacions == null || resultadoObject.IntegranteAsociacions.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        for(var i=0;i<resultadoObject.IntegranteAsociacions.length;i++){
            $("#tablaIntegrantes").jqGrid('addRowData',i+1,resultadoObject.IntegranteAsociacions[i].Integrante);
        }
        return true;
    }
}

function colocarDatosProyectos(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.IntegranteProyectos == null || resultadoObject.IntegranteProyectos.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        for(var i=0;i<resultadoObject.IntegranteProyectos.length;i++){
            $("#tablaProyectos").jqGrid('addRowData',i+1,resultadoObject.IntegranteProyectos[i].Proyecto);
        }
        return true;
    }
}

function colocarDatosItems(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.Items == null || resultadoObject.Items.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        for(var i=0;i<resultadoObject.Items.length;i++){
            $("#tablaItems").jqGrid('addRowData',i+1,resultadoObject.Items[i]);
        }
        return true;
    }
}

function colocarDatosIntegranteItemsAportacion(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.Aportacions == null || resultadoObject.Aportacions.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        for(var i=0;i<resultadoObject.Aportacions.length;i++){
            $("#tablaIntegranteItemsAportacion").jqGrid('addRowData',i+1,resultadoObject.Aportacions[i]);
        }
        return true;
    }
}

function aceptarEliminar(){
    var id = obtenerIndiceTabla("tablaIntegranteItemsAportacion");
    // eliminar el elemento solo de la tabla
    $("#tablaIntegranteItemsAportacion").jqGrid('delRowData', id);
    cerrarDialogoEliminar();
    refrescarConsulta();
    mostrarMensajeDebeGuardarParaReflejarCambios();
}

function aceptarActualizarRegistros(){
    if( idIntegrante == undefined ){
        return;
    }
    var indices = obtenerIDsObjetosTablaJSON("tablaIntegranteItemsAportacion"); // Get All IDs
    var accion = "u";
    // actualizar los elementos en la base de datos
    $.ajax({
        url:"../controller/aportaciones.php",
        data: { a: accion,
                id: idIntegrante,
                objeto: JSON.stringify( indices ) },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            cerrarDialogoActualizarRegistros();
            invocarMostrarIntegranteItems();//es como refrescarConsulta
        },
        error:function( resultado ){
            mostrarMensajeExcepcion( resultado );    
            cerrarDialogoActualizarRegistros();
            invocarMostrarIntegranteItems();//es como refrescarConsulta
        }
    });
}