<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

$id = $_GET['id'];
b_user_admin($id);

header('Location:b_user_back.php');
