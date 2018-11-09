<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');


$errors = array();
$success = false;
if(!empty($_POST['submit'])){
  // failles XSS
  $pseudo = trim(strip_tags($_POST['pseudo']));
  $mail = trim(strip_tags($_POST['mail']));
  $mdp = trim(strip_tags($_POST['mdp']));
  $mdpV = trim(strip_tags($_POST['mdpV']));

  // Verif pseudo
  if(!empty($_POST['pseudo'])){
    if(strlen($pseudo) < 4 || strlen($pseudo) > 100){
      $errors['pseudo'] = "La taille du pseudo n'est pas valide";}
    else{
      $sql ="SELECT pseudo FROM nf_user WHERE pseudo = :pseudo";
      $query = $pdo -> prepare($sql);
      $query -> bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
      $query -> execute();
      $userPseudo = $query->fetch();
      if(!empty($userPseudo)){
        $errors['pseudo'] = " pseudo déja utilisé ";
      }
    }
  }else{
    $errors['pseudo'] = "Veuillez entrer un pseudo valide";}

  // Verif mail
  if(!empty($_POST['mail'])){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
      if(strlen($mail) < 5 || (strlen($mail) >150)){
        $errors['mail'] = "Veuillez entrer un mail valide";
      }else{
        $sql = "SELECT mail FROM nf_user WHERE mail = :mail";
        $query = $pdo -> prepare($sql);
        $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
        $query -> execute();
        $userMail = $query -> fetch();
        if(!empty($userMail)){
          $errors['mail'] = "Adresse mail déja utilisée";
        }
      }
    }else{
      $errors['mail'] = 'Veuillez entrer une adresse mail valide';
    }
  }else{
      $errors['mail'] = "Veuillez renseigner une adresse mail";
  }

  // Verif taille mdp
  if(!empty($_POST['mdp'])){
    if(strlen($mdp) < 6 || strlen($mdp) > 100){
      $errors['mdp'] = "Veuillez entrer un mot de passe valide";
    }
  } else{
      $errors['mdp'] = "Veuillez entrer un mot de passe valide";
    }

  // MDPS identiques
  if($mdp != $mdpV){
    $errors['mdp'] = "Les mots de passe ne correspondent pas";
  }


  // S'il n'y a pas d'erreurs
  if(count($errors) == 0){
    $success = true;
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    $token = generateRandomString(120);
    $sql = "INSERT INTO nf_user (pseudo, mail, mdp ,status ,token , created_at) VALUES (:pseudo, :mail, :hash,'user', :token,  NOW())";
    $query = $pdo -> prepare($sql);
    $query -> bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
    $query -> bindValue(':token', $token, PDO::PARAM_STR);
    $query -> bindValue(':hash', $hash, PDO::PARAM_STR);
    $query -> execute();
    header('Location:redirection.php');
  }
}

?>

<div class="wrap">
<form class="" action="" method="post">
  <fieldset>
    <legend>Inscription</legend>
    <label for="mail">Adresse mail</label>
    <input type="text" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>">
    <span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span>
    <label for="pseudo">pseudo</label>
    <input type="text" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) {echo $_POST['pseudo'];}?>">
    <span class="error"><?php if(!empty($errors['pseudo'])){echo $errors['pseudo'];};?></span>
    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" value="">
    <span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span>
    <label for="mdpV">Confirmer le mot de passe</label>
    <input type="password" name="mdpV" value="">
    <input class="myButton" type="submit" name="submit" value="S'inscrire">
</fieldset>
</form>
</div>

<?php include ('inc/footer.php');
