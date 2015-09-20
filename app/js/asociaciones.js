$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
    correoElectronicoRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // crea la tabla
    jQuery("#tabla").jqGrid({
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
        pager: jQuery('#piePaginaTabla'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Asociaciones",
        jsonReader: { 
            root: "Asociacions"
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
    $.get("asociacion.html?a=add", function(data){
        prepararDivItem(data, "Agregar");
    });
}

function invocaEditar(){
    var id = obtenerIDObjetoTabla();
    if( id == null ){
        mostrarMensajeError("Primero debe de seleccionar un elemento de la tabla");
        return;
    }    
    // ir a la BD a traves del ID
    $.ajax({
        url:"../controller/asociaciones.php",
        data: { a: "g",
                id: id},
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            var obj = JSON.parse( resultado );
            // colocar el objeto para edicion
            mostrarEditar( obj );
        }
    });
}

function mostrarEditar( objeto ){
    $.get("asociacion.html?a=edit", function(data){
        prepararDivItem( data, "Editar");
        colocarValores( objeto );
    });
}

function colocarValores( objeto ){
    $( "#txtId" ).val( objeto.Id );
    $( "#txtNombre" ).val( objeto.Nombre );
    $( "#txtContacto" ).val( objeto.Contacto );
    $( "#txtDomicilio" ).val( objeto.Domicilio );
    $( "#txtTelefono" ).val( objeto.Telefono );
    $( "#txtCorreoElectronico" ).val( objeto.CorreoElectronico );
}

function aceptar(){
    var valid = true;
    // colocar cajas de texto en variables
    id = $( "#txtId" ),
    nombre = $( "#txtNombre" ),
    contacto = $( "#txtContacto" ),
    domicilio = $( "#txtDomicilio" ),
    telefono = $( "#txtTelefono" ),
    correoElectronico = $( "#txtCorreoElectronico" ),
    allFields = $( [] ).add( nombre ).add( contacto ).add( domicilio ).add( telefono ).add( correoElectronico ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkLength( nombre, "Asociación", 3, 255 );
    valid = valid && checkLength( contacto, "Contacto", 3, 255 );
    valid = valid && checkLength( domicilio, "Domicilio", 0, 255 );
    valid = valid && checkLength( telefono, "telefono", 0, 80 );
    valid = valid && checkLength( correoElectronico, "CorreoElectronico", 0, 120 );
    
    if( correoElectronico.val().length > 0 ){
        valid = valid && checkRegexp( correoElectronico, correoElectronicoRegex, "ej. mgaytan@gahm.com.mx" );
    }

    if ( valid ) {
        var asociacion = {
            Id: id.val(),
            Nombre: nombre.val(),
            Contacto: contacto.val(),
            Domicilio: domicilio.val(),
            Telefono: telefono.val(),
            CorreoElectronico: correoElectronico.val()
        };
        var accion = "a";
        if( id.val() != "" ){
            accion = "u";
        }
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/asociaciones.php",
            data: { a: accion,
                    objeto: JSON.stringify( asociacion ) },
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
        url:"../controller/asociaciones.php",
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