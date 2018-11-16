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
          <li><?php echo $user['prenom'] ?></li>
          <li><?php echo $user['nom'] ?></li>
          <li><?php echo $user['mail'] ?></li>
        </ol>
    </aside>

    <h2>Votre profil</h2>
    <div class='main'>
        <h3>Informations à remplir :</h3>
        <ul>

          <li><span class="bleu">Date de naissance : </span><?php if (!empty($_SESSION['user']['ddn'])){echo $_SESSION['user']['ddn'];}
          else{ echo '0000-00-00';} ?></li>
          <li><span class="bleu">Sexe : </span><?php echo $user['sexe'] ?></li>
          <li><span class="bleu">Taille : </span><?php echo $user['taille'] ?></li>
          <li><span class="bleu">Poids : </span><?php echo $user['poids'] ?></li>
          <li><span class="bleu">Statut : </span><?php echo $user['status'] ?></li>

          <li><span class="bleu">Indice de masse corporelle : </span><?php if(!empty($imc)){ echo $imc; } ?></li>
          <li><a class="myButton"href="profil_edit.php">Editer profil</a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>
<a class="myButton button fixed" href="carnet.php">Mon carnet</a>


<?php
include 'inc/footer.php'; ?>
