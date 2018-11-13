<?php 
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

$errors = array();
$success = false;

if(!empty($_POST['sub'])){

  $nom = trim(strip_tags($_POST['nom']));
  $prenom = trim(strip_tags($_POST['prenom']));
  $ddn = $_POST['jj'].'/'.$_POST['mm'].'/'.$_POST['aaaa'];
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
   vnum($error,$poids,1,500,'poids');



$id = $_SESSION['user']['id'];
   if(count($errors) == 0){
     $success = true;
     $sql = "UPDATE vax_profils
            SET modified_at = NOW(), nom = :nom, prenom = :prenom, ddn = :ddn, sexe = :sexe, taille = :taille, poids = :poids, notif = $notif
            WHERE id = $id";
     $query = $pdo -> prepare($sql);

     $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
     $query -> bindValue(':prenom', $prenom, PDO::PARAM_STR);
     $query -> bindValue(':taille', $taille, PDO::PARAM_INT);
     $query -> bindValue(':poids', $poids, PDO::PARAM_INT);
     $query -> bindValue(':sexe', $sexe, PDO::PARAM_INT);
     $query -> bindValue(':ddn', $ddn, PDO::PARAM_STR);
     $query -> execute();

     $sql = "SELECT * FROM vax_profils
             WHERE  id = $id";
     $query = $pdo -> prepare($sql);
     $query -> execute();
     $user = $query -> fetch();

     $_SESSION['user'] = array(
       'id' => $user['id'],
       'status' => $user['status'],
       'nom' => $user['nom'],
       'prenom' => $user['prenom'],
       'ddn' => $user['ddn'],
       'taille' => $user['taille'],
       'poids' => $user['poids'],
       'notif' => $user['notif'],
       'ip' => $_SERVER['REMOTE_ADDR']
     );
     header('Location:profil.php');
   }
}


 ?>
<form id="profil" action="valide_profil.php?id=<?php echo $_SESSION['user']['id'] ?>" method="post">

    <label for="nom">Votre nom:
    <span class="error"><?php if(!empty($errors['nom'])){echo $errors['nom'];}?></span>
  <input type="text" name="nom" placeholder="nom" value="<?php if(!empty($user['nom'])){echo $user['nom'];} ?>" required="required"></label>

    <label for="prenom">Votre prénom:
    <span class="error"><?php if(!empty($errors['prenom'])){echo $errors['prenom'];}?></span>
  <input type="text" name="prenom" placeholder="prenom" value="<?php if(!empty($user['prenom'])){echo $user['prenom'];} ?>" required="required"><br></label>


    <label for="ddn">Votre date de naissance:
  <input type="date" name="ddn"  value="value="<?php if(!empty($_POST['ddn'])){echo $_POST['ddn'];} ?>"" ><span>
   <br></label>


<label for="sexe">votre sexe:
  <select form="profil" class="select_sexe" name="sexe">
    <option name ="homme" value=1>homme</option>
    <option name ="femme" value=2>femme</option>
    <option name ="autre" value=3 selected>autre</option>
  </select><br></label>

  <label for="taille">Votre taille:  <input type="number" name="taille"> <span>en cm</span></label>
  <br>

    <label for="poids">Votre poids:<input type="number" name="poids"> <span>en kg</span>
  <br>

  <?php
  if(!empty($_POST['taille']) && !empty($_POST['poids'])){
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $imc = $tailles*$taille;
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
