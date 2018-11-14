<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';

isAdmin();

if (isLogged()==false){
 header('Location:403.php');
}

$id = $_GET['id'];
b_rm_vaccin($id);

header('Location:b_vaccins_back.php');
