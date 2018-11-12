<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}
// verif soumission
$errors = array();
if(!empty($_POST['submit'])){
  // failles xss
  $nom = trim(strip_tags($_POST['nom']));
  $cible = trim(strip_tags($_POST['cible']));
  $labo = trim(strip_tags($_POST['labo']));
  $info = trim(strip_tags($_POST['info']));
    if (!empty($_POST['nom'])) {
      $sql = "SELECT nom FROM vax_vaccins WHERE nom = :nom";
      $query = $pdo -> prepare($sql);
      $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
      $query -> execute();
      $nomVaccin = $query -> fetch();
      if(!empty($nomVaccin)){
        $errors['nom'] = "Ce vaccin est déjà présent dans la base de données.";
      }
    }else{
      $errors['nom'] = "Veuillez remplir ce champ";
    }
    if(!empty($_POST['cible'])){
    }else{
      $errors['cible'] = "Veuillez remplir ce champ";
    }
    if(!empty($_POST['labo'])){
    }else{
      $errors['labo'] = "Veuillez remplir ce champ";
    }
// si le formulaire ne contient pas d'erreurs
    if(count($errors)==0){
      $sql = "INSERT INTO vax_vaccins(nom, maladie_cible, labo, info)
              VALUES (:nom, :cible, :labo, :info)";
      $query = $pdo -> prepare($sql);
      $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
      $query -> bindValue(':cible', $cible, PDO::PARAM_STR);
      $query -> bindValue(':labo', $labo, PDO::PARAM_STR);
      $query -> bindValue(':info', $info, PDO::PARAM_STR);
      $query -> execute();
      header('Location:b_vaccins_back.php');
    }

  }


?>
<form class="add-vaccin" action="" method="post">
  <legend>Ajouter un vaccin</legend>
  <label for="nom">Nom du vaccin</label>
  <input type="text" name="nom" value=""><br/>
  <span class="error"><?php if(!empty($errors['nom'])){echo $errors['nom'];};?></span><?php br(); ?>
  <label for="cible">Maladie ciblée</label>
  <input type="text" name="cible" value=""><br/>
  	<span class="error"><?php if(!empty($errors['cible'])){echo $errors['cible'];};?></span><?php br(); ?>
  <label for="labo">Laboratoire de production</label>
  <input type="text" name="labo" value=""><br/>
  <label for="info">Informations Complémentaires</label>
  <input type="text" name="info" value=""><br/>
  	<span class="error"><?php if(!empty($errors['info'])){echo $errors['info'];};?></span><?php br(); ?>
  <input type="submit" name="submit" value="Ajouter">
</form>
<a href="b_vaccins_back.php">Retour</a>
