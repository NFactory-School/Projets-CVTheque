<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (!empty($_GET['mail']) && !empty($_GET['token'])) {
  $mail = urldecode($_GET['mail']);
  $token = urldecode($_GET['token']);
  $user = oublimdp($token, $mail);
  if(!empty($user)){
    if(!empty($_POST['submit'])) {
      $mdp = trim(strip_tags($_POST['mdp']));
      $mdpV = trim(strip_tags($_POST['mdpV']));
      
      $errors = vMdp($errors, $mdp, $mdpV, 6, 100, 'mdp');

      if(count($errors) == 0){
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        $token = generateRandomString(120);
        $userid = $user['id'];
        oublimdp1($hash, $token, $userid);
        header('Location:index.php');
      }
    }
  }else {
    // header('Location:404.php');}
}
// else{
  // header('Location:404.php');}
}
?>


 <!-- ici : formulaire pour update mdp avec sql -->
<form class="" action="" method="post">
  <fieldset>
    <legend>Modifier votre mot de passe</legend>
    <label for="mdp">Nouveau mot de passe</label>
    <input type="password" name="mdp" value="">
    <span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span>
    <label for="mdpV">Confirmer le mot de passe</label>
    <input type="password" name="mdpV" value="">
    <input class="myButton" type="submit" name="submit" value="Modifier">
  </fieldset>
</form>


<?php include ('inc/footer.php');
