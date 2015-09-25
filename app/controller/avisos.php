<?php
// validar sesion
require_once 'validarSesion.php';
// setup the autoloading
require_once '../../vendor/autoload.php';
// setup Propel
require_once '../../generated-conf/config.php';
// metodos globales
require_once 'global.php';

if( $_GET["a"] == null ){
    throw new Exception("No esta definido el parametro 'a'");
    return;
}

switch ( $_GET["a"] ){
    case "qu":
        $integrantes = IntegranteQuery::create()->findByFkUsuario( $_SESSION["usuario-id"] );
        $idsIntegrantes = obtenerIDs( $integrantes );
    
        $integrantesasociaciones = IntegranteAsociacionQuery::create()->filterByFkIntegrante( $idsIntegrantes )
                     ->find();
        $metodo = "getFkAsociacion";
        $idsAsociaciones = obtenerElementosMetodo( $integrantesasociaciones, $metodo );
    
        $items = AvisoQuery::create()->filterByFkAsociacion( $idsAsociaciones )
                     ->find();
    
        foreach ($items as $item) {
            $item->getAsociacion();
        }
        echo $items->toJSON();
    break;
    case "q":
        // validar sesion
        require_once 'validarRootAdmin.php';
        $items = AvisoQuery::create()->find();
        foreach ($items as $item) {
            $item->getAsociacion();
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

        $item = AvisoQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
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
    
        $item = new Aviso();
        $item->importFrom("JSON", $_GET["objeto"]);
        if( !( $item == null ) ){
            $itemAnterior = AvisoQuery::create()->findOneById( $item->getId() );
            $item->setFechaAlta( $itemAnterior->getFechaAlta() );
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
    
        $item = AvisoQuery::create()->findOneById($_GET["id"]);
        if( !( $item == null ) ){
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
        
        $item = new Aviso();
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