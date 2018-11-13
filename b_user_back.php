<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';
if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}

// Requete sql pagination
$countUsers = b_user_back();

// Variables pagination
$nbUsers = $countUsers['nbUsers'];
$UsersParPages = 4;
$nbPages = ceil($nbUsers/$UsersParPages);

if(!empty($_GET['p']) && $_GET['p']>0 && $_GET['p'] <= $nbPages){
  $cPage = $_GET['p'];
}else{
  $cPage = 1;
}

// Requete d'affichage
$Users = b_user_back1($cPage, $UsersParPages);

?>

<table>
  <thead>
    <th>Id</th>
    <th>Mail</th>
    <th>Date de création</th>
    <th>Dernière modification</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Date de naissance</th>
    <th>Sexe</th>
    <th>Taille</th>
    <th>Poids</th>
    <th>Notifications</th>
    <th>Statut</th>
    <th> Modifier un statut utilisateur </th>
  </thead>
  <?php foreach ($Users as $User):?>
    <tbody>
      <td><?php echo $User['id'] ?></td>
      <td><?php echo $User['mail']?></td>
      <td><?php echo $User['created_at']?></td>
      <td><?php echo $User['modified_at']?></td>
      <td><?php echo $User['nom']?></td>
      <td><?php echo $User['prenom']?></td>
      <td><?php echo $User['ddn']?></td>
      <td><?php echo $User['sexe']?></td>
      <td><?php echo $User['taille']?></td>
      <td><?php echo $User['poids']?></td>
      <td><?php echo $User['notif']?></td>
      <td><?php echo $User['status']?></td>
      <td><a href="b_ban_user.php?id=<?php echo $User['id'] ?>">Banni</a>
          <a href="b_deban_user.php?id=<?php echo $User['id'] ?>">Utilisateur</a>
          <a href="b_user_admin.php?id=<?php echo $User['id'] ?>">Administrateur</a> </td>
    </tbody>
  <?php endforeach; ?>
</table>

<?php
// liens de pagination
for ($i = 1; $i <=  $nbPages; $i++) {
  if ($i==$cPage) {
    echo $i, '/';
  }else {
    echo ' <a href="b_user_back.php?p='.$i.'">'.$i.'</a>/';
  }
}?>

<br/><a class="myButton" href="b_back.php">Retour au back-office</a>

<?php include 'inc/footer.php';
