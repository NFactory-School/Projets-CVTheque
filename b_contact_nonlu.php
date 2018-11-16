<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

$id = $_GET['id'];
contact_statut($id, '2');

header('Location:b_back.php');
