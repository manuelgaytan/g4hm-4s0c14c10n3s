<?php
session_start();
// remove all session variables
session_unset(); 
// destroy the session 
session_destroy();

$newURL = "http://localhost/asociaciones/index.html";
header('Location: '.$newURL);
die();
?>