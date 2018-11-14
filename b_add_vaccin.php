<?php
include ('inc/pdo.php');
include ('inc/request.php');
include 'inc/fonction.php';
include 'inc/header_back.php';

isAdmin();

if (isLogged()==false){
 header('Location:403.php');
}
// verif soumission
$errors = array();
if(!empty($_POST['submit'])){
  // failles xss
  $nom = trim(strip_tags($_POST['nom']));
  $cible = trim(strip_tags($_POST['cible']));
  $info = trim(strip_tags($_POST['info']));
  $age = $_POST['age'];
    if (!empty($_POST['nom'])) {
      $nomVaccin = b_add_vaccin($nom);
      if(!empty($nomVaccin)){
        $errors['nom'] = "Ce vaccin est déjà présent dans la base de données.";
      }
    }else{
      $errors['nom'] = "Veuillez remplir ce champ";
    }
    if(!empty($_POST['cible'])){
    }else{
      $errors['cible'] = "Veuillez remplir ce champ";
    }
    if(!empty($_POST['age'])){
      if($_POST['age'] < 0 || $_POST['age'] > 1560){
        $errors['age'] = 'Veuillez renseigner un age valide';
      }
    }else{
      $errors['age'] = 'Veuillez renseigner ce champ';
    }


  // si le formulaire ne contient pas d'erreurs
    if(count($errors)==0){
      b_add_vaccin1($nom,$cible,$info,$age);

      header('Location:b_vaccins_back.php');
    }
  }

?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">

      <div class="panel-heading"><h1>Ajouter un vaccin</h1></div>

        <div class="panel-body">
          <div class="row">
            <div class="col-lg-6">

              <form role ="form" class="add-vaccin" action="" method="post">
                <div class="form-group has-success">
                  <label class="control-label" for="nom">Nom du vaccin</label>
                  <input class="form-control" type="text" name="nom" value=""><br/>
                  <span class="error"><?php error($errors,'nom');?></span><?php br(); ?>
                </div>

                <div class="form-group">
                  <label class="control-label" for="cible">Maladie ciblée</label>
                  <input class="form-control" type="text" name="cible" value=""><br/>
                  <span class="error"><?php error($errors,'cible');?></span><?php br(); ?>
                </div>

                <div class="form-group">
                  <label class="control-label" for="info">Informations Complémentaires</label>
                  <input class="form-control" type="text" name="info" value=""><br/>
                  <span class="error"><?php error($errors,'info');?></span><?php br(); ?>
                </div>

                <div class="form-group">
                  <label class="control-label" for="age">Âge de 1e prise recommandé (en mois)</label>
                  <input class="form-control" type="number" name="age" value="" min="0" max="1560">
                  <span class="error"><?php error($errors,'age');?></span><?php br(); ?>
                </div>

                <div class="form-group">
                  <input  class="btn btn-default" type="submit" name="submit" value="Ajouter" onclick="return confirm('Voulez vous vraiment ajouter ce vaccin a la base de données ? Il ne pourra plus être supprimé depuis le back-office">
                </div>
                
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<a href="b_vaccins_back.php"><button type="button" class="btn btn-outline btn-default">Retour</button></a>

<?php include 'inc/footer_back.php'; ?>
