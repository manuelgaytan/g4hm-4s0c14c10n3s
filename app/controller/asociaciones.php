<?php
// validar sesion
require_once 'validarSesion.php';
// setup the autoloading
require_once '../../vendor/autoload.php';
// setup Propel
require_once '../../generated-conf/config.php';

if( $_GET["a"] == null ){
    throw new Exception("No esta definido el parametro 'a'");
    return;
}

switch ( $_GET["a"] ){
    case "q":
        $asociacion = AsociacionQuery::create()->find();
        echo $asociacion->toJSON();
    break;
    case "g":
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
        
        $asociacion = AsociacionQuery::create()->findOneById($_GET["id"]);
        if( !( $asociacion == null ) ){
            echo $asociacion->toJSON();
        }else{
            echo null;
        }
    break;
    case "u":
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        
        $asociacion = new Asociacion();
        $asociacion->importFrom("JSON", $_GET["objeto"]);
        if( !( $asociacion == null ) ){
            $asociacionAnterior = AsociacionQuery::create()->findOneById( $asociacion->getId() );
            $asociacion->copyInto( $asociacionAnterior, false, false );
            $asociacionAnterior->save();
            echo $asociacionAnterior->toJSON();
        }else{
            echo null;
        }
    break;
    case "d":
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
        
        $asociacion = AsociacionQuery::create()->findOneById($_GET["id"]);
        if( !( $asociacion == null ) ){
            $asociacion->delete();
        }
    break;
    case "a":
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        
        $asociacion = new Asociacion();
        $asociacion->importFrom("JSON", $_GET["objeto"]);
        $asociacion->setId( null );// asegurarse que no se tiene Id.
        if( !( $asociacion == null ) ){            
            $asociacion->save();
        }
        echo $asociacion->toJSON();
    break;
}
?>