<?php
session_start();
// remove all session variables
session_unset(); 
// destroy the session 
session_destroy();

$newURL = "https://$_SERVER[HTTP_HOST]/asociaciones/index.php";
header('Location: '.$newURL);
die();
?>