<?php include('../inc/fonction.php');
include('../inc/pdo.php');
//verif admin
isAdmin();


//selectionne tous les users
$id = $_GET['slug'];
$sql = "SELECT * FROM nf_user WHERE slug = :id ORDER BY name ASC";
$query = $pdo->prepare($sql);
$query -> bindValue(':id', $id, PDO::PARAM_STR);
$query->execute();
$users = $query->fetchAll();


include('inc/header.php'); ?>
<!-- Affiche les info des films -->
<table class="table">
  <thead>
    <tr>
      <th>ID :</th>
      <th>Email :</th>
      <th>Nom :</th>
      <th>Token :</th>
      <th>Actions :</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user) { ?>
      <tr>
          <td class="id"><?php echo $user['id']; ?></td>
          <td class="email"><?php echo $user['email']; ?></td>
          <td class="nom"><?php echo $user['nom']; ?></td>
          <td class="token"><?php echo $user['token']; ?></td>
          <td class="actions">
            <a class="edit" href="edituser.php?id=<?php echo $user['id']; ?>">Modifier</a>
            <a class="delete" href="deleteuser.php?id=<?php echo $user['id']; ?>">Effacer</a>
          </td>
       </tr>
    <?php } ?>
  </tbody>
</table>

<?php include('../inc/footer.php'); ?>
