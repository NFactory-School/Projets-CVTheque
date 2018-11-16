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
      header('Location:index.php#sign-in');

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

    <!-- Formulaire d'inscription -->
  <div class="signlogin-container">
    <div class="a-group">
        <a href="index.php#sign-in" class="a-sign-in">Connexion</a>
        <a href="index.php#sign-up" class="a-sign-up">Inscription</a>
    </div>
    <div class="form-content">
        <div id="sign-in">
            <form class="login-form" action="" method="post">

                <input type="text" name="mail" class="input" id="user_login" placeholder="Adresse mail">
                <span class="error"><?php if(!empty($error['mail'])) { echo $error['mail']; } ?></span>
                <input type="password" name="mdp" class="input" id="user_passl" placeholder="Mot de passe">
                <span class="error"><?php if(!empty($error['mdp'])) { echo $error['mdp']; } ?></span>

                <div class="ligne"></div>
                <input type="submit" name="connexion" class="button" value="Se connecter">
                <div class="help-text">
                  <div class="ligne"></div>
                	<p><a class="lienutile" href="oublimail.php">Mot de passe oublié ?</a></p>
                </div><!--.help-text-->
            </div>
          </form>
        <div id="sign-up">
              <form class="signup-form" action="" method="post">
                <input type="email" name="mail" class="input" id="user_email" placeholder="Adresse mail">
                <span class="error"><?php if(!empty($errors['mail'])) { echo $errors['mail']; } ?></span>
                <input type="password" name="mdp" class="input" id="user_passS" placeholder="Mot de passe">
                <span class="error"><?php if(!empty($errors['mdp'])) { echo $errors['mdp']; } ?></span>
                <input type="password" name="mdpV" class="input" id="user_passV" placeholder="Répéter mot de passe">
                <span class="error"><?php if(!empty($errors['mdpV'])) { echo $errors['mdpV']; } ?></span>
                <div class="ligne"></div>
                <input type="submit" name="submit" class="button" value="S'inscrire">
                <div class="help-text">
                  <div class="ligne"></div>
                	<p>En vous inscrivant vous acceptez nos</p>
                	<p><a class="lienutile" href="cgu.php">termes et services</a></p>
                </div><!--.help-text-->
              </form>
              <div class="clear"></div>
        </div>
      </div>
    </div>

    <div class="minislider">
      <p ><span class="bolder">Selon l'OMS </span> la vaccination est l’une des interventions sanitaires les plus efficaces et les plus économiques. Elle a permis d’éradiquer la variole, de réduire de 99 % à ce jour l’incidence mondiale de la poliomyélite, et de faire baisser de façon spectaculaire la morbidité, les incapacités et la mortalité dues à la diphtérie, au tétanos, à la coqueluche et à la rougeole. Pour la seule année 2003, on estime que la vaccination a évité plus de deux millions de décès</p>
      <p ><span class="bolder">Lorsque l’on se fait vacciner contre une maladie infectieuse,</span> on évite de développer cette maladie et, par conséquent, de transmettre le microbe aux autres. En se faisant vacciner, on se protège donc soi-même, mais on protège aussi les autres : ses enfants, ses proches, ses voisins et l’ensemble des membres de la collectivité.</p>
      <p ><span class="bolder">De nombreuses maladies qui ont disparu en France </span>ou qui sont devenues très rares continuent d’exister dans d’autres régions du monde, où la vaccination n’est pas mise en œuvre de manière suffisante. Si l’on arrêtait la vaccination en France, ces maladies reviendraient.</p>
    </div>
  </div>
  <div class="clear">
</div>
<div class="clear">

</div>




<?php
include 'inc/footer.php'; ?>
