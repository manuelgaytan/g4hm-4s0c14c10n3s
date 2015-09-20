// variable para mostrar el detalle.
var objDetalle = undefined;

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
    correoElectronicoRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // crea la tabla
    jQuery("#tabla").jqGrid({
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
        pager: jQuery('#piePaginaTabla'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Integrantes",
        jsonReader: { 
            root: "Integrantes"
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
    
    ocultarComponentes();
    
    ajusteTamanoCatalogo();
});   

function agregar(){
    $.get("integrante.html?a=add", function(data){
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
        url:"../controller/integrantes.php",
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
    $.get("integrante.html?a=edit", function(data){       
        prepararDivItem( data, "Editar" );
        colocarValores( objeto );
    });
}

function colocarValores( objeto ){
    $( "#txtId" ).val( objeto.Id );
    $( "#txtNombre" ).val( objeto.Nombre );
    $( "#txtApellidoPaterno" ).val( objeto.ApellidoPaterno );
    $( "#txtApellidoMaterno" ).val( objeto.ApellidoMaterno );
    $( "#txtFechaNacimiento" ).val( objeto.FechaNacimiento );
    $( "#txtRfc" ).val( objeto.Rfc );
    $( "#txtCurp" ).val( objeto.Curp );
    $( "#txtDomicilio" ).val( objeto.Domicilio );
    $( "#txtEstadoCivil" ).val( objeto.EstadoCivil );
    $( "#txtCorreoElectronico" ).val( objeto.CorreoElectronico );
    $( "#txtOcupacion" ).val( objeto.Ocupacion );
    $( "#txtQuienRecomienda" ).val( objeto.QuienRecomienda );
    $( "#txtObservaciones" ).val( objeto.Observaciones );
    colocarAccesoWeb();
}

function colocarAccesoWeb(){
    if( objDetalle.FkUsuario != undefined ){
        $( "#chkAccesoWeb" ).prop( "checked", true );
        $( "#chkAccesoWeb" ).trigger("change");
        $( "#txtIdUsuario" ).val( objDetalle.Usuario.Id );
        $( "#txtUsuario" ).val( objDetalle.Usuario.Usuario );
        $( "#txtContrasena" ).val( objDetalle.Usuario.Contrasena );
        habilitarUsuario( false );
    }
}

function habilitarUsuario( valor ){
    if( valor ){
        $( "#txtUsuario" ).prop( "disabled", false);
    }else{
        $( "#txtUsuario" ).prop( "disabled", true );
    }
}

function colocarComponentesFechas(){
    $( "#txtFechaNacimiento" ).datepicker({ changeYear: true, yearRange: "1900:2024", dateFormat: "yy-mm-dd" });
}

function aceptar(){
    var valid = true;
    // colocar cajas de texto en variables
    id = $( "#txtId" ),
    nombre = $( "#txtNombre" ),
    apellidoPaterno = $( "#txtApellidoPaterno" ),
    apellidoMaterno = $( "#txtApellidoMaterno" ),
    fechaNacimiento = $( "#txtFechaNacimiento" ),
    rfc = $( "#txtRfc" ),
    curp = $( "#txtCurp" ),
    domicilio = $( "#txtDomicilio" ),
    estadoCivil = $( "#txtEstadoCivil" ),
    ocupacion = $( "#txtOcupacion" ),
    correoElectronico = $( "#txtCorreoElectronico" ),
    quienRecomienda = $( "#txtQuienRecomienda" ),
    observaciones = $( "#txtObservaciones" ),
    idUsuario = $( "#txtIdUsuario" ),
    usuario = $( "#txtUsuario" ),
    contrasena = $( "#txtContrasena" ),
    allFields = $( [] ).add( nombre ).add( apellidoPaterno ).add( apellidoMaterno ).add( fechaNacimiento ).add( rfc ).add( curp ).add( domicilio ).add( estadoCivil ).add( ocupacion ).add( quienRecomienda ).add( observaciones ).add( idUsuario ).add( usuario ).add( contrasena ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkLength( nombre, "Nombre", 3, 120 );
    valid = valid && checkLength( apellidoPaterno, "Apellido Paterno", 0, 120 );
    valid = valid && checkLength( apellidoMaterno, "Apellido Materno", 0, 120 );
    valid = valid && checkLength( fechaNacimiento, "Fecha Nacimiento", 0, 12 );//TODO: Revisar
    valid = valid && checkLength( rfc, "R.F.C.", 0, 13 );
    valid = valid && checkLength( curp, "C.U.R.P.", 0, 18 );
    valid = valid && checkLength( domicilio, "Domicilio", 0, 255 );
    valid = valid && checkLength( estadoCivil, "Estado Civil", 0, 50 );
    valid = valid && checkLength( ocupacion, "Ocupación", 0, 255 );
    valid = valid && checkLength( correoElectronico, "Correo Electrónico", 0, 120 );
    valid = valid && checkLength( quienRecomienda, "Quien Recomienda", 0, 255 );
    valid = valid && checkLength( observaciones, "Observaciones", 0, 255 );
    
    if( correoElectronico.val().length > 0 ){
        valid = valid && checkRegexp( correoElectronico, correoElectronicoRegex, "ej. mgaytan@gahm.com.mx" );
    }
    
    if( accesoWebSeleccionado() ){
        valid = valid && checkLength( usuario, "Usuario", 3, 20 );
        valid = valid && checkLength( contrasena, "Contraseña", 3, 20 );
    }

    if ( valid ) {
        if( !accesoWebSeleccionado() ){
            var item = {
                Id: id.val(),
                Nombre: nombre.val(),
                ApellidoPaterno: apellidoPaterno.val(),
                ApellidoMaterno: apellidoMaterno.val(),
                FechaNacimiento: fechaNacimiento.val(),
                Rfc: rfc.val(),
                Curp: curp.val(),
                Domicilio: domicilio.val(),
                EstadoCivil: estadoCivil.val(),
                Ocupacion: ocupacion.val(),
                CorreoElectronico: correoElectronico.val(),
                QuienRecomienda: quienRecomienda.val(),
                Observaciones: observaciones.val()
            };
        }else{
            var item = {
                Id: id.val(),
                Nombre: nombre.val(),
                ApellidoPaterno: apellidoPaterno.val(),
                ApellidoMaterno: apellidoMaterno.val(),
                FechaNacimiento: fechaNacimiento.val(),
                Rfc: rfc.val(),
                Curp: curp.val(),
                Domicilio: domicilio.val(),
                EstadoCivil: estadoCivil.val(),
                Ocupacion: ocupacion.val(),
                CorreoElectronico: correoElectronico.val(),
                QuienRecomienda: quienRecomienda.val(),
                Observaciones: observaciones.val(),
                Usuario: {
                    Id: idUsuario.val(),
                    Usuario: usuario.val(),
                    Contrasena: contrasena.val()
                }
            };
        }
        var accion = "a";
        if( id.val() != "" ){
            accion = "u";
        }
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/integrantes.php",
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
        url:"../controller/integrantes.php",
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

function ocultarComponentes(){
    $("#divItemAccesoWeb").hide();
}

function seleccionAccesoWeb(){
    if( accesoWebSeleccionado() ){
        $("#divItemAccesoWeb").show();
    }else{
        $("#divItemAccesoWeb").hide();
    }
}

function accesoWebSeleccionado(){
    return $("#chkAccesoWeb").is(':checked');
}