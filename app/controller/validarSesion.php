<?php
session_start();

if( !isset($_SESSION['session-id']) ||
    ( $_SESSION["session-id"] != session_id() ) ){
    $newURL = "http://localhost/asociaciones/app/view/sesionNoValida.html";
    header('Location: '.$newURL);
    return;
}
?>