<?php
include ('inc/pdo.php');
include ('inc/request.php');
include ('inc/fonction.php');

isAdmin();

if (isLogged()==false){
 header('Location:403.php');
}

$id = $_GET['id'];
set_statut($id, '3', 'vax_profils');

header('Location:b_user_back.php');
