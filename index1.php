<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';

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
    $errors = vMail($errors, $mail, 5, 150, 'mail');

    // Verif taille mdp
    $errors = vMdp($errors, $mdp, $mdpV, 6, 100, 'mdp');


    // S'il n'y a pas d'erreurs INCRIPTION
    if(count($errors) == 0){
      $success = true;
      $hash = password_hash($mdp, PASSWORD_DEFAULT);
      $token = generateRandomString(120);
      index1($mail, $token, $hash);
      header('Location:index1.php');

    }
  }

  $error = array();
    // CONNECTION
    if(!empty($_POST['connexion'])){
    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));

  // Vérif  & MDP
  $user = index2($mail);

  if(!empty($user)){

    if(!password_verify($mdp, $user['mdp'])){

      $error['mdp'] = "mdp invalide";
    }
  }
  else{

    $error['mail'] = 'Vous n\'êtes pas inscrit';
  }
  // if(!empty($_POST['remember'])){
  //   setcookie('user_id',$user -> id,time()+3600*24)
  // }

    if(count($error) == 0){
      $_SESSION['user'] = array(
        'id' => $user['id'],
        'mail' => $user['mail'],
        'status' => $user['status'],
        'ip' => $_SERVER['REMOTE_ADDR']
      );

        header('Location:profil.php');
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

<div class="form-wrap">
		<div class="tabs">
			<h3 class="signup-tab"><a href="#signup-tab-content">Inscription</a></h3>
			<h3 class="login-tab"><a class="active" href="#login-tab-content">Connexion</a></h3>
		</div><!--.tabs-->

		<div class="tabs-content">
			<div id="signup-tab-content">
        <form class="signup-form" action="" method="post">
					<input type="email" name="mail" class="input" id="user_email" placeholder="Adresse mail">
          <span class="error"><?php if(!empty($errors['mail'])) { echo $errors['mail']; } ?></span>
          <input type="password" name="mdp" class="input" id="user_passS" placeholder="Mot de passe">
          <span class="error"><?php if(!empty($errors['mdp'])) { echo $errors['mdp']; } ?></span>
          <input type="password" name="mdpV" class="input" id="user_passV" placeholder="Répéter mot de passe">
          <span class="error"><?php if(!empty($errors['mdpV'])) { echo $errors['mdpV']; } ?></span>
          <div class="ligne"></div>
					<input type="submit" name="submit" class="button" value="S'inscrire">
				</form><!--.login-form-->
				<div class="help-text">
					<p>En vous inscrivant vous acceptez nos</p>
					<p><a class="lienutile" href="cgu.php">termes et services</a></p>
				</div><!--.help-text-->
			</div><!--.signup-tab-content-->

			<div id="login-tab-content" class="active">
        <form class="login-form" action="" method="post">
          <input type="text" name="mail" class="input" id="user_login" placeholder="Adresse mail">
          <span class="error"><?php if(!empty($error['mail'])) { echo $error['mail']; } ?></span>
          <input type="password" name="mdp" class="input" id="user_passl" placeholder="Mot de passe">
          <span class="error"><?php if(!empty($error['mdp'])) { echo $error['mdp']; } ?></span>
          <input type="checkbox" name="remember" class="checkbox" id="remember_me">
          <label for="remember_me">Se souvenir de moi</label>
          <div class="ligne"></div>
          <input type="submit" name="connexion" class="button" value="Se connecter">
        </form><!--.login-form-->
				<div class="help-text">
					<p><a class="lienutile" href="oublimail.php">Mot de passe oublié ?</a></p>
				</div><!--.help-text-->
			</div><!--.login-tab-content-->
		</div><!--.tabs-content-->
  </div><!--.form-wrap-->



<?php
include 'inc/footer.php'; ?>
