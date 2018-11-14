<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

echo" Bravo ! Vous avez rempli le formulaire !"; br();?>

<a href="index.php">retour à l'accueil</a>

<?php include ('inc/footer.php');
