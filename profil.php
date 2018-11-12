<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');
?>

<a href="profil_edit.php">editer profil</a>

<?php 
  if(!empty($_SESSION['taille']) && !empty($_SESSION['poids'])){
    $taille = $_SESSION['taille'];
    $poids = $_SESSION['poids'];
    $imc = $tailles*$taille;
    $imc = $poids/$imc;

    if ($imc<=20){
      $resultimc = 'insuffisance';
    }
    else if ($imc>20 && $imc<=25){
      $resultimc = 'bon';
    }
    else if ($imc>=25 && $imc<=27){
      $resultimc = 'exces';
    }
    else{
      $resultimc = 'risque';
    }
    
  }
  ?>

<?php
include 'inc/footer.php'; ?>
