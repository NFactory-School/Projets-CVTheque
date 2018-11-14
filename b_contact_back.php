<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header_back.php';

isAdmin();

if (isLogged()==false){
 header('Location:403.php');
}

$id = $_GET['id'];
$contacts = b_contact_back($id);
?>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-green">

      <div class="panel-heading">
        <ul>
          <li>Message de : <?php echo $contacts['nom'] ?></li>
          <li>Objet : <?php echo $contacts['objet'] ?></li>
          <li>Envoyé le : <?php echo $contacts['created_at'] ?></li>
        </ul>
      </div>

      <div class="panel-body">
        <?php echo $contacts['message'] ?>
      </div>

      <div class="panel-footer">
        <?php echo $contacts['mail'] ?><br/>
        <a href="b_back.php"><button type="button" class="btn btn-outline btn-default">Retour au back-office</button></a>
      </div>

    </div>

  </div>
</div>
<?php
include 'inc/footer_back.php';
