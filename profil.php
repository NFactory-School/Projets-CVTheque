<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged()==false){ //si pas connecté --> 403
 header('Location:403.php');
}

if($_SESSION['user']['status'] == 'banni'){ //si banni --> 403
  header('Location:403.php');
}
//obtenir ID de l'utilisateur
$id = $_SESSION['user']['id'];  

$user = basic_where_ID($id, 'id', 'vax_profils', '*');

//remplir $_SESSION
$_SESSION['user']['nom'] = $user['nom']; 
$_SESSION['user']['prenom'] = $user['prenom'];
$_SESSION['user']['ddn'] = $user['ddn'];
$_SESSION['user']['sexe'] = $user['sexe'];
$_SESSION['user']['taille'] = $user['taille'];
$_SESSION['user']['poids'] = $user['poids'];





if(!empty($user['taille']) && !empty($user['poids'])){ //si taille et poid existent --> calcul imc
  $taille = $user['taille']/100;
  $poids = $user['poids'];
  $imc = $taille*$taille;   //calcul imc
  $imc = $poids/$imc;
  $imc = round($imc, 3);  //3 chiffres après la virgule

  if ($imc<=20){
    $resultimc = 'Sous-poids';  //interpretation imc faible
  }
  else if ($imc>20 && $imc<=25){ //interpretation imc normal
    $resultimc = 'Poids idéal';
  }
  else if ($imc>=25 && $imc<=27){ //interpretation imc élevé
    $resultimc = 'Léger surpoids';
  }
  else{
    $resultimc = 'Obésité'; //interpretation imc Beaucoup trop élevé
  }
}
?>

<div class='profil'>
    <aside>
      <?php if(!empty($user['sexe']) && $user['sexe'] == 'homme'){
        echo '<img src="img/avatar.jpg"    alt="avatar">';
      }elseif(!empty($user['sexe'] && $user['sexe'] == 'femme')){
        echo '<img src="img/avatar2.jpg" alt="avatar">';
      }else{
        echo '<img src="img/avatar3.jpg" alt="avatar">';

      } ?>
        <div class="trait"></div>
        <h3>Informations principales : </h3>
        <ol>
          <li><?php echo $user['prenom']; ?></li>
          <li><?php echo $user['nom']; ?></li>
          <li><?php echo $user['mail']; ?></li>
        </ol>
    </aside>

    <h2 class="titre">Votre profil</h2>
    <div class='main'>
        <h3>Informations à remplir :</h3>
        <ul>

          <?php
          if (!empty($user['ddn'])){echo '<li><span class="bleu">Date de naissance : </span>'.$user['ddn'];}
          if (!empty($user['sexe'])) {echo '<li><span class="bleu">Sexe : </span>'.$user['sexe'].'</li>';}
          if (!empty($user['taille'])) { echo '<li><span class="bleu">Taille : </span>'.$user['taille'].'</li>';}
          if (!empty($user['poids'])) { echo '<li><span class="bleu">Poids : </span>'.$user['poids'].'</li>';}
          if(!empty($imc)){ echo '<li><span class="bleu">Indice de masse corporelle : </span>'.$imc.' - '.$resultimc.'</li>';}
          br();
          if (!empty($user['status']) && $user['status']=='admin') { echo '<li class="admin"><span class="bleu">Statut : </span><span class="upper">'.$user['status'].'</span></li>';}
          ?>
          <li><a class="myButton"href="profil_edit.php">Editer profil</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>
<a class="myButton button fixed" href="carnet.php">Mon carnet</a>


<?php
include 'inc/footer.php'; ?>