<?php
function generaArregloSimple( $strItems ){
    if( $strItems == null || $strItems == "null"){
        return null;
    }
    $strItems = str_replace("[","",$strItems);
    $strItems = str_replace("]","",$strItems);
    $strItems = str_replace(",","coma_token",$strItems);
    if( $strItems == "" ){
        return null;
    }else{
        return explode("coma_token", $strItems);
    }
}

function generaArreglo( $strItems ){
    if( $strItems == null || $strItems == "null"){
        return null;
    }
    $strItems = str_replace("[","",$strItems);
    $strItems = str_replace("]","",$strItems);
    $strItems = str_replace("},{","}coma_token{",$strItems);
    if( $strItems == "" ){
        return null;
    }else{
        return explode("coma_token", $strItems);
    }
}

function existeIdentificador( $identificador, $items){
    foreach( $items as $item ){
        echo "\t\titem: " . $item . " = " . $identificador . " :identificador\n";
        if( $item == $identificador ){
            return true;
        }
    }
    return false;
}

//TODO: validar que funcione
function tieneSesion(){
    session_start();
    return !( !isset($_SESSION['session-id']) ||
        ( $_SESSION["session-id"] != session_id() ) );
}

function obtenerIDs( $items ){
    /*
    if( $metodo == null || $metodo == "null"){
        $metodo = "getId";
    }        
    $arregloIDs = array();
    foreach( $items as $item ){        
        $arregloIDs[] = call_user_func( array($item, $metodo) );
    }
    return $arregloIDs;
    */
    $metodo = "getId";
    return obtenerElementosMetodo( $items, $metodo );
}

function obtenerElementosMetodo( $items, $metodo ){
    if( $metodo == null || $metodo == "null"){
        $metodo = "getId";
    }        
    $arregloIDs = array();
    foreach( $items as $item ){        
        $arregloIDs[] = call_user_func( array($item, $metodo) );
    }
    return $arregloIDs;
}
?>