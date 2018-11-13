<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/header.php';
require 'vendor/autoload.php';
use JasonGrimes\Paginator;

if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

// Requete pagination vaccins
$sql ="SELECT COUNT(id) FROM vax_vaccins";
$query = $pdo -> prepare($sql);
$query -> execute();
$totalItems = $query -> fetchColumn();

// Définition des variables
$itemsPerPage = 4;
$currentPage = 1;
$urlPattern = '?page=(:num)';
$offset = 0;
if(!empty($_GET['page']) && is_numeric($_GET['page'])){
  $currentPage = $_GET['page'];
  $offset = $currentPage * $itemsPerPage - $itemsPerPage;
}
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

// Requete SQL affichage
$sql = "SELECT * FROM vax_vaccins
        ORDER BY id DESC LIMIT $offset, $itemsPerPage";
$query = $pdo -> prepare($sql);
$query -> execute();
$vaccins = $query -> fetchAll();
?>

<table>
  <thead>
    <th>id</th>
    <th>nom du vaccin</th>
    <th>maladie ciblée</th>
    <th>Informations complémentaires</th>
    <th>Âge Recommandé</th>
    <th>Supprimer un vaccin</th>
    <th>statut (0 = supprimé, 1 = visible)</th>
  </thead>
  <tbody>
    <?php foreach ($vaccins as $vaccin):?>
      <td><?php echo $vaccin['id'] ?></td>
      <td><?php echo $vaccin['nom'] ?></td>
      <td><?php echo $vaccin['maladie_cible'] ?></td>
      <td><?php echo $vaccin['info'] ?></td>
      <td><?php echo $vaccin['age_recommande'] ?></td>
      <td> <a class="myButton" href="b_rm_vaccin.php?id=<?php echo $vaccin['id'] ?>">Supprimer</a>
           <a class="myButton" href="b_cancel_vaccin.php?id=<?php echo $vaccin['id'] ?>">Annuler</a> </td>
      <td><?php echo $vaccin['status'] ?></td>
    </tbody>
  <?php endforeach; ?>
</table>

<?php echo $paginator ?>

<br><a href="b_add_vaccin.php">Ajouter un vaccin</a>
<br><a href="b_back.php">Retour à l'accueil</a>

<?php include 'inc/footer.php'; ?>
