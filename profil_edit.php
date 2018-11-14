
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
<<<<<<< HEAD
  $ddn = $_POST['ddn'];

=======
  $ddn =$_POST['ddn'];
>>>>>>> e7a39b836c2505d9a5ab5ddba54096f9c289f431
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



$id = $_SESSION['user']['id'];
   if(count($errors) == 0){
     $success = true;

    profil_edit($id, $nom, $prenom, $ddn, $taille, $poids, $sexe, $notif);


    $user = profil_edit1($id);


     tab($_SESSION);
     $_SESSION['user']['nom'] = $user['nom'];
     $_SESSION['user']['prenom'] = $user['prenom'];
     $_SESSION['user']['ddn'] = $user['ddn'];
     $_SESSION['user']['taille'] = $user['taille'];
     $_SESSION['user']['poids'] = $user['poids'];
     $_SESSION['user']['notif'] = $user['notif'];
     header('Location:profil.php');
   }
}


 ?>
<form id="profil" action="profil_edit.php?id=<?php echo $_SESSION['user']['id'] ?>" method="post">

    <label for="nom">Votre nom:
    <span class="error"><?php if(!empty($errors['nom'])){echo $errors['nom'];}?></span>
  <input type="text" name="nom" placeholder="nom" value="<?php if(!empty($_SESSION['user']['nom'])){echo $_SESSION['user']['nom'];} ?>" ></label>

    <label for="prenom">Votre prénom:
    <span class="error"><?php if(!empty($errors['prenom'])){echo $errors['prenom'];}?></span>
  <input type="text" name="prenom" placeholder="prenom" value="<?php if(!empty($_SESSION['user']['prenom'])){echo $_SESSION['user']['prenom'];} ?>"><br></label>


    <label for="ddn">Votre date de naissance:
  <input type="date" name="ddn"  value="<?php if(!empty($_SESSION['user']['ddn'])){echo $_SESSION['user']['ddn'];} ?>"><span>
   <br></label>


<label for="sexe">votre sexe:
  <select form="profil" class="select_sexe" name="sexe">
    <option name ="homme" value=1>homme</option>
    <option name ="femme" value=2>femme</option>
    <option name ="autre" value=3 selected>autre</option>
  </select><br></label>

  <label for="taille">Votre taille:  <input type="number" name="taille" value="<?php if(!empty($_SESSION['user']['taille'])){echo $_SESSION['user']['taille'];} ?>"> <span>en cm</span></label>
  <br>

    <label for="poids">Votre poids:<input type="number" name="poids" value="<?php if(!empty($_SESSION['user']['poids'])){echo $_SESSION['user']['poids'];} ?>"> <span>en kg</span>
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




<?php include ('inc/footer.php') ?>
