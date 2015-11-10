var idAsociacion = undefined;
var PANELES = (function() {
     var private = {
         'ASOCIACION': 0,
         'INTEGRANTE': 1,
         'INTEGRANTE_ASOCIACION': 2
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
        shrinkToFit: false,
        loadComplete: function(data) {
            automatizarSeleccion( "tablaAsociaciones", invocarMostrarIntegrantes );
        }
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
        url:'../controller/integrantes.php?a=q',
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
        shrinkToFit: false
    });
    jQuery("#tablaIntegrantes").jqGrid('setGridWidth','100%');
    jQuery("#tablaIntegrantes").jqGrid('navGrid','#piePaginaTablaIntegrantes',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: function () {
            $("#tablaIntegrantes").setGridParam({datatype: 'json'}); 
            $("#tablaIntegrantes").trigger('reloadGrid');
        }
    });
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        id:"btnMostrarIntegranteAsociacion",
        caption:"Mostrar Integrantes de la Asociación", 
        buttonicon:"ui-icon-add", 
        onClickButton: mostrarIntegrantesAsociacion,
        position:"last"
    });
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        id:"btnAsignarIntegranteAsociacion",
        caption:"Asignar Integrante a Asociación", 
        buttonicon:"ui-icon-add", 
        onClickButton: asignarIntegranteAsociacion, 
        position:"last"
    });
    
    jQuery("#tablaIntegrantesAsociaciones").jqGrid({
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
        pager: jQuery('#piePaginaTablaIntegrantesAsociaciones'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Integrantes de Asociación",
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaIntegrantesAsociaciones").jqGrid('setGridWidth','100%');
    jQuery("#tablaIntegrantesAsociaciones").jqGrid('navGrid','#piePaginaTablaIntegrantesAsociaciones',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaIntegrantesAsociaciones").jqGrid('navButtonAdd','#piePaginaTablaIntegrantesAsociaciones',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarIntegrantes
    });
    jQuery("#tablaIntegrantesAsociaciones").jqGrid('navButtonAdd','#piePaginaTablaIntegrantesAsociaciones',{
        id:"btnEliminarIntegrantesAsociacion",
        caption:"Eliminar Integrante", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocaEliminarIntegrantesAsociaciones, 
        position:"last"
    });
    jQuery("#tablaIntegrantesAsociaciones").jqGrid('navButtonAdd','#piePaginaTablaIntegrantesAsociaciones',{
        id:"btnActualizarRegistros",
        caption:"Guardar", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocaActualizarRegistros, 
        position:"last"
    });

    inicializaAcordion();
    
    ajusteTamanos();
});   

function invocaEliminarIntegrantesAsociaciones(){
    var id = obtenerIDObjetoTablaIntegrantesAsociaciones();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    mostrarConfirmacionEliminar();
}

function invocarMostrarIntegrantes(){
    removerElementosTabla("tablaIntegrantesAsociaciones");
    //$("#tablaIntegrantesAsociaciones").jqGrid('setGridState', 'visible');
    var id = obtenerIDObjetoTablaAsociaciones();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    idAsociacion = id;
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/integrantesasociaciones.php",
        data: { a: "q",
                id: idAsociacion },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatos(resultado) ){
                irPanel( PANELES.get("INTEGRANTE") );
            }
        }
    });
    //clicExpandirColapsarTabla("tablaIntegrantesAsociaciones");
}

function asignarIntegranteAsociacion(){
    var integrante = obtenerObjetoTablaIntegrantes();
    if( integrante == null || !integrante.hasOwnProperty("Id") ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    agregarElementoTabla("tablaIntegrantesAsociaciones", integrante);
    mostrarIntegrantesAsociacion();
    mostrarMensajeDebeGuardarParaReflejarCambios();
}

function mostrarIntegrantesAsociacion(){
    irPanel( PANELES.get("INTEGRANTE_ASOCIACION") );
}

function obtenerIDObjetoTablaAsociaciones(){
    return obtenerIDObjetoTabla('tablaAsociaciones');
}

function obtenerIDObjetoTablaIntegrantesAsociaciones(){
    return obtenerIDObjetoTabla("tablaIntegrantesAsociaciones");
}

function obtenerObjetoTablaIntegrantes(){
    return obtenerObjetoTabla('tablaIntegrantes');
}

function colocarDatos(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.IntegranteAsociacions == null || resultadoObject.IntegranteAsociacions.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        return colocarDatosEnTabla("tablaIntegrantesAsociaciones", resultadoObject.IntegranteAsociacions, "Integrante");
    }
}

function aceptarEliminar(){
    var id = obtenerIndiceTabla("tablaIntegrantesAsociaciones");
    // eliminar el elemento solo de la tabla
    $("#tablaIntegrantesAsociaciones").jqGrid('delRowData', id);
    cerrarDialogoEliminar();
    refrescarConsulta();
    mostrarMensajeDebeGuardarParaReflejarCambios();
}

function aceptarActualizarRegistros(){
    if( idAsociacion == undefined ){
        return;
    }
    var indices = $("#" + "tablaIntegrantesAsociaciones").getDataIDs(); // Get All IDs
    var datos = [];
    for (var i = 0; i < indices.length; i++){
        var integrante = $("#" + "tablaIntegrantesAsociaciones").getRowData(indices[i]);
        var integranteAsociacion = { FkIntegrante: integrante.Id, FkAsociacion: idAsociacion };
        datos.push( integranteAsociacion );
    }
    var accion = "u";
    // actualizar los elementos en la base de datos
    $.ajax({
        url:"../controller/integrantesasociaciones.php",
        data: { a: accion,
                id: idAsociacion,
                objeto: JSON.stringify( datos ) },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            cerrarDialogoActualizarRegistros();
            mostrarIntegrantesAsociacion();
        }
    });
}