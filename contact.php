<?php
include 'inc/pdo.php';
include 'inc/fonction.php';

include 'inc/header.php';

$errors = array();
if(!empty($_POST['submit'])) {
  $msg = $_POST['msg'];
  $name = trim(strip_tags($_POST['name']));
  $mail = trim(strip_tags($_POST['mail']));

// Si le message est valide
if(!empty($msg) && is_string($msg)){
// Verif longueur message
    if(strlen($msg) < 3){
      $errors['msg'] = "Le message est trop court";
    }elseif(strlen($msg) > 1500){
      $errors['msg'] = "Le message est trop long";
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
}

// Si pas d'erreurs dans formulaire
    if (count($errors) == 0) {
    $sql = "INSERT INTO vax_contact (message, nom, mail, created_at)
            VALUES (:msg, :name, :mail, NOW())";
    $query = $pdo -> prepare($sql);
    $query -> bindValue(':msg', $msg, PDO::PARAM_STR);
    $query -> bindValue(':name', $name, PDO::PARAM_STR);
    $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
    $query -> execute();
    header('Location:index.php');
  }
} ?>

<!-- Ajouter le pseudo de session a la value de name -->
<form class="form" action="" method="post">
  <fieldset>
  <legend>Nous Contacter</legend>
    <label for="obj">Objet</label>
    <input type="text" name="obj" placeholder="Ex : Je suis content" value="">
    <label for="msg">Votre Message</label>
    <textarea name="msg" rows="8" cols="80" placeholder="Votre message ici.."><?php if(!empty($_POST['msg'])) {echo $_POST['msg'];}?></textarea>
    <span class="error"><?php if(!empty($errors['msg'])){echo $errors['msg'];};?></span>
  </fieldset>
  <fieldset>
  <legend>Vos Coordonnées</legend>
    <label for="name">Votre nom</label>
    <input type="text" name="name" value="<?php if(!empty($_POST['name'])) {echo $_POST['name'];}?>" placeholder="Ex:Jean Bonneau">
    <span class="error"><?php if(!empty($errors['name'])){echo $errors['name'];};?></span>
    <label for="mail">Votre adresse mail</label>
    <input type="mail" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>" placeholder="Ex:jb@jambon.fr"><br>
    <span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span>
    <input type="submit" name="submit" value="Envoyer">
    <input type="reset" name="" value="Annuler">
  </fieldset>
  </form>

<?php include 'inc/footer.php';
