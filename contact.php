<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/request.php';
include 'inc/header.php';

if (isLogged()==false){
 header('Location:403.php');
}

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

$errors = array();
if(!empty($_POST['submit'])) {
  $obj = trim(strip_tags($_POST['obj']));
  $msg = trim(strip_tags($_POST['msg']));
  $name = trim(strip_tags($_POST['name']));
  $mail = trim(strip_tags($_POST['mail']));

  // Verifier si l'objet est valide
  if(!empty($obj)){
    if(strlen($obj) < 4){
      $errors['obj'] = "L'objet est trop court";
    }if(strlen($obj) > 155){
      $errors['obj'] = "L'objet est trop long";
    }
  }else{
    $errors['obj'] = "Veuillez renseigner un objet";
  }

  // Si le message est valide
  if(!empty($msg)){
  // Verif longueur message
    if(strlen($msg) < 3){
      $errors['msg'] = "Le message est trop court";
    }if(strlen($msg) > 1500){
      $errors['msg'] = "Le message est trop long";
    }
  }else{
    $error['msg'] = "Veuillez écrire un message";
  }

  // Verif longueur nom
  if(!empty($name)){
    if(strlen($name) < 4){
      $errors['name'] = "le nom est trop court";
    }elseif(strlen($name) > 255){
      $errors['name'] = "Le nom est trop long";
    }
  }else{
    $errors['name'] = "Vous devez renseigner un nom";
  }

  // Verif mail
  if(!empty($_POST['mail'])){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
      if(strlen($mail) < 5 || (strlen($mail) >150)){
        $errors['mail'] = "Veuillez entrer un mail valide";
      }
    }else{
      $errors['mail'] = 'Veuillez entrer une adresse mail valide';
    }
  }else{
    $errors['mail'] = "Veuillez renseigner une adresse mail";
  }

// Si pas d'erreurs dans formulaire
    if (count($errors) == 0) {
    contact($obj, $msg, $name, $mail);
    // header('Location:profil.php');
  }
} ?>

<!-- Ajouter le pseudo de session a la value de name -->
<div class="form-container">

  <form class="contacts" action="" method="post">

    <h2>Vos Coordonnées</h2>
      <div class="champ">
        <label for="name">Votre nom</label>
        <input class="champ" type="text" name="name" value="<?php if(!empty($_POST['name'])) {echo $_POST['name'];}?>" placeholder="Ex:Jean Bonneau">
        <span class="error"><?php if(!empty($errors['name'])){echo $errors['name'];};?></span>
      </div>
      <div class="champ">
        <label for="mail">Votre adresse mail</label>
        <input class="champ" type="mail" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>" placeholder="Ex:jb@jambon.fr">
        <span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span>
      </div>
      <div class="trait"></div>

    <h2>Nous Contacter</h2>
      <div class="champ">
        <span>Objet</span>
        <input type="text" name="obj" placeholder="Ex : Je suis content" value="<?php if(!empty($_POST['obj'])) {echo $_POST['obj'];}?>" placeholder="Ex:Jean Bonneau">
        <span class="error"><?php if(!empty($errors['obj'])){echo $errors['obj'];};?></span>
      </div>
      <div class="champ">
        <label for="msg">Votre Message</label>
        <textarea class="champ"name="msg" rows="8" cols="80" placeholder="Votre message ici.."></textarea>
        <span class="error"><?php if(!empty($errors['msg'])){echo $errors['msg'];};?></span>
      </div>


      <input class="myButton" type="submit" name="submit" value="Envoyer">
      <input class="myButton" type="reset" name="" value="Annuler">

  </form>
</div>

<?php include 'inc/footer.php';
