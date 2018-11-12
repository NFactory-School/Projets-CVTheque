<?php include ('inc/pdo.php') ?>
<?php include ('inc/fonction.php') ?>
<?php include ('inc/header.php')  ?>
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
