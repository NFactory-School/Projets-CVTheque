<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
// if(!empty($_COOKIE['user']) && empty($_SESSION['user'])){
//   $user=$_COOKIE['user'];
//   $user=explode('-----',$user);
//   $user= profil_edit1($id);
//   $key= sha1($user['id'].$user['mdp'].$_SERVER['REMOTE_ADDR']);
//   if($key == $user[1]){
//     $_SESSION['user']= (array)$user;
//     setcookie('user',$user['id'].'-----'.$key,time()+3600*24,'/C:/xampp/htdocs/vax/vaccin6',false ,true);
//   }else{
//     setcookie('user','',time()-3600*24,'/C:/xampp/htdocs/vax/vaccin6',false ,true);
//   }
//}
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
    if(!empty($mail)){
      if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
        if(strlen($mail) < 5 || (strlen($mail) >150)){
          $errors['mail'] = "Veuillez entrer un mail valide";
        }else{
              $userMail = index($mail);

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
//
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

      if(!empty($_POST['remember'])){
          setcookie('userma',$user['mail'],time()+3600*24,'/',false ,true);
          setcookie('usermd',$hash,time()+3600*24,'/',false ,true);
      }

    }

  }
  include ('inc/header.php');
?>

<div class="wrap">
  <div class="index">
    <div class="intro">
      <h2>Bienvenue sur <span>VAX</span></h2>
  		<p>Gérer vos vaccins<br></p>
  		<span class="texte-intro">en ligne.</span>
    </div>

    <div class="minislider">
      <p class="item-1"><span class="bolder">Selon l'OMS : </span> la vaccination est l’une des interventions sanitaires les plus efficaces et les plus économiques. Elle a permis d’éradiquer la variole, de réduire de 99 % à ce jour l’incidence mondiale de la poliomyélite, et de faire baisser de façon spectaculaire la morbidité, les incapacités et la mortalité dues à la diphtérie, au tétanos, à la coqueluche et à la rougeole. Pour la seule année 2003, on estime que la vaccination a évité plus de deux millions de décès</p>
      <p class="item-2"><span class="bolder">Lorsque l’on se fait vacciner contre une maladie infectieuse,</span> on évite de développer cette maladie et, par conséquent, de transmettre le microbe aux autres. En se faisant vacciner, on se protège donc soi-même, mais on protège aussi les autres : ses enfants, ses proches, ses voisins et l’ensemble des membres de la collectivité.</p>
      <p class="item-3"><span class="bolder">De nombreuses maladies qui ont disparu en France </span>ou qui sont devenues très rares continuent d’exister dans d’autres régions du monde, où la vaccination n’est pas mise en œuvre de manière suffisante. Si l’on arrêtait la vaccination en France, ces maladies reviendraient.</p>
    </div>

    <!-- Formulaire d'inscription -->
    <div class="form-wrap">
  		<div class="tabs">
  			<h3 class="signup-tab"><a class="active" href="#signup-tab-content">Inscription</a></h3>
  			<h3 class="login-tab"><a href="#login-tab-content">Connexion</a></h3>
  		</div><!--.tabs-->

  		<div class="tabs-content">
  			<div id="signup-tab-content" class="active">
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

  			<div id="login-tab-content">
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
    <div class="clear"></div>
  </div>
</div>



<?php
include 'inc/footer.php'; ?>
