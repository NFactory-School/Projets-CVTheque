<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

if(!empty($_SESSION['user']['taille']) && !empty($_SESSION['user']['poids'])){
  $taille = $_SESSION['user']['taille']/100;
  $poids = $_SESSION['user']['poids'];
  $imc = $taille*$taille;
  $imc = $poids/$imc;

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

<div class="profil">
  <aside class="aside">
    <div class="pp"><img class="bonhomme" src="img/avatar.jpg" alt=""></div>
      <div class="clear"></div>
      <h3>Infos du profil</h3>

        <?php if(!empty($_SESSION['user']['prenom'])){
                echo '<p>'.$_SESSION['user']['prenom'].'</p>';
              }
              if(!empty($_SESSION['user']['nom'])){
                echo '<p>'.$_SESSION['user']['nom'].'</p>';
              }
              if(!empty($_SESSION['user']['taille'])){
                echo '<p> taille : '.$_SESSION['user']['taille'].' cm</p>';
              }
              if(!empty($_SESSION['user']['poids'])){
                echo '<p> poids :'.$_SESSION['user']['poids'].' kg</p>';
              }
              if(!empty($_SESSION['user']['taille']) && !empty($_SESSION['user']['poids'])){
                echo '<p>IMC = '.$imc.'</p>';
              }
        ?>

  </aside>
  <div class="carnet">
    <span>Votre Carnet</span>

  </div>
</div>

<div class="clear"></div>
<?php include 'inc/footer.php';
