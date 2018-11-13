<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';
if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}
$id = $_GET['id'];
$contacts = b_contact_back($id);

?>

<div class="titre">
  <ul>
    <li>Message de : <?php echo $contacts['nom'] ?></li>
    <li>Objet : <?php echo $contacts['objet'] ?></li>
    <li>Envoyé le : <?php echo $contacts['created_at'] ?></li>
  </ul>
</div>
<div class="message">
  <ul>
    <li><?php echo $contacts['message'] ?></li>
    <li><?php echo $contacts['mail'] ?></li>
  </ul>
</div>
<a href="b_back.php">Retour au back-office</a>

<?php
include 'inc/footer.php';
