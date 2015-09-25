<?php
// validar sesion
require_once 'validarSesion.php';
// validar sesion
require_once 'validarRootAdmin.php';
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
    case "q":        
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
        
        $items = IntegranteAsociacionQuery::create()->findByFkAsociacion($_GET["id"]);
        if( !( $items == null ) ){
            foreach ($items as $item) {
                $item->getIntegrante()->getUsuario();
            }
            echo $items->toJSON();
        }else{
            echo null;
        }
    break;
    case "u":
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
        if( $_GET["objeto"] == null ){
            throw new Exception("No esta definido el parametro 'objeto'");
            return;
        }    
    
        $idAsociacion = $_GET["id"];
        $strItems = $_GET["objeto"];
        $items = generaArreglo( $strItems );
        $con = $serviceContainer->getConnection();    
        $con->beginTransaction();
        $idsIntegrantesGuardados = array();
        try {
            IntegranteAsociacionQuery::create()->findByFkAsociacion( $idAsociacion )->delete();
            if( $items != null && count( $items ) > 0 ){
                foreach( $items as $itemJSON ){
                    $item = new IntegranteAsociacion();
                    $item->importFrom("JSON", $itemJSON);
                    $item->setId( null );// asegurarse que no se tiene Id.
                    if( !existeIdentificador( $item->getFkIntegrante() , $idsIntegrantesGuardados) ){
                        $item->save();
                        $idsIntegrantesGuardados[] = $item->getFkIntegrante();
                    }
                }
            }
            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }
    break;
}
?>