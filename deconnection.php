<?php
session_start();
$_SESSION = array();
session_destroy();
setcookie('user_id','',time()+3600*24,'/',false,true);
setcookie('user_ip','',time()+3600*24,'/',false,true);

$user=array();
header('Location:index.php') ?>
