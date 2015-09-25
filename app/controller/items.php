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
        // validar sesion
        require_once 'validarRootAdmin.php';
        $items = ItemQuery::create()->find();
        foreach ($items as $item) {
            $item->getProyecto();
            $item->getItemAportacion();
            //$item->getItemRequisitos();   //TODO: Descomentar cuando se implemente.
        }
        echo $items->toJSON();
    break;
    case "qp":        
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }

        $items = ItemQuery::create()->findByFkProyecto($_GET["id"]);
        foreach ($items as $item) {
            $item->getProyecto();
            $item->getItemAportacion();
            //$item->getItemRequisitos();   //TODO: Descomentar cuando se implemente.
        }
        echo $items->toJSON();
    break;
    case "g":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }

        $item = ItemQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            $item->getItemAportacion();
            //$item->getItemRequisitos();   //TODO: Descomentar cuando se implemente.
            echo $item->toJSON();
        }else{
            echo null;
        }
    break;
    case "u":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        $objItem = json_decode( $_GET["objeto"] );// se requirio para saber la informacion de los objetos anidados
    
        $item = new Item();
        $item->importFrom("JSON", $_GET["objeto"]);
        $itemAnterior = ItemQuery::create()->findOneById( $item->getId() );            
    
        // actualiza la informacion del ItemAportacion.
        if( $objItem->ItemAportacion != null ){
            $itemAportacion = new ItemAportacion();
            $itemAportacion->importFrom("JSON", json_encode( $objItem->ItemAportacion ) );            
            if( !( $itemAportacion == null ) ){// trae aportacion
                $itemAportacionAnterior = null;
                if( !( $itemAportacion->getId() == null) ){// tiene item aportacion anterior
                    $itemAportacionAnterior = ItemAportacionQuery::create()->findOneById( $itemAportacion->getId() );                    
                }
                if( !( $itemAportacionAnterior == null ) ){// no tenia item aportacion anterior
                    $itemAportacion->copyInto( $itemAportacionAnterior, false, false );
                    $itemAportacionAnterior->save();
                    $item->setItemAportacion( $itemAportacionAnterior );
                }else{// se crea un item aportacion nuevo
                    $itemAportacion->setId( null );// asegurarse que no se tiene Id.
                    $itemAportacion->save();
                    $item->setItemAportacion( $itemAportacion );
                }
            }
        }else{
            borrarItemAportacionActual( $itemAnterior );
        }
    
        if( !( $item == null ) ){
            $item->copyInto( $itemAnterior, false, false );
            $itemAnterior->save();
            echo $itemAnterior->toJSON();
        }else{
            echo null;
        }
    break;
    case "d":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $item = ItemQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            borrarItemAportacionActual( $item );
            $item->delete();
        }
    break;
    case "a":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        $objItem = json_decode( $_GET["objeto"] );  // se requirio para saber la informacion de los objetos anidados
    
        $item = new Item();
        $item->importFrom("JSON", $_GET["objeto"]);
    
        // guardar la informacion del ItemAportacion.
        if( $objItem->ItemAportacion != null ){
            $itemAportacion = new ItemAportacion();
            $itemAportacion->importFrom("JSON", json_encode( $objItem->ItemAportacion ) );
            $itemAportacion->setId( null );// asegurarse que no se tiene Id.
            if( !( $itemAportacion == null ) ){
                $itemAportacion->save();
            }
        }
        
        // guardar la informacion del Item
        $item->setId( null );// asegurarse que no se tiene Id.
        if( $objItem->ItemAportacion != null ){
            $item->setItemAportacion( $itemAportacion );
        }
        if( !( $item == null ) ){
            $item->save();
        }
        echo $item->toJSON();
    break;
}

function borrarItemAportacionActual( $itemAnterior ){
    if( $itemAnterior == null ){
        return;
    }
    $idItemAportacionABorrar = $itemAnterior->getFkItemAportacion();
    if( $idItemAportacionABorrar != null ){
        $itemAnterior->setFkItemAportacion( null );
        $itemAnterior->save();
        // borrar el ItemAportacion anterior de la base de datos.
        $itemAportacionAnterior = ItemAportacionQuery::create()->findOneById( $idItemAportacionABorrar );
        if( $itemAportacionAnterior != null ){
            $itemAportacionAnterior->delete();
        }
    }
}

?>