$(document).ready(function(){
    ocultarBanner();
    
    $('.simpleBanner').simplebanner();
    
    cargarAvisos();
});

function cargarAvisos(){
    // ir a la BD a traves del ID
    $.ajax({
        url:"../controller/avisos.php",
        data: { a: "qu"},
        success:function( resultado ){
            if( validaExcepcion( resultado ) ){
                mostrarMensajeExcepcion( resultado );    
            }
            var resultadoObject = JSON.parse( resultado );
            // crear avisos
            crearAvisos( resultadoObject.Avisos );
            var numeroAvisos = resultadoObject.Avisos.length;
            manejoElementosVisuales( numeroAvisos );
        }
    });
}

function manejoElementosVisuales( numeroAvisos ){
    if( numeroAvisos > 0 ){
        mostrarBanner();
    }
    manejoFlechasNavegacion( numeroAvisos );
}

function manejoFlechasNavegacion( numeroAvisos ){
    if( numeroAvisos == 1 ){
        ocultarFlechasNavegacion();
    }else{
        mostrarFlechasNavegacion();
    }
}

function mostrarFlechasNavegacion(){
    $("#flechaPrevio").show();
    $("#flechaSiguiente").show();
}

function ocultarFlechasNavegacion(){
    $("#flechaPrevio").hide();
    $("#flechaSiguiente").hide();
}

function mostrarBanner(){
    $('.simpleBanner').show();
}

function ocultarBanner(){
    $('.simpleBanner').hide();
}

function crearAvisos( avisos ){
    for(var i=0; i<avisos.length; i++){
        crearElementoBanner( avisos[i] );
    }    
}

function crearElementoBanner( aviso ){
    var li = document.createElement("li");
    li.appendChild( crearAviso( aviso ) );
    $( "#bannerList" ).append( li );
}

function crearAviso( aviso ){
    var div = document.createElement("div");
    
    var lblAsociacion = document.createElement("label");
    colorEstiloLabel( lblAsociacion, "Libre Baskerville, serif", "30px");
    var nodoAsociacion = document.createTextNode( aviso.Asociacion.Nombre );
    lblAsociacion.appendChild( nodoAsociacion );    
    div.appendChild( lblAsociacion );
    
    var hrAsociacion = document.createElement("hr");
    colorEstiloHR( hrAsociacion, "5px", "#33CCFF", "#3366FF");
    div.appendChild( hrAsociacion );
    
    var lblAviso = document.createElement("label");
    colorEstiloLabel( lblAviso, "Michroma, sans-serif", "35px");
    var nodoAviso = document.createTextNode( aviso.Aviso );
    lblAviso.appendChild( nodoAviso );    
    div.appendChild( lblAviso );
    
    var hrAviso = document.createElement("hr");
    colorEstiloHR( hrAviso, "2px", "#33CC99", "#336699");
    div.appendChild( hrAviso );
    
    var lblAutor = document.createElement("label");
    colorEstiloLabel( lblAutor, "Pacifico, cursive", "26px");
    var nodoAutor = document.createTextNode( aviso.Autor );    
    lblAutor.appendChild( nodoAutor );    
    div.appendChild( lblAutor );
    
    return div;
}

function colorEstiloLabel( etiqueta, fuente, tamano ){
    etiqueta.style.fontFamily = fuente;
    etiqueta.style.fontSize = tamano;
}

function colorEstiloHR( hr, alto, colorBorde, colorFondo ){
    hr.style.height = alto;
    hr.style.borderColor = colorBorde;
    hr.style.backgroundColor = colorFondo;
}