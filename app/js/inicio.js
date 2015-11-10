( function( $ ) {
    $( document ).ready(function() {
        $('#cssmenu').prepend('<div id="menu-button">Menu</div>');
        
        $('#cssmenu #menu-button').on('click', function(){
            var menu = $(this).next('ul');
            if (menu.hasClass('open')) {
                menu.removeClass('open');
            }
            else {
                menu.addClass('open');
            }
        });
        $('#cssmenu').on('click', 'li', function (event) {
            if( event.currentTarget.id == ""){
                return;
            }
            abrirPantalla( event.currentTarget.id );            
        });
        
        ajusteTamanoFrame();
        
        clicInicio();
    });
} )( jQuery );

function clicInicio(){
    $( "#inicio" ).trigger( "click" );
}

function ajusteTamanoFrame(){
    $("#iFrmPrincipal").css( "height", altoEspacioPrincipal() );
    $("#iFrmPrincipal").css( "width", anchoEspacioPrincipal() );
}

function abrirPantalla(opcion){
    switch( opcion ){
        case "inicio":
            cargarPantallaPrincipal("view/mostrarAvisos.html");
        break;
        case "asociaciones":
            cargarPantallaPrincipal("view/consultaAsociaciones.html");
        break;
        case "integrantes":
            cargarPantallaPrincipal("view/consultaIntegrantes.html");
        break;
        case "proyectos":
            cargarPantallaPrincipal("view/consultaProyectos.html");
        break;
        case "items":
            cargarPantallaPrincipal("view/consultaItems.html");
        break;
        case "usuarios":
            cargarPantallaPrincipal("view/consultaUsuarios.html");
        break;
        case "avisos":
            cargarPantallaPrincipal("view/consultaAvisos.html");
        break;
        case "integrantesAsociaciones":
            cargarPantallaPrincipal("view/integrantesAsociaciones.html");
        break;
        case "integrantesProyectos":
            cargarPantallaPrincipal("view/integrantesProyectos.html");
        break;
        case "integrantesItems":
            cargarPantallaPrincipal("view/integrantesItems.html");
        break;
        case "seguimientoIntegranteItems":
            cargarPantallaPrincipal("view/seguimientoIntegranteItems.html");
        break;
        case "graficos":
            cargarPantallaPrincipal("view/graficos.html");
        break;
    }
}

function cargarPantallaPrincipal( url ){
    $("#iFrmPrincipal").attr("src", url);
}