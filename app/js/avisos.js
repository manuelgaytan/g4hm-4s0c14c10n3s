// variable para mostrar el detalle.
var objDetalle = undefined;

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
    correoElectronicoRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // crea la tabla
    jQuery("#tabla").jqGrid({
        url:'../controller/avisos.php?a=q',
        datatype: "json",
        colNames:['ID', 'Asociación', 'Aviso', 'Autor', 'Fecha Alta', 'Fecha Vigencia'],
        colModel:[
            {name:'Id',index:'Id', width:55, align:"right", sorttype:"int"},
            {name:'Asociacion.Nombre',index:'Asociacion.Nombre', width:200},
            {name:'Aviso',index:'Aviso', width:300},
            {name:'Autor',index:'Autor', width:200},
            {name:'FechaAlta',index:'FechaAlta', width:100, align:"center"},
            {name:'FechaVigencia',index:'FechaVigencia', width:100, align:"center"}
        ],
        loadonce: true,
        rowNum:10,
        rowList:[10,20,30],
        pager: jQuery('#piePaginaTabla'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Avisos",
        jsonReader: { 
            root: "Avisos"
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
    
    inicializaDialogoItem(325, 400);
    
    ocultarComponentes();
    
    ajusteTamanoCatalogo();
});   

function agregar(){
    $.get("aviso.html?a=add", function(data){
        objDetalle = undefined;
        prepararDivItem( data, "Agregar" );
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
        url:"../controller/avisos.php",
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
    $.get("aviso.html?a=edit", function(data){       
        prepararDivItem( data, "Editar" );
        colocarValores( objeto );
    });
}

function colocarValores( objeto ){
    $( "#txtId" ).val( objeto.Id );
    $( "#txtAviso" ).val( objeto.Aviso );
    $( "#txtAutor" ).val( objeto.Autor );
    $( "#txtFechaVigencia" ).val( objeto.FechaVigencia );
    colocarValorAsociacion();
}

function colocarValorAsociacion(){
    if( objDetalle != undefined && $('#cmbAsociacion option').length > 0 ){
        $( "#cmbAsociacion" ).val( objDetalle.FkAsociacion );
    }
}

function colocarComponentesFechas(){
    $( "#txtFechaVigencia" ).datepicker({ changeYear: true, yearRange: "2014:2034", dateFormat: "yy-mm-dd" });
}

function aceptar(){
    var valid = true;
    // colocar cajas de texto en variables
    id = $( "#txtId" ),
    aviso = $( "#txtAviso" ),
    autor = $( "#txtAutor" ),
    fechaVigencia = $( "#txtFechaVigencia" ),
    asociacion = $( "#cmbAsociacion" ),
    allFields = $( [] ).add( aviso ).add( autor ).add( fechaVigencia ).add( asociacion ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkLength( aviso, "Aviso", 5, 255 );
    valid = valid && checkLength( autor, "Autor", 3, 255 );
    valid = valid && checkLength( fechaVigencia, "Fecha Vigencia", 0, 12 );
    valid = valid && checkSelected( asociacion, "Asociación" );

    if ( valid ) {
        var item = {
            Id: id.val(),
            Aviso: aviso.val(),
            Autor: autor.val(),
            FechaVigencia: fechaVigencia.val(),
            FkAsociacion: asociacion.val()
        };
        var accion = "a";
        if( id.val() != "" ){
            accion = "u";
        }
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/avisos.php",
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
        url:"../controller/avisos.php",
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