<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/request.php';
include 'inc/header.php';

if (isLogged()==false){
 header('Location:403.php');
}

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

<div class="carnet">
  <div class="pp">
    <h2 class="titre">Votre Carnet</h2>
    <img src="img/avatar.jpg" alt="photo de profil">
  </div>

  <div class="clear"></div>

  <div>


    <div class="listeVaccin">
      <form action="carnet.php" method="post">

          <?php
            $listeVaccin = b_select_vaccin_from_vaccins();
            $listeVaccinUser = b_select_vaccinanduser_from_pivot($_SESSION['user']['id']);
            $infopivots = b_select_nom_from_pivot($_SESSION['user']['id']);
            $nope = 1;

            foreach($listeVaccin as $cle=>$valeur){

              $nom = $listeVaccin[$cle]['nom'];
              $date = $listeVaccin[$cle]['nom'].'_Rappel';

              if (!empty($_POST)){


                foreach($_POST as $cursor=>$valeur){
                  $valeur = trim(strip_tags($_POST[$cursor]));
                  if ($cursor == $nom){
                    b_insert_vaccin_in_pivot($_SESSION['user']['id'],$listeVaccin[$cle]['id']);
                    header('Location:carnet.php');
                  }
                  if ($cursor == $date){
                    b_update_rappel_in_pivot($_SESSION['user']['id'],$listeVaccin[$cle]['id'],$_POST[$cursor]);
                    header('Location:carnet.php');
                  }
                }
              }
                foreach($listeVaccinUser as $key=>$valeur){

                    if ($listeVaccin[$cle]['id'] == $listeVaccinUser[$key]['id_vaccins']){
                      ?>
                      <div class="vaccinfait">
                      <input type="checkbox" name="<?php echo $nom;?>" checked="checked" disabled="disabled">
                      <span class="check"><?php echo $nom; ?></span>
                 <br/><input type="date" name="<?php echo $nom; ?>_Rappel" value="<?php

                      foreach($infopivots as $cdt=>$valeur){

                        if($infopivots[$cdt]['nom'] == $nom){
                          echo $infopivots[$cdt]['rappel'];
                        }
                      } ?>"><br/></div><?php
                      $nope = 0;
                      break;
                    }
                    else {
                      $nope = 1;
                    }
                }
                  if ($nope == 1) {
                  ?>
                  <div class="vaccinFait">
                  <input type="checkbox" name="<?php echo $listeVaccin[$cle]['nom'];?>">
                  <span><?php echo $listeVaccin[$cle]['nom']; ?></span></div><?php
                }
            } ?>
            <div class="clear"></div>
          <input type="submit" class="valider" name="listeRappel" value="Confirmer">
      </form>
    </div>
    <a class="myButton button" href="profil.php">Mon profil</a>
  </div>
</div>

<div class="clear"></div>
<?php include 'inc/footer.php';
