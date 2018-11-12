<?php
include ('inc/pdo.php');
include ('inc/fonction.php');

if(islogged()){
  header('Location:carnet.php');
}else {

  $errors = array();
  $success = false;
  if(!empty($_POST['submit'])){
    // failles XSS

    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));
    $mdpV = trim(strip_tags($_POST['mdpV']));



    // Verif mail
    if(!empty($_POST['mail'])){
      if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
        if(strlen($mail) < 5 || (strlen($mail) >150)){
          $errors['mail'] = "Veuillez entrer un mail valide";
        }else{
          $sql = "SELECT mail FROM vax_profils WHERE mail = :mail";
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
      $sql = "INSERT INTO vax_profils ( mail, mdp , created_at,token,status) VALUES ( :mail, :hash, NOW(), :token,'user')";
      $query = $pdo -> prepare($sql);
      $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
      $query -> bindValue(':token', $token, PDO::PARAM_STR);
      $query -> bindValue(':hash', $hash, PDO::PARAM_STR);
      $query -> execute();
      header('Location:index.php');
    }
  }
    if(!empty($_POST['connexion'])){
    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));

  // Vérif  & MDP
    $sql = "SELECT * FROM vax_profils
            WHERE  mail = :mail";
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
  // if(!empty($_POST['remember'])){
  //   setcookie('user_id',$user -> id,time()+3600*24)
  // }

    if(count($errors) == 0){

      $_SESSION['user'] = array(
        'id' => $user['id'],
        'mail' => $user['mail'],
        'status' => $user['status'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'ddn' => $user['ddn'],
        'taille' => $user['taille'],
        'poids' => $user['poids'],
        'notif' => $user['notif'],
        'ip' => $_SERVER['REMOTE_ADDR']
      );

        // header('Location:profil.php');
      }
    }
    // header('Location:index.php');
  }

  include ('inc/header.php');
?>


    <div class="intro">

        <h2>Bienvenue sur <span>VAX</span></h2>
		<p>Gérer vos vaccins<br></p>
		<span class="texte-intro">en ligne.</span>
    </div>

<div class="login-wrap">
	<div class="login-html">
	<form action="index.php" method="post">

		<input id="tab-1" type="radio" name="tab" class="sign-in" checked>
		<label for="tab-1" class="tab">S'inscrire</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up">
		<label for="tab-2" class="tab">Connexion</label>

		<div class="login-form">

			<div class="sign-in-htm">



				<div class="group">
					<span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span>
					<input type="text" placeholder="Adresse E-mail" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>"><br>
					<?php br(); ?>
				</div>

				<div class="group">
				<span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span>
					<input type="password" placeholder="Mot de passe" name="mdp" value=""><br>
					<?php br(); ?>
				</div>

				<div class="group">
					<input type="password" placeholder="Répéter mot de passe" name="mdpV" value=""><br>
				</div>

				<div class="group">
					<input type="submit" class="myButton" name="submit" value="S'inscrire">
				</div>
				<div class="hr"></div>
			</div>

	</form>

	<form action="index.php" method="post">

			<div class="sign-up-htm">

				<div class="group">
					<input type="text" placeholder="Adresse E-mail" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>"><br>
					<span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span><?php br(); ?>
				</div>

				<div class="group">
					<input type="password" placeholder="Mot de passe" name="mdp" value=""><br>
					<span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span><?php br(); ?>
				</div>

				<div class="group">
          <label for="checkbox">
          <input type="checkbox" name="remember" value="remember">Se souvenir de moi
        </label>
					<input type="submit" class="myButton" value="Se connecter" name="connexion">
          <a href="oublimail.php">mot de passe oublié ?</a>
				</div>
				<div class="hr"></div>
			</div>
		</div>
	</form>
	</div>
</div>

<?php
include 'inc/footer.php'; ?>
