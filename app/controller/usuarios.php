<?php
// setup the autoloading
require_once '../../vendor/autoload.php';
// setup Propel
require_once '../../generated-conf/config.php';

if( $_GET["a"] == null ){
    throw new Exception("No esta definido el parametro 'a'");
    return;
}

switch ( $_GET["a"] ){
    case "v":
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        $acceso = 0;
        $item = new Usuario();
        $item->importFrom("JSON", $_GET["objeto"]);
        if( $item == null ){
            return $acceso;
        }
        $usuario = UsuarioQuery::create()->findOneByUsuario($item->getUsuario());
        if( $item->getContrasena() == $usuario->getContrasena() ){
            $acceso = 1;
            crearSesion( $usuario );
            $usuario->setFechaUltimoAcceso( new DateTime() );
            $usuario->save();
        }
        echo $acceso;
    break;
    case "q":
        // validar sesion
        require_once 'validarSesion.php';
    
        $items = UsuarioQuery::create()->find();
        foreach ($items as $item) {
            $item->getUsuario();
        }
        echo $items->toJSON();
    break;
    case "g":
        // validar sesion
        require_once 'validarSesion.php';
    
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }

        $item = UsuarioQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            $item->getUsuario();
            echo $item->toJSON();
        }else{
            echo null;
        }
    break;
    case "u":
        // validar sesion
        require_once 'validarSesion.php';
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
    
        $item = new Usuario();
        $item->importFrom("JSON", $_GET["objeto"]);
        if( !( $item == null ) ){
            $itemAnterior = UsuarioQuery::create()->findOneById( $item->getId() );
            $item->setFechaUltimoAcceso( $itemAnterior->getFechaUltimoAcceso() ); // se conserva la fecha ultimo acceso.
            $item->copyInto( $itemAnterior, false, false );
            $itemAnterior->save();
            echo $itemAnterior->toJSON();
        }else{
            echo null;
        }
    break;
    case "d":
        // validar sesion
        require_once 'validarSesion.php';
    
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $item = UsuarioQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
            $item->delete();
        }
    break;
    case "a":
        // validar sesion
        require_once 'validarSesion.php';
    
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
        $item = new Usuario();
        $item->importFrom("JSON", $_GET["objeto"]);
        //TODO: Validar que no exista el mismo usuario
        $item->setId( null );// asegurarse que no se tiene Id.
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

function crearSesion( $usuario ){
    session_start();
    $_SESSION["usuario"] = $usuario->getUsuario();
    $_SESSION["usuario-id"] = $usuario->getId();
    $_SESSION["root-asociacion"] = $usuario->getRootAsociacion();
    $_SESSION["root"] = ( $usuario->getUsuario() == "root");
    $_SESSION["session-id"] = session_id();
}
?>