<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged()==false){
 header('Location:403.php');
}

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

$id = $_SESSION['user']['id'];
$user = profil($id);
$_SESSION['user']['nom'] = $user['nom'];
$_SESSION['user']['prenom'] = $user['prenom'];
$_SESSION['user']['ddn'] = $user['ddn'];
$_SESSION['user']['sexe'] = $user['sexe'];
$_SESSION['user']['taille'] = $user['taille'];
$_SESSION['user']['poids'] = $user['poids'];

if(!empty($user['taille']) && !empty($user['poids'])){
  $taille = $user['taille']/100;
  $poids = $user['poids'];
  $imc = $taille*$taille;
  $imc = $poids/$imc;
  $imc = round($imc, 3);

  if ($imc<=20){
    $resultimc = 'insuffisance';
  }
  else if ($imc>20 && $imc<=25){
    $resultimc = 'bon';
  }
  else if ($imc>=25 && $imc<=27){
    $resultimc = 'exces';
  }
  else{
    $resultimc = 'risque';
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

    <h2>Votre profil</h2>
    <div class='main'>
        <h3>Informations à remplir :</h3>
        <ul>

          <?php if (!empty($user['ddn'])){echo '<li><span class="bleu">Date de naissance : </span>'.$user['ddn'];}

          if (!empty($user['sexe'])) {echo '<li><span class="bleu">Sexe : </span>'.$user['sexe'].'</li>';}
          if (!empty($user['taille'])) { echo '<li><span class="bleu">Taille : </span>'.$user['taille'].'</li>';}
          if (!empty($user['poids'])) { echo '<li><span class="bleu">Poids : </span>'.$user['poids'].'</li>';}
          if (!empty($user['status']) && $user['status']=='admin') { echo '<li><span class="bleu">Statut : </span>'.$user['status'].'</li>';}
          ?>
          <li><span class="bleu">Indice de masse corporelle : </span><?php if(!empty($imc)){ echo $imc; } ?></li>
          <li><a class="myButton button"href="profil_edit.php">Editer profil</a></li>
          <li><a class="myButton" href="carnet.php">Mon carnet</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>


<?php
include 'inc/footer.php'; ?>
