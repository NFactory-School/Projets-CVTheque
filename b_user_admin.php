<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

$id = $_GET['id'];
$sql = "UPDATE vax_profils
        SET status = 'admin'
        WHERE id = $id";
$query = $pdo -> prepare($sql);
$query -> execute();



header('Location:b_user_back.php');
