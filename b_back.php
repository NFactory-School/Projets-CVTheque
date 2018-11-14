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

// Requête count contacts
$sql = "SELECT COUNT(*) FROM vax_contact";
$query = $pdo->prepare($sql);
$query->execute();
$count_users = $query->fetchColumn();

// requête count vaccins
$count_vaccins = b_back1();

// Requete pagination contacts
$sql ="SELECT COUNT(id) FROM vax_contact";
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

// requête affichage contacts
$sql = "SELECT * FROM vax_contact
        ORDER BY statut ASC LIMIT $offset, $itemsPerPage";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $contacts = $query -> fetchAll();
?>

<div id="wrapper">

  <!-- Boite nbre users -->
  <div class="panel-body">
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">

            <div class="col-xs-3">
              <i class="fa fa-user fa-5x"></i>
            </div>

            <div class="col-xs-9 text-right">
              <div class="huge"><?php echo $count_users ?></div>
              <div>Utilisateurs</div>
            </div>

          </div>
        </div>

          <a href="b_user_back.php">
            <div class="panel-footer">
              <span class="pull-left">Détails</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
            </div>
          </a>

        </div>
      </div>

  <!-- boite nbre vaccins -->
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-green">
        <div class="panel-heading">
          <div class="row">

            <div class="col-xs-3">
              <i class="fas fa-medkit fa-5x"></i>
            </div>

              <div class="col-xs-9 text-right">
                <div class="huge"><?php echo $count_vaccins['COUNT(*)'] ?></div>
                <div>Vaccins</div>
              </div>

          </div>
        </div>

          <a href="b_vaccins_back.php">
            <div class="panel-footer">
              <span class="pull-left">Détails</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>

      </div>
    </div>
  </div>

<!-- listing contacts -->
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body">
        <h1>Messages Recus ( <?php echo $totalItems ?> Messages)</h1>
        <div class="table-responsive">
          <table class="table table-hover">

            <thead>
              <tr>
                <th>nom</th>
                <th>objet</th>
                <th>date de création</th>
                <th>Marquer comme lu</th>
                <th>statut</th>
              </tr>
            </thead>


              <tbody>
                <tr>
                  <?php foreach($contacts as $contact){
                    $id = $contact['id'];?>
                  <td><a href="b_contact_back.php?id=<?php echo $id ?>"><?php echo $contact['nom'] ?></a></td>
                  <td><?php echo $contact['objet'] ?> </td>
                  <td><?php echo $contact['created_at'] ?></td>
                  <td><a href="b_contact_lu.php?id=<?php echo $contact['id'] ?>"><button type="button" class="btn btn-primary btn-circle btn-lg"> <i class ="far fa-envelope-open"></i></button></a>
                    <a href="b_contact_nonlu.php?id=<?php echo $contact['id'] ?>"><button type="button" class="btn btn-danger btn-circle btn-lg"> <i class="far fa-envelope"></i> </button></a></td>
                    <td><?php if ($contact['statut'] == 'non lu') { ?>
                      <i class ="far fa-envelope"></i>
                    <?php  }else{ ?>
                      <i class="far fa-envelope-open"></i>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>

          </table>
          <?php echo $paginator ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include 'inc/footer_back.php';
