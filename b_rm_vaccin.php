<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

$id = $_GET['id'];
$sql = "UPDATE vax_vaccins
        SET status = 2
        WHERE id = $id";
$query = $pdo -> prepare($sql);
$query -> execute();

header('Location:b_vaccins_back.php');
