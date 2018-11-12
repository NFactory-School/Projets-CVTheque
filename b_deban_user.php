<?php
include ('inc/pdo.php');
include ('inc/fonction.php');


$id = $_GET['id'];
$sql = "UPDATE vax_profils
        SET status = 'user'
        WHERE id = $id";
$query = $pdo -> prepare($sql);
$query -> execute();

header('Location:b_user_back.php');
