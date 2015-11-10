<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Consulta Asociaciones</title>                       
        <script type="text/javascript" src="../vendor/jqGrid/js/jquery-1.11.0.min.js"></script>        

        <script type="text/javascript" src="js/global.js"></script>
        <script type="text/javascript" src="js/inicio.js"></script>
        <!-- adorno navide&ntilde;o
        <script type="text/javascript" src="js/efectoNieve.js"></script>
        -->
        
        <link rel="stylesheet" href="css/asociaciones.css">
        <link rel="stylesheet" href="css/menu.css">
        
        <link href='https://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <header>
            <div id='cssmenu'>
                <?php
                    session_start();
                ?>
                <ul>
                    <li id="inicio"><a href='#'><span>Inicio</span></a></li>
                    <?php
                        if( $_SESSION["root"] == true || $_SESSION["root-asociacion"] == true ){
                            echo "<li class='active has-sub'><a href='#'><span>Catálogos</span></a>";
                            echo "<ul>";                            
                        }
                        if( $_SESSION["root"] == true ){
                            echo "<li id=\"asociaciones\"><a href='#'><span>Asociaciones</span></a></li>";
                        }
                        if( $_SESSION["root-asociacion"] == true ){
                            echo "<li id=\"integrantes\"><a href='#'><span>Integrantes</span></a></li>";
                            echo "<li id=\"proyectos\"><a href='#'><span>Proyectos</span></a></li>";
                            echo "<li id=\"items\"><a href='#'><span>Items</span></a></li>";
                        }
                        if( $_SESSION["root"] == true ){
                            echo "<li id=\"usuarios\"><a href='#'><span>Usuarios</span></a></li>";
                        }
                        if( $_SESSION["root-asociacion"] == true ){
                            echo "<li id=\"avisos\"><a href='#'><span>Avisos</span></a></li>";
                        }
                        if( $_SESSION["root"] == true || $_SESSION["root-asociacion"] == true ){
                            echo "</ul>";
                            echo "</li>";
                        }
                    ?>
                    <?php
                        if( $_SESSION["root"] == false ){
                            echo "<li class='has-sub'><a href='#'><span>Relaciones</span></a>";
                            echo "<ul>";                            
                        }
                        if( $_SESSION["root-asociacion"] == true ){
                            echo "<li id=\"integrantesAsociaciones\"><a href='#'><span>Integrantes-Asociaciones</span></a></li>";
                            echo "<li id=\"integrantesProyectos\"><a href='#'><span>Integrantes-Proyectos</span></a></li>";
                            echo "<li id=\"integrantesItems\"><a href='#'><span>Integrantes-Ítems</span></a></li>";
                            echo "<li id=\"graficos\"><a href='#'><span>Gráficos</span></a></li>";
                        }
                        if( $_SESSION["root"] == false && $_SESSION["root-asociacion"] == false ){
                            echo "<li id=\"seguimientoIntegranteItems\"><a href='#'><span>Seguimiento Integrante-Ítems</span></a></li>";
                        }                                
                        if( $_SESSION["root"] == false ){
                            echo "</ul>";
                            echo "</li>";
                        }
                    ?>                    
                    <li><a href='controller/cerrarSesion.php'><span>Cerrar Sesión</span></a></li>
                </ul>
            </div>
        </header>
        <iframe id="iFrmPrincipal"></iframe>
        <footer style="text-align:center">
            <label style="font-family: 'Playball', cursive;">Derechos Reservados GAHM, 2014.</label>
        </footer>
<?php
/*
// validar sesion
require_once 'controller/validarSesion.php';

// setup the autoloading
require_once '../vendor/autoload.php';

// setup Propel
require_once '../generated-conf/config.php'; 

echo "<a href=\"view/consultaAsociaciones.html\">Asociaciones</a><br>";
echo "<a href=\"view/consultaIntegrantes.html\">Integrantes</a><br>";
echo "<a href=\"view/integrantesAsociaciones.html\">Integrantes-Asociaciones</a><br>";
echo "<a href=\"view/consultaProyectos.html\">Proyectos</a><br>";
echo "<a href=\"view/consultaItems.html\">Items</a><br>";
echo "<a href=\"view/consultaUsuarios.html\">Usuarios</a><br>";
echo "<a href=\"view/integrantesProyectos.html\">Integrantes-Proyectos</a><br>";
echo "<a href=\"view/integrantesItems.html\">Integrantes-Ítems</a><br>";
echo "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -<br>";
echo "<a href=\"view/seguimientoIntegranteItems.html\">Seguimiento Integrante-Ítems</a><br>";

session_start();
echo print_r($_SESSION["usuario"]) . "<br>";
echo $_SESSION["usuario"] . "<br>";
echo $_SESSION["usuario-id"] . "<br>";
echo $_SESSION["session-id"] . "<br>";
echo "<a href=\"controller/cerrarSesion.php\">Cerrar Sesión</a><br>";

//$asociacion = new Asociacion();
//$asociacion->setNombre("Asociación Departamentos Rayón 71");
//$asociacion->setContacto("Lic. Ignacio Morales Huerta");
//echo $asociacion->toJSON();
//echo "guardar: " . $asociacion->save();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('D:\\temp\\log\\propel.log', Logger::INFO));
$serviceContainer->setLogger('defaultLogger', $defaultLogger);

$logger = $serviceContainer->getLogger();
$logger->addInfo('This is a message');

$con = $serviceContainer->getWriteConnection(\Map\AsociacionTableMap::DATABASE_NAME);
$con->useDebug(true);
echo "con: " . var_dump( $con ) . "\n";

echo "<br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - -<br>";
echo "Asociacion<br>";
$asociaciones = AsociacionQuery::create()->find();
foreach( $asociaciones as $asociacion ){
    echo $asociacion->toJSON() . "<br>";
}
echo "<br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - -<br>";
*/
/*
echo "Integrantes<br>";
$integrantes = IntegranteQuery::create()->find();
foreach( $integrantes as $asociacion ){
    echo $asociacion->toJSON() . "<br>";
}
*/
/*
echo "<br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - -<br>";
echo "Ligar Integrantes-Asociacion<br>";
$asociaciones = AsociacionQuery::create()->findById(1);
$asociacion = $asociaciones[0];
echo $asociacion->toJSON() . "<br>";
$integrantes = IntegranteQuery::create()->findById(2);
$integrante = $integrantes[0];
echo $integrante->toJSON() . "<br>";
$integranteAsociacion = new IntegranteAsociacion();
$integranteAsociacion->setAsociacion( $asociacion );
$integranteAsociacion->setIntegrante( $integrante );
echo $integranteAsociacion->toJSON() . "<br>";
$integranteAsociacion->save();
*/
/*
echo "<br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - -<br>";
echo "Integrantes-Asociacion<br>";
$asociaciones = AsociacionQuery::create()->findById(1);
$asociacion = $asociaciones[0];
echo $asociacion->countIntegranteAsociacions() . "<br>";
echo $asociacion->getIntegranteAsociacions()->toJSON() . "<br>";
echo $asociacion->getIntegranteAsociacionsJoinIntegrante()->toJSON() . "<br>";
*/
/*
$integrantesAsociacion = AsociacionQuery::create()->filterByIntegranteAsociacion()->find();
foreach( $integrantesAsociacion as $integranteAsociacion ){
    echo $integranteAsociacion->toJSON() . "<br>";
}
*/
/*
$integranteAsociacion = new IntegranteAsociacion();
$integranteAsociacion->setFkAsociacion(1);
$integranteAsociacion->setFkIntegrante(4);
/*
$asociacion = AsociacionQuery::create()->findOneById(1);
$integranteAsociacion->setAsociacion($asociacion);
$integrante = IntegranteQuery::create()->findOneById(4);
$integranteAsociacion->setIntegrante($integrante);
*/
/*
$integranteAsociacion->save();
*/
/*
$itemAportacion = new ItemAportacion();
$itemAportacion->setMonto(160000);
$itemAportacion->setFechaInicio(new DateTime());
$itemAportacion->save();
$item = new Item();
$item->setNombre("Compra Terreno");
$item->setResponsable("Lic. Ignacio Huerta");
$item->setFkProyecto(1);
$item->setItemAportacion( $itemAportacion );
$item->save();
*/
/*
$tiposItem = TipoItemQuery::create()->find();
foreach( $tiposItem as $tipoItem ){
    echo $tipoItem->toJSON() . "<br>";
}*/
?>
    </body>
</html>