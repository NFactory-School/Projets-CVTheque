<?php
include 'inc/require.php';
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
      b_add_vaccin();
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
      b_add_vaccin1();
      header('Location:b_vaccins_back.php');
    }

  }


?>
<form class="add-vaccin" action="" method="post">
  <legend>Ajouter un vaccin</legend>
  <label for="nom">Nom du vaccin</label>
  <input type="text" name="nom" value=""><br/>
  <span class="error"><?php error($errors,'nom');?></span><?php br(); ?>
  <label for="cible">Maladie ciblée</label>
  <input type="text" name="cible" value=""><br/>
  	<span class="error"><?php error($errors,'cible');?></span><?php br(); ?>
  <label for="labo">Laboratoire de production</label>
  <input type="text" name="labo" value=""><br/>
  <label for="info">Informations Complémentaires</label>
  <input type="text" name="info" value=""><br/>
  	<span class="error"><?php error($errors,'info');?></span><?php br(); ?>
  <input type="submit" name="submit" value="Ajouter">
</form>
<a href="b_vaccins_back.php">Retour</a>
