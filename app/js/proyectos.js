// variable para mostrar el detalle.
var objDetalle = undefined;

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
    correoElectronicoRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // crea la tabla
    jQuery("#tabla").jqGrid({
        url:'../controller/proyectos.php?a=q',
        datatype: "json",
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
        pager: jQuery('#piePaginaTabla'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Proyectos",
        jsonReader: { 
            root: "Proyectos"
        }
    });
    jQuery("#tabla").jqGrid('setGridWidth','100%');
    jQuery("#tabla").jqGrid('navGrid','#piePaginaTabla',{edit:false,add:false,del:false,search:true,refresh:false});
    jQuery("#tabla").jqGrid('navButtonAdd','#piePaginaTabla',{
        caption: "", 
        title: "Recargar datos", 
        buttonicon: "ui-icon-refresh",
        onClickButton: function () {
            $("#tabla").setGridParam({datatype: 'json'}); 
            $("#tabla").trigger('reloadGrid');
        }
    });
    jQuery("#tabla").jqGrid('navButtonAdd','#piePaginaTabla',{
        id:"btnAgregar",
        caption:"Agregar", 
        buttonicon:"ui-icon-add", 
        onClickButton: agregar, 
        position:"last"
    });
    jQuery("#tabla").jqGrid('navButtonAdd','#piePaginaTabla',{
        id:"btnEditar",
        caption:"Editar", 
        buttonicon:"ui-icon-edit", 
        onClickButton: invocaEditar, 
        position:"last"
    });
    jQuery("#tabla").jqGrid('navButtonAdd','#piePaginaTabla',{
        id:"btnEliminar",
        caption:"Eliminar", 
        buttonicon:"ui-icon-del", 
        onClickButton: invocaEliminar, 
        position:"last"
    });
    
    inicializaDialogoItem();
    
    ajusteTamanoCatalogo();
});   

function agregar(){
    $.get("Proyecto.html?a=add", function(data){
        objDetalle = undefined;
        prepararDivItem(data, "Agregar");
    });
}

function cargarCatalogos( funcionRetorno ){
    var totalCatalogos = 1;
    var catalogosRetornaron = 0;
    cargarCatalogoAsociaciones( function validaRetornos(){
                                    catalogosRetornaron++;
                                    if( totalCatalogos == catalogosRetornaron &&
                                        funcionRetorno != undefined ){
                                        funcionRetorno();
                                    }
                                } );
}

function cargarCatalogoAsociaciones( funcionRetorno ){
    $.ajax({
        url:"../controller/asociaciones.php",
        data: { a: "q" },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            colocarComponenteAsociaciones( resultado );
            colocarValorAsociacion();
            if( funcionRetorno != undefined ){
                funcionRetorno();
            }
        }
    });
}

function colocarComponenteAsociaciones( resultado ){
    var raiz = JSON.parse( resultado )
    var item = null;
    for(var i = 0; i < raiz["Asociacions"].length; i++ ){
        item = raiz["Asociacions"][i];
        /*
        $("#cmbAsociacion").append($("<option></option>")
                             .attr("value",item["Id"])
                             .text(item["Nombre"]));
        */
        $("#cmbAsociacion").append($("<option/>",{
                                    value: item["Id"],
                                    text: item["Nombre"] 
                                }) );
    }
}

function invocaEditar(){
    var id = obtenerIDObjetoTabla();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }
    // ir a la BD a traves del ID
    $.ajax({
        url:"../controller/proyectos.php",
        data: { a: "g",
                id: id},
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            objDetalle = JSON.parse( resultado );
            mostrarEditar( objDetalle );
        }
    });
}

function mostrarEditar( objeto ){
    $.get("Proyecto.html?a=edit", function(data){
        prepararDivItem( data, "Editar");
        colocarValores( objeto );
    });
}

function colocarValores( objeto ){
    $( "#txtId" ).val( objeto.Id );
    $( "#txtNombre" ).val( objeto.Nombre );
    $( "#txtDescripcion" ).val( objeto.Descripcion );
    $( "#txtContacto" ).val( objeto.Contacto );
    $( "#txtTelefono" ).val( objeto.Telefono );
    $( "#txtCorreoElectronico" ).val( objeto.CorreoElectronico );
    $( "#txtFechaInicio" ).val( objeto.FechaInicio );
    $( "#txtFechaFin" ).val( objeto.FechaFin );
    colocarValorAsociacion();
}

function colocarValorAsociacion(){
    // $('#cmbAsociacion')[0].childElementCount > 0
    // $('#cmbAsociacion').val()
    if( objDetalle != undefined && $('#cmbAsociacion option').length > 0 ){
        $( "#cmbAsociacion" ).val( objDetalle.FkAsociacion );
    }
}

function colocarComponentesFechas(){
    $( "#txtFechaInicio" ).datepicker({ changeYear: true, yearRange: "2014:2034", dateFormat: "yy-mm-dd" });
    $( "#txtFechaFin" ).datepicker({ changeYear: true, yearRange: "2014:2034", dateFormat: "yy-mm-dd" });
}

function aceptar(){
    var valid = true;
    // colocar cajas de texto en variables
    id = $( "#txtId" ),
    nombre = $( "#txtNombre" ),
    descripcion = $( "#txtDescripcion" ),
    contacto = $( "#txtContacto" ),
    telefono = $( "#txtTelefono" ),
    correoElectronico = $( "#txtCorreoElectronico" ),
    fechaInicio = $( "#txtFechaInicio" ),
    fechaFin = $( "#txtFechaFin" ),
    asociacion = $( "#cmbAsociacion" ),
    allFields = $( [] ).add( nombre ).add( descripcion ).add( contacto ).add( telefono ).add( correoElectronico ).add( fechaInicio ).add( fechaFin ).add( asociacion ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkLength( nombre, "Nombre", 3, 120 );
    valid = valid && checkLength( descripcion, "Descripción", 0, 255 );
    valid = valid && checkLength( contacto, "Contacto", 3, 255 );
    valid = valid && checkLength( telefono, "Teléfono", 0, 80 );//TODO: Revisar
    valid = valid && checkLength( correoElectronico, "Correo Electrónico",  0, 120 );
    valid = valid && checkLength( fechaInicio, "Fecha Inicio", 0, 12 );
    valid = valid && checkLength( fechaFin, "Fecha Fin", 0, 12 );
    valid = valid && checkSelected( asociacion, "Asociación" );
    
    if( correoElectronico.val().length > 0 ){
        valid = valid && checkRegexp( correoElectronico, correoElectronicoRegex, "ej. mgaytan@gahm.com.mx" );
    }

    if ( valid ) {
        var item = {
            Id: id.val(),
            Nombre: nombre.val(),
            Descripcion: descripcion.val(),
            Contacto: contacto.val(),
            Telefono: telefono.val(),
            CorreoElectronico: correoElectronico.val(),
            FechaInicio: fechaInicio.val(),
            FechaFin: fechaFin.val(),
            FkAsociacion: asociacion.val()
        };
        var accion = "a";
        if( id.val() != "" ){
            accion = "u";
        }
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/proyectos.php",
            data: { a: accion,
                    objeto: JSON.stringify( item ) },
            success:function( resultado ){
                if( validaExcepcion( resultado ) ){
                    mostrarMensajeExcepcion( resultado );    
                }
                dialogoItem.dialog( "close" );
                refrescarConsulta();
            }
        });
    }
    return valid;
}

function aceptarEliminar(){
    var id = obtenerIDObjetoTabla();
    // eliminar el elemento en la base de datos
    $.ajax({
        url:"../controller/proyectos.php",
        data: { a: "d",
                id: id },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            cerrarDialogoEliminar();
            refrescarConsulta();
        }
    });
}