var idProyecto = undefined;
var PANELES = (function() {
     var private = {
         'ASOCIACION': 0,
         'PROYECTO': 1,
         'INTEGRANTE': 2,
         'INTEGRANTE_PROYECTO': 3
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
            automatizarSeleccion( "tablaAsociaciones", invocarMostrarProyectos );
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
        id:"btnMostrarIntegranteProyecto",
        caption:"Mostrar Integrantes del Proyecto", 
        buttonicon:"ui-icon-add", 
        onClickButton: mostrarIntegrantesProyecto,
        position:"last"
    });
    jQuery("#tablaIntegrantes").jqGrid('navButtonAdd','#piePaginaTablaIntegrantes',{
        id:"btnAsignarIntegranteProyecto",
        caption:"Asignar Integrante a Proyecto", 
        buttonicon:"ui-icon-add", 
        onClickButton: asignarIntegranteProyecto, 
        position:"last"
    });
    
    jQuery("#tablaIntegrantesProyectos").jqGrid({
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
        pager: jQuery('#piePaginaTablaIntegrantesProyectos'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Integrantes Proyectos",
        multiselect: false,
        shrinkToFit: false
    });
    jQuery("#tablaIntegrantesProyectos").jqGrid('setGridWidth','100%');
    jQuery("#tablaIntegrantesProyectos").jqGrid('navGrid','#piePaginaTablaIntegrantesProyectos',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tablaIntegrantesProyectos").jqGrid('navButtonAdd','#piePaginaTablaIntegrantesProyectos',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: invocarMostrarIntegrantes
    });
    jQuery("#tablaIntegrantesProyectos").jqGrid('navButtonAdd','#piePaginaTablaIntegrantesProyectos',{
        id:"btnEliminarIntegrantesProyecto",
        caption:"Eliminar Integrante", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocaEliminarIntegrantesProyectos, 
        position:"last"
    });
    jQuery("#tablaIntegrantesProyectos").jqGrid('navButtonAdd','#piePaginaTablaIntegrantesProyectos',{
        id:"btnActualizarRegistros",
        caption:"Guardar", 
        buttonicon:"ui-icon-add", 
        onClickButton: invocaActualizarRegistros, 
        position:"last"
    });

    // prepara el drag and drop
    jQuery("#tablaIntegrantes").jqGrid('gridDnD',{connectWith:'#tablaIntegrantesProyectos'});
    
    inicializaAcordion();
    
    ajusteTamanos();    
});   

function invocaEliminarIntegrantesProyectos(){
    var id = obtenerIDObjetoTablaIntegrantesProyectos();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    mostrarConfirmacionEliminar();
}

function invocarMostrarProyectos(){
    removerElementosTabla("tablaProyectos");
    //$("#tablaIntegrantesProyectos").jqGrid('setGridState', 'visible');
    var id = obtenerIDObjetoTablaAsociaciones();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/integrantesproyectos.php",
        data: { a: "q",
                id: id },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosProyectos(resultado) ){
                irPanel( PANELES.get("PROYECTO") );
                automatizarSeleccion( "tablaProyectos", invocarMostrarIntegrantes );
            }
        }
    });
    //clicExpandirColapsarTabla("tablaIntegrantesProyectos");
}

function invocarMostrarIntegrantes(){
    removerElementosTabla("tablaIntegrantesProyectos");
    //$("#tablaIntegrantesProyectos").jqGrid('setGridState', 'visible');
    var id = obtenerIDObjetoTablaProyectos();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    idProyecto = id;
    // ir por los datos a la base de datos
    $.ajax({
        url:"../controller/integrantesproyectos.php",
        data: { a: "qi",
                id: idProyecto },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            if( colocarDatosIntegrantes(resultado) ){
                irPanel( PANELES.get("INTEGRANTE") );
            }
        }
    });
    //clicExpandirColapsarTabla("tablaIntegrantesProyectos");
}

function asignarIntegranteProyecto(){
    var integrante = obtenerObjetoTablaIntegrantes();
    if( integrante == null || !integrante.hasOwnProperty("Id") ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    agregarElementoTabla("tablaIntegrantesProyectos", integrante);
    mostrarIntegrantesProyecto();
    mostrarMensajeDebeGuardarParaReflejarCambios();
}

function mostrarIntegrantesProyecto(){
    irPanel( PANELES.get("INTEGRANTE_PROYECTO") );
}

function obtenerIDObjetoTablaAsociaciones(){
    return obtenerIDObjetoTabla('tablaAsociaciones');
}

function obtenerIDObjetoTablaProyectos(){
    return obtenerIDObjetoTabla('tablaProyectos');
}

function obtenerIDObjetoTablaIntegrantesProyectos(){
    return obtenerIDObjetoTabla("tablaIntegrantesProyectos");
}

function obtenerObjetoTablaIntegrantes(){
    return obtenerObjetoTabla('tablaIntegrantes');
}

function colocarDatosProyectos(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.Proyectos == null || resultadoObject.Proyectos.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        return colocarDatosEnTabla("tablaProyectos",resultadoObject.Proyectos);
    }
}

function colocarDatosIntegrantes(resultado){
    var resultadoObject = JSON.parse( resultado );
    if( resultadoObject == null || resultadoObject.length == 0 ||
        resultadoObject.IntegranteProyectos == null || resultadoObject.IntegranteProyectos.length == 0 ){
        mostrarMensaje("No existe elementos para mostrar.", "Aviso");
        return false;
    }else{
        return colocarDatosEnTabla("tablaIntegrantesProyectos",resultadoObject.IntegranteProyectos,"Integrante");
    }
}

function aceptarEliminar(){
    var id = obtenerIndiceTabla("tablaIntegrantesProyectos");
    // eliminar el elemento solo de la tabla
    $("#tablaIntegrantesProyectos").jqGrid('delRowData', id);
    cerrarDialogoEliminar();
    refrescarConsulta();
    mostrarMensajeDebeGuardarParaReflejarCambios();
}

function aceptarActualizarRegistros(){
    if( idProyecto == undefined ){
        return;
    }
    var indices = $("#" + "tablaIntegrantesProyectos").getDataIDs(); // Get All IDs
    var datos = [];
    for (var i = 0; i < indices.length; i++){
        var integrante = $("#" + "tablaIntegrantesProyectos").getRowData(indices[i]);
        var integranteProyecto = { FkIntegrante: integrante.Id, FkProyecto: idProyecto };
        datos.push( integranteProyecto );
    }
    var accion = "u";
    // actualizar los elementos en la base de datos
    $.ajax({
        url:"../controller/integrantesproyectos.php",
        data: { a: accion,
                id: idProyecto,
                objeto: JSON.stringify( datos ) },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            cerrarDialogoActualizarRegistros();
            mostrarIntegrantesProyecto();
        }
    });
}