<?php
// validar sesion
require_once 'validarSesion.php';
// validar sesion
require_once 'validarRootAdmin.php';
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
        $items = ProyectoQuery::create()->find();
        foreach ($items as $item) {
            $item->getAsociacion();
        }
        echo $items->toJSON();
    break;
    case "g":
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }

        $item = ProyectoQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            echo $item->toJSON();
        }else{
            echo null;
        }
    break;
    case "u":
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
    
        $item = new Proyecto();
        $item->importFrom("JSON", $_GET["objeto"]);
        if( !( $item == null ) ){
            $itemAnterior = ProyectoQuery::create()->findOneById( $item->getId() );  
            $item->setFechaAlta( $itemAnterior->getFechaAlta() );
            $item->copyInto( $itemAnterior, false, false );
            $itemAnterior->save();
            echo $itemAnterior->toJSON();
        }else{
            echo null;
        }
    break;
    case "d":
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $item = ProyectoQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            $item->delete();
        }
    break;
    case "a":
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        
        $item = new Proyecto();
        $item->importFrom("JSON", $_GET["objeto"]);
        $item->setId( null );// asegurarse que no se tiene Id.
        $item->setFechaAlta( new DateTime() );// asegurarse que no se tiene Id.
        if( !( $item == null ) ){            
            $item->save();
        }
        echo $item->toJSON();
    break;
}
?>