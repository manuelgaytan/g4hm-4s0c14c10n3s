// variable para mostrar el detalle.
var objDetalle = undefined;

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
    correoElectronicoRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // crea la tabla
    jQuery("#tabla").jqGrid({
        url:'../controller/usuarios.php?a=q',
        datatype: "json",
        colNames:['ID', 'Usuario', 'Fecha Último Acceso', 'Administrador Asociación'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Usuario',index:'Usuario', width:330},
            {name:'FechaUltimoAcceso',index:'FechaUltimoAcceso', width:350, align:"center"},
            {name:'RootAsociacion',index:'RootAsociacion', width:350, align:"center", edittype:'checkbox', editoptions: { value:"true:false"}, 
  formatter: "checkbox", formatoptions: {disabled : false}}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTabla'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Usuarios",
        jsonReader: { 
            root: "Usuarios"
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
    
    inicializaDialogoItem(325, 290);
    
    ocultarComponentes();
    
    ajusteTamanoCatalogo();
});   

function agregar(){
    $.get("usuario.html?a=add", function(data){
        objDetalle = undefined;
        prepararDivItem( data, "Agregar" );
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
        url:"../controller/usuarios.php",
        data: { a: "g",
                id: id},
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            // colocar el objeto para edicion
            objDetalle = JSON.parse( resultado );
            mostrarEditar( objDetalle );
        }
    });
}

function mostrarEditar( objeto ){
    $.get("usuario.html?a=edit", function(data){       
        prepararDivItem( data, "Editar" );
        colocarValores( objeto );
    });
}

function colocarValores( objeto ){
    $( "#txtId" ).val( objeto.Id );
    $( "#txtUsuario" ).val( objeto.Usuario );
    $( "#txtContrasena" ).val( objeto.Contrasena );
    $( "#chkRootAsociacion" ).prop('checked', objeto.RootAsociacion );
}

function aceptar(){
    var valid = true;
    // colocar cajas de texto en variables
    id = $( "#txtId" ),
    usuario = $( "#txtUsuario" ),
    contrasena = $( "#txtContrasena" ),
    rootAsociacion = $( "#chkRootAsociacion" ),
    allFields = $( [] ).add( usuario ).add( contrasena ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkLength( usuario, "Usuario", 3, 20 );
    valid = valid && checkLength( contrasena, "Contraseña", 3, 20 );

    if ( valid ) {
        var item = {
            Id: id.val(),
            Usuario: usuario.val(),
            Contrasena: contrasena.val(),
            RootAsociacion: rootAsociacion.is(':checked')
        };
        var accion = "a";
        if( id.val() != "" ){
            accion = "u";
        }
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/usuarios.php",
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
        url:"../controller/usuarios.php",
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