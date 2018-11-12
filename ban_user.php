<?php
include ('inc/pdo.php');
include ('inc/fonction.php');


$id = $_GET['id'];
$sql = "UPDATE vax_profils
        SET status = 'banni'
        WHERE id = $id";
$query = $pdo -> prepare($sql);
$query -> execute();

header('Location:user_back.php');
