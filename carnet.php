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

<div class="profil">
  <aside class="aside">
    <div class="pp"><img class="bonhomme" src="img/avatar.jpg" alt=""></div>
      <div class="trait"></div>
      <div class="clear"></div>
      <h3>Informations du profil : </h3>

        <?php //infos profil
        
              if(!empty($_SESSION['user']['prenom'])){
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
    <h2>Votre Carnet</h2>

    <div class="listeVaccin">
      <form action="carnet.php" method="post">

          <?php 
            $listeVaccin = b_select_vaccin_from_vaccins();
            $listeVaccinUser = b_select_vaccinanduser_from_pivot($_SESSION['user']['id']);
            $counter =0;

            foreach($listeVaccin as $key=>$valeur){
              
              $nom = $listeVaccin[$key]['nom'];
              $id = $listeVaccin[$key]['id'];
              
              
              foreach($listeVaccinUser as $key=>$valeur){
                $vaccin = $listeVaccinUser[$key]['id_vaccins'];
                
                if (!empty($listeVaccinUser[$key]) && $listeVaccinUser[$key]['id_vaccins'] == $id){ 
                  ?>
                  <input type="checkbox" name=" <?php echo $valeur['nom'];?>" checked="checked"disabled="disabled">
                  <span class="check"><?php echo $nom; ?></span><br/>

         <?php } ?>

                
            <?php }

            print_r($listeVaccinUser);
            br();
            echo $key;
            br();
            echo $listeVaccinUser[$key]['id_vaccins'];
            br();
            ?>
            
            <?php if ($listeVaccinUser[$counter]['id_vaccins'] != $id){ ?>
            <input type="checkbox" name=" <?php echo $valeur['nom'];?>">
            <span <?php if(!empty($_POST[$nom])){echo 'class="check"';} ?> > <?php echo $nom; ?></span><br/>

            <?php $counter = $counter+1;
            } ?>
           <?php } ?>
    </div>

                <?php
                    if(!empty($_POST['listeRappel']) && !empty($_SESSION['user'])){
                      foreach($_POST as $key=>$valeur){
                        if ($key != 'listeRappel'){
                          ?> <input class="rappel" type="date" name="<?php echo $key?>" value="<?php if(!empty($_POST[$key])){echo $_POST[$key];} ?>" ><span> Date de rappel pour "<?php echo $key ?>"</span><br/> <?php
                          
                        }
                        
                      }
                      
                    }
                    echo '<input type="submit" name="listeRappel" value="confirmer">';
                ?>
      </form>
    

    </div>
    <a class="myButton button"href="profil_edit.php">éditer profil</a>
    <a class="myButton"href="carnet.php">Mon carnet</a>
    <div class="clear"></div>
  </div>
</div>

<div class="clear"></div>
<?php include 'inc/footer.php';
