
<?php include 'inc/pdo.php';
include 'inc/request.php';
 include 'inc/fonction.php';
 include 'inc/header.php';

 if (isLogged()==false){
  header('Location:403.php');
 }

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

$errors = array();
$success = false;

if(!empty($_POST['sub'])){

  $nom = trim(strip_tags($_POST['nom']));
  $prenom = trim(strip_tags($_POST['prenom']));


  $ddn = $_POST['ddn'];

  $sexe = $_POST['sexe'];
  $poids = trim(strip_tags($_POST['poids']));
  $taille = trim(strip_tags($_POST['taille']));
  if(!empty($_POST['notif'])){
    $notif = 1;
  }else{
    $notif = 2;
  }




   vTxt($errors,$nom,3,100,'nom',$empty = true);
   vTxt($errors,$prenom,3,100,'prenom',$empty = true);
   vnum($errors,$poids,1,500,'poids');
   vnum($errors,$taille,1,500,'taille');



$id = $_SESSION['user']['id'];
   if(count($errors) == 0){
    echo $_POST['sexe'];
     $success = true;

     if (empty($_SESSION['user']['ddn'])){
       profil_edit($id, $nom, $prenom, $ddn, $taille, $poids, $sexe, $notif);
     }

      profil_edit1($id, $nom, $prenom, $taille, $poids, $sexe, $notif);

     header('Location:profil.php');
   }
}


 ?>




<div class="bigcontainer">
  <div class="form-container2">

    <form class="profil-form" action="profil_edit.php?id=<?php echo $_SESSION['user']['id'] ?>" method="post">

        <label for="nom">Votre nom:
        <span class="error"><?php if(!empty($errors['nom'])){echo $errors['nom'];}?></span>
      <input type="text" name="nom" placeholder="Votre nom" value="<?php if(!empty($_SESSION['user']['nom'])){echo $_SESSION['user']['nom'];} ?>" ></label>

        <label for="prenom">Votre prénom:
        <span class="error"><?php if(!empty($errors['prenom'])){echo $errors['prenom'];}?></span>
      <input type="text" name="prenom" placeholder="Votre prénom" value="<?php if(!empty($_SESSION['user']['prenom'])){echo $_SESSION['user']['prenom'];} ?>"><br></label>

      <?php if (empty($_SESSION['user']['ddn'])){ ?>
        <label for="ddn">Votre date de naissance:
      <input type="date" name="ddn"  value="<?php if(!empty($_SESSION['user']['ddn'])){echo $_SESSION['user']['ddn'];} ?>"><span>
       <br></label>
     <?php }?>

    <label for="sexe">votre sexe:
      <select class="select_sexe" name="sexe">
        <option value=1>homme</option>
        <option value=2>femme</option>
        <option value=3 selected>autre</option>
      </select><br></label>

      <label for="taille">Votre taille (en cm) : <input type="number" name="taille" value="<?php if(!empty($_SESSION['user']['taille'])){echo $_SESSION['user']['taille'];} ?>"></label>
      <br>

        <label for="poids">Votre poids (en kg) : <input type="number" name="poids" value="<?php if(!empty($_SESSION['user']['poids'])){echo $_SESSION['user']['poids'];} ?>"></label>
      <br>

      <?php
      if(!empty($_POST['taille']) && !empty($_POST['poids'])){
        $taille = $_POST['taille'];
        $poids = $_POST['poids'];
        $imc = $taille*$taille;
        $imc = $poids/$imc;

        if ($imc<20){
          $resultimc = 0;
        }
      }
      ?>

        <input type="checkbox" name="notif" value="notif" checked><span>Voulez vous recevoir les notifications </span><br>

        <input type="submit" name="sub" value="Confirmer">

    </form>
  </div>

  <div class="minislider2">
    <p><span class="bolder">Plus qu'un carnet de vaccination en ligne, </span>VAX est capable de calculer votre IMC et de vous donner la date de vos prochains vaccins et rappels en temps réel, quel que soit votre physionomie</p>
    <p><span class="bolder">Nous avons besoin de ces informations </span> afin d'alimenter notre algorithme et de vous tenir au courant de vos prochains rappels les plus urgents !</p>
    <p><span class="bolder">Utiliser VAX : </span>c'est être en permanence à jour sur ses vaccins et ce, sur tout le territoire francais, quelle que soit votre tranche d'âge.</p>
  </div>
</div>





<?php include ('inc/footer.php') ?>
