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
    case "q":        
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $item = ProyectoQuery::create()->findByFkAsociacion($_GET["id"]);
        if( !( $item == null ) ){
            echo $item->toJSON();
        }else{
            echo null;
        }
    break;
    case "qi":        
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $items = IntegranteProyectoQuery::create()->findByFkProyecto($_GET["id"]);
        if( !( $items == null ) ){
            foreach ($items as $item) {
                $item->getIntegrante()->getUsuario();
            }
            echo $items->toJSON();
        }else{
            echo null;
        }
    break;
    case "qp":        
        if( $_GET["id"] == null ){
            throw new Exception("No esta definido el parametro 'id'");
            return;
        }
    
        $items = IntegranteProyectoQuery::create()->findByFkIntegrante($_GET["id"]);
        if( !( $items == null ) ){
            foreach ($items as $item) {
                $item->getProyecto();
            }
            echo $items->toJSON();
        }else{
            echo null;
        }
    break;
    case "qip":        
        if( $_GET["idAsociacion"] == null ){
            throw new Exception("No esta definido el parametro 'idAsociacion'");
            return;
        }
        if( $_GET["idIntegrante"] == null ){
            throw new Exception("No esta definido el parametro 'idIntegrante'");
            return;
        }
        $proyectos = ProyectoQuery::create()->findByFkAsociacion($_GET["idAsociacion"]);                   
        $idsProyectos = obtenerIDs( $proyectos );
        $items = IntegranteProyectoQuery::create()
                    ->filterByFkProyecto( $idsProyectos )
                    ->filterByFkIntegrante($_GET["idIntegrante"])
                    ->find();
        if( !( $items == null ) ){
            foreach ($items as $item) {
                $item->getProyecto();
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
    
        $idProyecto = $_GET["id"];
        $strItems = $_GET["objeto"];
        $items = generaArreglo( $strItems );
        $con = $serviceContainer->getConnection();    
        $con->beginTransaction();
        $idsIntegrantesGuardados = array();
        try {
            IntegranteProyectoQuery::create()->findByFkProyecto( $idProyecto )->delete();
            if( $items != null && count( $items ) > 0 ){
                foreach( $items as $itemJSON ){
                    $item = new IntegranteProyecto();
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