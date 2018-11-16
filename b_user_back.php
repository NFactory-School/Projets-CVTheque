<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header_back.php';
require 'vendor/autoload.php';
use JasonGrimes\Paginator;

isAdmin();

if (isLogged()==false){
 header('Location:403.php');
}

// Requete pagination user
$sql ="SELECT COUNT(id) FROM vax_profils";
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

// Requete d'affichage
$sql = "SELECT * FROM vax_profils
        ORDER BY id DESC LIMIT $offset, $itemsPerPage";
$query = $pdo -> prepare($sql);
$query -> execute();
$Users = $query -> fetchAll();
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
              <th>Id</th>
              <th>Mail</th>
              <th>Date de création</th>
              <th>Dernière modification</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Sexe</th>
              <th>Notifications</th>
              <th>Statut</th>
              <th> Modifier un statut utilisateur </th>
            </thead>

            <tbody>
              <?php foreach ($Users as $User):?>
              <tr>
                  <td><?php echo $User['id'] ?></td>
                  <td><?php echo $User['mail']?></td>
                  <td><?php echo $User['created_at']?></td>
                  <td><?php echo $User['modified_at']?></td>
                  <td><?php echo $User['nom']?></td>
                  <td><?php echo $User['prenom']?></td>
                  <td><?php echo $User['sexe']?></td>
                  <td><?php echo $User['notif']?></td>
                  <td><?php echo $User['status']?></td>
                  <td><a href="b_ban_user.php?id=<?php echo $User['id'] ?>"><button type ="button" class="btn btn-danger btn-circle"> <i class="fas fa-user-slash"></i> </button></a>
                      <a href="b_deban_user.php?id=<?php echo $User['id'] ?>"><button type ="button" class="btn btn-info btn-circle"> <i class="fas fa-user"></i> </button></a>
                      <a href="b_user_admin.php?id=<?php echo $User['id'] ?>"><button type ="button" class="btn btn-warning btn-circle"> <i class="	fas fa-user-secret"></i> </button></a> </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <?php echo $paginator ?>

          <br/><a class="myButton" href="b_back.php"><button type="button" class="btn btn-outline btn-default">Retour au back-office</button></a>

        </div>
      </div>

    </div>
  </div>
</div>


<?php include 'inc/footer_back.php';
