<?php
include('inc/pdo.php');
include('inc/fonction.php');

include ('inc/header.php');

$errors = array();
if(!empty($_POST['submit'])){
    $mail = trim(strip_tags($_POST['mail']));
  if(!empty($_POST['mail'])){
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        $errors['mail'] = "Veuillez entrer un mail valide";
      }else{
        // requete sql
        $sql = "SELECT mail, token FROM vax_profils WHERE mail = :mail";
        $query = $pdo -> prepare($sql);
        $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
        $query -> execute();
        $user = $query -> fetch();
        if(!empty($user)){
          $body = '<p>Veuillez cliquer sur ce '.'<a class="myButton" href = "oublimdp.php?mail='.urlencode($user['mail']).'&token='.urlencode($user['token']).'">lien</a>'.'</p>';
        }else {
          $errors['mail'] = 'Cette adresse mail n\'est pas présente dans notre base de données';
        }
      }
    }else{
      $errors['mail'] = "Veuillez renseigner une adresse mail";
    }
}
?>

<!-- Formulaire avec recup du mail et envoi du token et du mail. -->
<form class="" action="" method="post">
<fieldset>
<legend>Mot de passe oublié </legend>
<?php if(!empty($_POST['mail']) && !empty($user)){
  echo $body = '<p>Veuillez cliquer sur ce '.'<a class="myButton" href = "oublimdp.php?mail='.urlencode($user['mail']).'&token='.urlencode($user['token']).'">lien</a>'.'</p>';
}else{?>
<label for="mail">Mail </label>
<input type="text" name="mail" value="">
<span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];}?></span>
<input class="myButton" type="submit" name="submit" value="Envoyer">
<span><?php if(!empty($body)){echo $body;};?></span>
<?php } ?></fieldset>
</form>

<?php include ('inc/footer.php');
