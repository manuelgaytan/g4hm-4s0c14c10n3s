// variable para mostrar el detalle.
var objDetalle = undefined;

$( document ).ready( function(){
    // valida que haya una sesion valida
    validarSesion();
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
    correoElectronicoRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    
    // crea la tabla
    jQuery("#tabla").jqGrid({
        url:'../controller/items.php?a=q',
        datatype: "json",
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
        pager: jQuery('#piePaginaTabla'),
        sortname: 'id',
        viewrecords: true,
        sortorder: "desc",
        caption:"Consulta Ítems",
        jsonReader: { 
            root: "Items"
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

    inicializaDialogoItem(undefined, 450);
    
    ajusteTamanoCatalogo();
});   

function agregar(){
    $.get("Item.html?a=add", function(data){
        objDetalle = undefined;
        prepararDivItem(data, "Agregar");
    });
}

function seleccionTipoItem(){
    var idTipoItem = $("#cmbTipoItem").val();
    ocultarComponentes();
    if( idTipoItem == 1 ){
        $("#divItemAportacion").show();
    }
    if( idTipoItem == 2 ){
        mostrarMensajeAdvertencia("Lo sentimos, por el momento esta opción no está implementada.");
        //$("#divItemRequisitos").show();
    }
}

function ocultarComponentes(){
    $("#divItemAportacion").hide();
    $("#divItemRequisitos").hide();
}

function cargarCatalogos( funcionRetorno ){
    var totalCatalogos = 2;
    var catalogosRetornaron = 0;
    cargarCatalogoProyectos( function validaRetornos(){
                                    catalogosRetornaron++;
                                    if( totalCatalogos == catalogosRetornaron &&
                                        funcionRetorno != undefined ){
                                        funcionRetorno();
                                    }
                                } );
    cargarCatalogoTiposItem( function validaRetornos(){
                                    catalogosRetornaron++;
                                    if( totalCatalogos == catalogosRetornaron &&
                                        funcionRetorno != undefined ){
                                        funcionRetorno();
                                    }
                                } );
}

function cargarCatalogoProyectos( funcionRetorno ){
    $.ajax({
        url:"../controller/proyectos.php",
        data: { a: "q" },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            colocarComponenteProyectos( resultado );
            colocarValorProyecto();
            if( funcionRetorno != undefined ){
                funcionRetorno();
            }
        }
    });
}

function cargarCatalogoTiposItem( funcionRetorno ){
    $.ajax({
        url:"../controller/tiposItem.php",
        data: { a: "q" },
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            colocarComponenteTiposItem( resultado );
            colocarValorTipoItem();
            if( funcionRetorno != undefined ){
                funcionRetorno();
            }
        }
    });
}

function colocarComponenteProyectos( resultado ){
    var raiz = JSON.parse( resultado )
    var item = null;
    for(var i = 0; i < raiz["Proyectos"].length; i++ ){
        item = raiz["Proyectos"][i];
        /*
        $("#cmbAsociacion").append($("<option></option>")
                             .attr("value",item["Id"])
                             .text(item["Nombre"]));
        */
        $("#cmbProyecto").append($("<option/>",{
                                    value: item["Id"],
                                    text: item["Nombre"] 
                                }) );
    }
}

function colocarComponenteTiposItem( resultado ){
    var raiz = JSON.parse( resultado )
    var item = null;
    for(var i = 0; i < raiz["TipoItems"].length; i++ ){
        item = raiz["TipoItems"][i];
        $("#cmbTipoItem").append($("<option/>",{
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
        url:"../controller/items.php",
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
    $.get("Item.html?a=edit", function(data){
        prepararDivItem( data, "Editar");
        colocarValores( objeto );
    });
}

function colocarValores( objeto ){
    $( "#txtId" ).val( objeto.Id );
    $( "#txtNombre" ).val( objeto.Nombre );
    $( "#txtDescripcion" ).val( objeto.Descripcion );
    $( "#txtResponsable" ).val( objeto.Responsable );
    colocarValorProyecto();
    colocarValorTipoItem();
}

function colocarValorItemAportacion( objeto ){
    if( objeto === undefined ){
        objeto = objDetalle;
    }
    if( objeto.FkItemAportacion != undefined ){
        $( "#txtIdItemAportacion" ).val( objeto.ItemAportacion.Id );
        $( "#txtMonto" ).val( objeto.ItemAportacion.Monto );
        $( "#txtFechaInicio" ).val( objeto.ItemAportacion.FechaInicio );
        $( "#txtFechaFin" ).val( objeto.ItemAportacion.FechaFin );
    }
}

function colocarValorItemRequisitos( objeto ){
    if( objeto === undefined ){
        objeto = objDetalle;
    }
    if( objeto.FkItemRequisitos != undefined ){
    }
}

function colocarValorProyecto(){
    // $('#cmbAsociacion')[0].childElementCount > 0
    // $('#cmbAsociacion').val()
    if( objDetalle != undefined && $('#cmbProyecto option').length > 0 ){
        $( "#cmbProyecto" ).val( objDetalle.FkProyecto );
    }
}

function colocarValorTipoItem(){
    if( objDetalle != undefined && $('#cmbTipoItem option').length > 1 ){
        if( objDetalle.FkItemAportacion != undefined ){
            $( "#cmbTipoItem" ).val( CONSTANTES.get("ID_APORTACION") );
            $( "#cmbTipoItem" ).trigger('change');
            colocarValorItemAportacion();
        }
        if( objDetalle.FkItemRequisitos != undefined ){
            $( "#cmbTipoItem" ).val( CONSTANTES.get("ID_REQUISITOS") );
            $( "#cmbTipoItem" ).trigger('change');
            colocarValorItemRequisitos();
        }
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
    proyecto = $( "#cmbProyecto" ),
    nombre = $( "#txtNombre" ),
    descripcion = $( "#txtDescripcion" ),
    responsable = $( "#txtResponsable" ),
    tipoItem = $( "#cmbTipoItem" ),
    monto = $( "#txtMonto" ),
    fechaInicio = $( "#txtFechaInicio" ),
    fechaFin = $( "#txtFechaFin" ),
    requisitos = $( "#lstRequisitos" ),
    allFields = $( [] ).add( nombre ).add( descripcion ).add( responsable ).add( tipoItem ).add( monto ).add( fechaInicio ).add( fechaFin ).add( requisitos ),
    tips = $( ".validateTips" );
    idItemAportacion = $( "#txtIdItemAportacion" );
    idItemRequisitos = $( "#txtIdItemRequisitos" );
        
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkSelected( proyecto, "Proyecto", true );
    valid = valid && checkLength( nombre, "Nombre", 3, 255 );
    valid = valid && checkLength( descripcion, "Descripción", 0, 255 );
    valid = valid && checkLength( responsable, "Responsable", 3, 255 );
    valid = valid && checkSelected( tipoItem, "Tipo", true );
    if( tipoItem.val() == CONSTANTES.get("ID_APORTACION") ){
        valid = valid && checkLength( monto, "Monto",  0, 12 );    
    }    
    valid = valid && checkLength( fechaInicio, "Fecha Inicio", 0, 12 );
    valid = valid && checkLength( fechaFin, "Fecha Fin", 0, 12 );
    if( tipoItem.val() == CONSTANTES.get("ID_REQUISITOS") ){
        //valid = valid && checkLength( requisitos, "Requisitos", 0, 255 );//TODO:
        mostrarMensajeAdvertencia("Lo sentimos, por el momento esta opción no está implementada.");
        valid = false;
    }
    
    if ( valid ) {
        var item = null;
        if( tipoItem.val() == CONSTANTES.get("ID_APORTACION") ){
            item = {
                Id: id.val(),
                Nombre: nombre.val(),
                Descripcion: descripcion.val(),
                Responsable: responsable.val(),
                ItemAportacion: {
                    Id: idItemAportacion.val(),
                    Monto: monto.val(),
                    FechaInicio: fechaInicio.val(),
                    FechaFin: fechaFin.val()
                    },
                FkProyecto: proyecto.val()
            };
        }
        var accion = "a";
        if( id.val() != "" ){
            accion = "u";
        }
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"../controller/items.php",
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
        url:"../controller/items.php",
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