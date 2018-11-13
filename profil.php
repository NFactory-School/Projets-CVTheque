<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

$id = $_SESSION['user']['id'];
$sql = "SELECT * FROM vax_profils
        WHERE id = $id";
        $query = $pdo -> prepare($sql);
        $query -> execute();
$user = $query -> fetch();

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

<div class='profil'>

  <span>Votre profil</span>

    <aside>
        <img src='img/avatar.jpg'    alt='avatar'>
        <h3>Informations principales : </h3>
        <ol>
          <li><?php echo $user['prenom'] ?></li>
          <li><?php echo $user['nom'] ?></li>
          <li><?php echo $user['mail'] ?></li>
        </ol>
    </aside>

    <section id='main'>
        <h2>Informations à remplir :</h2>
        <ul>
          <li>date de naissance : <?php echo $user['ddn'] ?></li>
          <li>sexe : <?php echo $user['sexe'] ?></li>
          <li>taille : <?php echo $user['taille'] ?></li>
          <li>poids : <?php echo $user['poids'] ?></li>
          <li>statut : <?php echo $user['status'] ?></li>
          <li>Indice de masse corporelle : <?php if(!empty($imc)){ echo $imc; } ?></li>
          <li><a class="myButton button"href="profil_edit.php">éditer profil</a></li>
          <li><a class="myButton"href="carnet.php">Mon carnet</a></li>
        </ul>
    </section>
<div class="clear"></div>
</div>


<?php
include 'inc/footer.php'; ?>
