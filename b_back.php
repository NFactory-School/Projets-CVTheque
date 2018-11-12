<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

// Requête count users
$sql = "SELECT COUNT(*)
        FROM vax_profils";
$query = $pdo->prepare($sql);
$query->execute();
$count_users = $query->fetch();

// requête count vaccins
$sql = "SELECT COUNT(*)
        FROM vax_vaccins";
$query = $pdo->prepare($sql);
$query->execute();
$count_vaccins = $query->fetch();

// requête contacts
$sql = "SELECT *
        FROM vax_contact";
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
                                    <div class="huge"><?php echo $count_users['COUNT(*)'] ?></div>
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
  </table>
</div>

<?php  include 'inc/footer.php';
