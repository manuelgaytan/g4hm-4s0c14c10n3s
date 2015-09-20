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
    case "qu":
        $items = IntegranteQuery::create()->findByFkUsuario($_SESSION["usuario-id"]);
        foreach ($items as $item) {
            $item->getUsuario();
        }
        echo $items->toJSON();
    break;
    case "q":        
        $items = IntegranteQuery::create()->find();
        foreach ($items as $item) {
            $item->getUsuario();
        }
        echo $items->toJSON();
    break;
    case "g":
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }

        $item = IntegranteQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            $item->getUsuario();
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
        $objItem = json_decode( $_GET["objeto"] );// se requirio para saber la informacion de los objetos anidados
        $item = new Integrante();
        $item->importFrom("JSON", $_GET["objeto"]);
        $itemAnterior = IntegranteQuery::create()->findOneById( $item->getId() );            
    
        // actualiza la informacion del Usuario.
        if( $objItem->Usuario != null ){
            $usuario = new Usuario();
            $usuario->importFrom("JSON", json_encode( $objItem->Usuario ) );
            if( !( $usuario == null ) ){// trae usuario
                $usuarioAnterior = null;
                if( !( $usuario->getId() == null) ){// tiene usuario anterior
                    $usuarioAnterior = UsuarioQuery::create()->findOneById( $usuario->getId() );                    
                }
                if( !( $usuarioAnterior == null ) ){// no tenia usuario anterior
                    $usuario->copyInto( $usuarioAnterior, false, false );
                    $usuarioAnterior->save();
                    $item->setUsuario( $usuarioAnterior );
                }else{// se crea un usuario nuevo
                    $usuario->setId( null );// asegurarse que no se tiene Id.
                    $usuario->save();
                    $item->setUsuario( $usuario );
                }
            }
        }else{
            borrarUsuarioActual( $itemAnterior );
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
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $item = IntegranteQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            $item->delete();
        }
    break;
    case "a":
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        $objItem = json_decode( $_GET["objeto"] );  // se requirio para saber la informacion de los objetos anidados
        $item = new Integrante();
        $item->importFrom("JSON", $_GET["objeto"]);
        
        // guardar la informacion del Usuario.
        if( $objItem->Usuario != null ){
            $usuario = new Usuario();
            $usuario->importFrom("JSON", json_encode( $objItem->Usuario ));
            $usuario->setId( null );// asegurarse que no se tiene Id.
            if( !( $usuario == null ) ){
                $usuario->save();
            }
        }
        
        $item->setId( null );// asegurarse que no se tiene Id.
        if( $objItem->Usuario != null ){
            $item->setUsuario( $usuario );
        }
        if( !( $item == null ) ){            
            $item->save();
        }
        echo $item->toJSON();
    break;
}

function borrarUsuarioActual( $itemAnterior ){
    if( $usuario == null ){
        return;
    }
    $idUsuarioABorrar = $itemAnterior->getFkUsuario();
    if( $idUsuarioABorrar != null ){
        $itemAnterior->setFkUsuario( null );
        $itemAnterior->save();
        // borrar el Usuario anterior de la base de datos.
        $usuarioAnterior = UsuarioQuery::create()->findOneById( $idUsuarioABorrar );
        if( $usuarioAnterior != null ){
            $usuarioAnterior->delete();
        }
    }
}
?>