<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header_back.php';
require 'vendor/autoload.php';
use JasonGrimes\Paginator;

isAdmin();

// Requete pagination vaccins
$totalItems = countSqlColumn('id', 'vax_vaccins');

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

<div id="wrapper">
  <div class="col-lg-6">
    <div class="panel panel-default">

      <div class="panel-heading">
        Profils
      </div>

      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-hover">

            <thead>
              <th>id</th>
              <th>nom du vaccin</th>
              <th>maladie ciblée</th>
              <th>Informations complémentaires</th>
              <th>Âge Recommandé</th>
              <th>Supprimer un vaccin</th>
              <th>Statut</th>
            </thead>

            <tbody>
              <?php foreach ($vaccins as $vaccin):?>
                <tr>

                <td><?php echo $vaccin['id'] ?></td>
                <td><?php echo $vaccin['nom'] ?></td>
                <td><?php echo $vaccin['maladie_cible'] ?></td>
                <td><?php echo $vaccin['info'] ?></td>
                <td><?php echo $vaccin['age_recommande'] ?></td>
                <td> <a class="myButton" href="b_rm_vaccin.php?id=<?php echo $vaccin['id'] ?>"><button type ="button" class="btn btn-danger btn-circle"><i class ="fas fa-eye-slash"></i></button></a>
                     <a class="myButton" href="b_cancel_vaccin.php?id=<?php echo $vaccin['id'] ?>"><button type ="button" class="btn btn-success btn-circle"><i class ="fas fa-eye"></i></button></a> </td>
                <td><?php echo $vaccin['status'] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php echo $paginator ?>
        </div>
      </div>

    </div>
  </div>
</div>

<br><a href="b_add_vaccin.php"><button type="button" class ="btn btn-outline btn-success"> Ajouter un vaccin</button></a>
<br><br/><a href="b_back.php"><button type="button" class="btn btn-outline btn-default">Retour au back-office</button></a>

<?php include 'inc/footer_back.php'; ?>
