<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');

if(islogged()){
  header('Location:index.php');
}else {


    if(!empty($_POST['submit'])){
    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));

  // Vérif pseudo & MDP
    $sql = "SELECT * FROM nf_user
            WHERE pseudo = :mail OR mail = :mail";
    $query = $pdo -> prepare($sql);
    $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
    $query -> execute();
  $user = $query -> fetch();

  if(!empty($user)){

    if(!password_verify($mdp, $user['mdp'])){

      $errors['mdp'] = "mdp invalide";
    }
  }
  else{

    $errors['mail'] = 'Vous n\'êtes pas inscrit';
  }


    if(count($errors) == 0){

      $_SESSION['user'] = array(
        'id' => $user['id'],
        'pseudo' => $user['pseudo'],
        'mail' => $user['mail'],
        'status' => $user['status'],
        'ip' => $_SERVER['REMOTE_ADDR']
      );
      if($user['status'] == 'admin'){
        header('Location:back/back_office.php');
      }else{
       header('Location:index.php');
     }


    }
  }
}
?>

<div class="wrap">
  <form class="" action="" method="post">
    <fieldset>
      <legend>Connection</legend>
        <label for="pseudo">Pseudo ou adresse mail</label>
      <input type="text" name="mail" value="">
      <span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span>
        <label for="mdp">Mot de passe</label>
      <input type="password" name="mdp" value="">
      <span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span><br>
      <input class="myButton" type="submit" name="submit" value="Connexion">
      <p><a class="myButton" href="oublimail.php">mot de passe oublié ?</a></p>
    </fieldset>
  </form>
</div>

<?php include ('inc/footer.php');
