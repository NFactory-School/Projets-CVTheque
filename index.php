<?php
include ('inc/pdo.php');
include ('inc/request.php');
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
              //index($mail) = $userMail;
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
      $sql = "INSERT INTO vax_profils ( mail, mdp , created_at,token,status)
              VALUES ( :mail, :hash, NOW(), :token,'user')";
      $query = $pdo -> prepare($sql);
      $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
      $query -> bindValue(':token', $token, PDO::PARAM_STR);
      $query -> bindValue(':hash', $hash, PDO::PARAM_STR);
      //index1($mail, $token, $hash);
      header('Location:index.php');
    }
  }
    if(!empty($_POST['connexion'])){
    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));

  // Vérif  & MDP
  $sql = "SELECT * FROM vax_profils
          WHERE mail = :mail";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> execute();
  $user = $query -> fetch();
    //index3($mail);

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

<div class="form-wrap">
		<div class="tabs">
			<h3 class="signup-tab"><a class="active" href="#signup-tab-content">Sign Up</a></h3>
			<h3 class="login-tab"><a href="#login-tab-content">Login</a></h3>
		</div><!--.tabs-->

		<div class="tabs-content">
			<div id="signup-tab-content" class="active">
				<form class="signup-form" action="" method="post">
					<input type="email" name="mail" class="input" id="user_email" placeholder="Adresse mail">
          <input type="password" name="mdp" class="input" id="user_pass" placeholder="Mot de passe">
          <input type="password" name="mdpV" class="input" id="user_pass2" placeholder="Répéter mot de passe">
          <div class="ligne"></div>
					<input type="submit" name="submit" class="button" value="Sign Up">
				</form><!--.login-form-->
				<div class="help-text">
					<p>En vous inscrivant vous acceptez nos</p>
					<p><a class="lienutile" href="#">termes et services</a></p>
				</div><!--.help-text-->
			</div><!--.signup-tab-content-->

			<div id="login-tab-content">
				<form class="login-form" action="" method="post">
          <input type="text" name="mail" class="input" id="user_login" placeholder="Adresse mail">
					<input type="password" name="mdp" class="input" id="user_pass" placeholder="Mot de passe">
					<input type="checkbox" class="checkbox" id="remember_me">
          <label for="remember_me">Se souvenir de moi</label>
          <div class="ligne"></div>
          <input type="submit" name="connexion" class="button" value="Login">
				</form><!--.login-form-->
				<div class="help-text">
					<p><a class="lienutile" href="oublimail.php">Mot de passe oublié ?</a></p>
				</div><!--.help-text-->
			</div><!--.login-tab-content-->
		</div><!--.tabs-content-->
  </div><!--.form-wrap-->

<?php
include 'inc/footer.php'; ?>
