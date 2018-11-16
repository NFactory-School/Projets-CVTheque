<?php
include ('inc/pdo.php');
include ('inc/request.php');
include ('inc/fonction.php');

isAdmin();

if (isLogged()==false){
 header('Location:403.php');
}

$id = $_GET['id'];
set_statut($id, '1', 'vax_vaccins');

header('Location:b_vaccins_back.php');
