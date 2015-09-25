<?php
if( $_SESSION["root-asociacion"] == false ){
    $newURL = "http://localhost/asociaciones/app/view/sesionNoValida.html";
    header('Location: '.$newURL);
    return;
}
?>