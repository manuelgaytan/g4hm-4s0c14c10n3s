<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <script type="text/javascript" src="vendor/jqGrid/js/jquery-1.11.0.min.js"></script>        
        <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css">
        <script src="vendor/jquery-ui/jquery-ui.js"></script>
        
        <script type="text/javascript" src="app/js/global.js"></script>
        <script type="text/javascript" src="app/js/index.js"></script>
        
        <link rel="stylesheet" href="app/css/asociaciones.css">
        <link rel="stylesheet" href="app/css/index.css">        
    </head>
    <body>
        <?php   
            if( !isset( $_SERVER['HTTPS'] ) ){
                $url = "https://$_SERVER[HTTP_HOST]/asociaciones/index.php";
                header('Location: '.$url);
            }
        ?>
        <input id="btnIniciarSesion"
               type="button" value="Iniciar Sesión"
               class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"></input>
        <div id="divIniciarSesion" title="Autenticación"></div>
        <div id="divMensaje">
            <p class="txtMensaje"></p>
        </div>
    </body>
</html>