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

// Requete pagination contacts
$sql ="SELECT COUNT(*) as nbContact
      FROM vax_contact";
$query = $pdo -> prepare($sql);
$query -> execute();
$countMsg = $query -> fetch();

// Variables pagination
$nbContact = $countMsg['nbContact'];
$msgParPages = 4;
$nbPages = ceil($nbContact/$msgParPages);

if(!empty($_GET['p']) && $_GET['p']>0 && $_GET['p'] <= $nbPages){
  $cPage = $_GET['p'];
}else{
  $cPage = 1;
}

// requête affichage contacts
$sql = "SELECT * FROM vax_contact
        ORDER BY id DESC LIMIT ".(($cPage - 1) * $msgParPages).", $msgParPages";
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
                        <a class="myButton" href="b_user_back.php">
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
                        <a class="myButton" href="b_vaccins_back.php">
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

<?php
// liens de pagination
for ($i = 1; $i <=  $nbPages; $i++) {
  if ($i==$cPage) {
    echo $i, '/';
  }else {
    echo ' <a href="b_back.php?p='.$i.'">'.$i.'</a>/';
  }
}
include 'inc/footer.php';
