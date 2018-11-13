<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';
require 'vendor/autoload.php';
use JasonGrimes\Paginator;

if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
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
        ORDER BY id DESC LIMIT $offset, $itemsPerPage";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $contacts = $query -> fetchAll();


?>

<!-- Boite nbre users -->
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
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

<!-- boite nbre vaccins -->
<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-hospital-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count_vaccins['COUNT(*)'] ?></div>
                                    <div>Vaccins</div>
                                </div>
                            </div>
                        </div>
                        <a href="b_vaccins_back.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

<!-- listing contacts -->
<div class="back_contacts">
  <?php
  echo '<table>
    <thead>
      <th>nom</th>
      <th>objet</th>
      <th>date de création</th>
    </thead>';
      foreach($contacts as $contact){
        $id = $contact['id'];
        echo '<tbody>
                <td><a href="b_contact_back.php?id='.$id.'">'.$contact['nom'].'</a></td>
                <td>'.$contact['objet'].'</td>
                <td>'.$contact['created_at'].'</td>
              </tbody>';}?>
  <br/>
  <?php echo $paginator; ?>
  </table>
</div>

<?php
include 'inc/footer.php';
