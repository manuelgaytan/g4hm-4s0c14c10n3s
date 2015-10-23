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
    case "qg":
        if( $_GET["idItem"] == null ){
            throw new Exception("No esta definido el parametro 'idItem'");
            return;
        }
        
        $items = AportacionQuery::create()
                    ->filterByFkItem($_GET["idItem"])
                    ->orderByFecha()
                    ->find();
        if( !( $items == null ) ){
            $aportaciones = array();           
            $mesAnterior = null;
            $mesActual = null;
            $itemAportacion = null;
            foreach ($items as $item) {                
                $mesActual = extraeUltimoDiaMes($item->getFecha());
                if( $mesAnterior == null || !($mesActual == $mesAnterior) ){                    
                    if( !($mesAnterior == null) ){
                        $aportaciones[] = $itemAportacion->toJSON();  
                    }
                    $itemAportacion = new Aportacion();
                    $itemAportacion->setMonto( $item->getMonto() );
                    $itemAportacion->setFecha( $mesActual );                                                                              
                }else{                    
                    $itemAportacion->setMonto( $itemAportacion->getMonto() + $item->getMonto() );
                }
                $mesAnterior = $mesActual;
            }
            if( !($mesAnterior == null) ){
                $aportaciones[] = $itemAportacion->toJSON();  
            }
            echo json_encode( $aportaciones );
        }else{
            echo null;
        }
    break;
    case "qgia":
        if( $_GET["idItem"] == null ){
            throw new Exception("No esta definido el parametro 'idItem'");
            return;
        }        
        // obtiene el item aportacion
        $item = ItemQuery::create()
                    ->findOneById($_GET["idItem"]);
        $itemAportacionGeneral = $item->getItemAportacion();    
    /*
        // obtiene el numero de integrantes que ha aportado
        $aportacionesAgrupadasPorIntegrante = AportacionQuery::create()
                    ->filterByFkItem($_GET["idItem"])
                    ->groupByFkIntegrante()
                    ->find();
        if( $aportacionesAgrupadasPorIntegrante != null ){
            $numIntegrantes = 0;
            foreach ($aportacionesAgrupadasPorIntegrante as $aportacion) {
                $numIntegrantes++;
            }
            //echo "Num. Integrantes: " . $numIntegrantes . "<br>";
    */
            $numIntegrantes = 40;
    /*
        }
    */
        $itemAportacionGeneral->setMonto( $itemAportacionGeneral->getMonto() * $numIntegrantes );
        echo $itemAportacionGeneral->toJSON();        
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

function extraeUltimoDiaMes( $fecha ){    
    return date("Y-m-t", strtotime($fecha));
}
?>