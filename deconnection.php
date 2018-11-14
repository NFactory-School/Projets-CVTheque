<?php
session_start();
$_SESSION = array();
session_destroy();
// setcookie('userma','',time()+3600*24,'/',false ,true);
// setcookie('usermd','',time()+3600*24,'/',false ,true);
$user=array();
header('Location:index.php') ?>
