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
    case "qa":        
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
        
        $items = IntegranteAsociacionQuery::create()->findByFkIntegrante($_GET["id"]);
        if( !( $items == null ) ){
            foreach ($items as $item) {
                $item->getAsociacion();
            }
            echo $items->toJSON();
        }else{
            echo null;
        }
    break;
    case "q":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["idIntegrante"] == null ){
            throw new Exception("No esta definido el parametro 'idIntegrante'");
            return;
        }
        if( $_GET["idItem"] == null ){
            throw new Exception("No esta definido el parametro 'idItem'");
            return;
        }
        
        $items = AportacionQuery::create()
                    ->filterByFkItem($_GET["idItem"])
                    ->filterByFkIntegrante($_GET["idIntegrante"])
                    ->find();
        if( !( $items == null ) ){
            foreach ($items as $item) {
                $item->getIntegrante();
                $item->getItem();
                $item->getItem()->getItemAportacion();
            }
            echo $items->toJSON();
        }else{
            echo $items;
        }
    break;
    case "u":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }    
    
        $idIntegrante = $_GET["id"];
        $strItems = $_GET["objeto"];
        $items = generaArregloSimple( $strItems );
        $con = $serviceContainer->getConnection();    
        $con->beginTransaction();
        try {
            $aportacionesGuardadas = AportacionQuery::create()->findByFkIntegrante( $idIntegrante );
            if( $aportacionesGuardadas != null && count( $aportacionesGuardadas ) > 0 ){
                foreach( $aportacionesGuardadas as $aportacionGuardada ){
                    if( !existeIdentificador( $aportacionGuardada->getId() , $items) ){
                        $aportacionGuardada->delete();
                    }
                }
            }
            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    break;
    case "a":
        // validar sesion
        require_once 'validarRootAdmin.php';
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }
    
        $item = new Aportacion();
        $item->importFrom("JSON", $_GET["objeto"]);
        $item->setId( null );// asegurarse que no se tiene Id.
        if( !( $item == null ) ){            
            $item->save();
        }
        echo $item->toJSON();
    break;
}
?>