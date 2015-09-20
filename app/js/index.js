$( document ).ready( function(){
    $( "#btnIniciarSesion" ).click( mostrarIniciarSesion );
    
    inicializaDialogoIniciarSesion();
    
    inicializaDialogoMensaje();
    
    //TODO: Implementar reiniciar contrasena
    //$( "#lnkRecuperarContrasena" ).click( mensajeTemporal );
});

function mensajeTemporal(){
    mostrarMensaje("Lo sentimos, por el momento esta opción no está implementada.")
}
                    
function inicializaDialogoIniciarSesion( ancho, alto ){
    if( typeof(ancho) === 'undefined' ){
        ancho = 300;
    }
    if( typeof(alto) === 'undefined' ){
        alto = 270;
    }
    // configura el dialogo para mostrar el detalle
    dialogoIniciarSesion = $( "#divIniciarSesion" ).dialog({
        autoOpen: false,
        height: alto,
        width: ancho,
        modal: true,
        buttons: {
            "Iniciar Sesión": iniciarSesion,
            "Cancelar": cancelar
        },
        close: function(){
        }
    });
}

function iniciarSesion(){
    var valid = true;
    // colocar cajas de texto en variables
    usuario = $( "#txtUsuario" ),
    contrasena = $( "#txtContrasena" ),
    allFields = $( [] ).add( usuario ).add( contrasena ),
    tips = $( ".validateTips" );
    
    allFields.removeClass( "ui-state-error" );
    
    valid = valid && checkLength( usuario, "Usuario", 3, 20 );
    valid = valid && checkLength( contrasena, "Contraseña", 3, 20 );
    
    if ( valid ) {
        var usuario = {
            Usuario: usuario.val(),
            Contrasena: contrasena.val(),
        };
        var accion = "v";
        // agregar o actualizar el elemento en la base de datos
        $.ajax({
            url:"app/controller/usuarios.php",
            data: { a: accion,
                    objeto: JSON.stringify( usuario ) },
            success:function( resultado ){
                if( validaExcepcion( resultado ) ){
                    mostrarMensajeExcepcion( resultado );    
                }
                dialogoIniciarSesion.dialog( "close" );
                validarResultado( resultado );
            },
        });
    }
    return valid;
}

function validarResultado( resultado ){
    if( resultado == 1 ){
        window.setTimeout(function() {
            window.location.href = 'app/index.php';
            }, 0);
    }else{
        mostrarMensajeError("El Usuario/Contraseña no son válidos.");   
    }
}

function cancelar(){
    dialogoIniciarSesion.dialog( "close" );
}

function mostrarIniciarSesion(){
    $.get("app/view/iniciarSesion.html", function(data){
        $("#divIniciarSesion").html( data );
        dialogoIniciarSesion.dialog( "open" );
        colocarTituloPopUp("Autenticación");
    });
}