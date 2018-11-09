<?php include('../inc/fonction.php');
include('../inc/pdo.php');
//verif admin
isAdmin();


//selectionne tous les films
    $id = $_GET['slug'];
    $sql = "SELECT * FROM movies_full WHERE slug = :id ORDER BY title ASC LIMIT 100";
    $query = $pdo->prepare($sql);
    $query -> bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $films = $query->fetchAll();

//foreach ($is as $i) {
//    if($plus==1){
//        $sql.="OFFSET $i";
//    }
//}


include('inc/header.php'); ?>
<!-- Affiche les info des films -->
<table class="table">
  <thead>
    <tr>
      <th>ID :</th>
      <th>Titre :</th>
      <th>Year :</th>
      <th>Rating :</th>
      <th>Actions :</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($films as $film) { ?>
      <tr>
          <td class="id"><?php echo $film['id']; ?></td>
          <td class="title"><?php echo $film['title']; ?></td>
          <td class="year"><?php echo $film['year']; ?></td>
          <td class="rating"><?php echo $film['rating']; ?></td>
          <td class="actions">
            <a class="look" href="../detail.php?id=<?php echo $film['id']; ?>">Voir sur le site</a>
            <a class="edit" href="editpost.php?id=<?php echo $film['id']; ?>">Modifier</a>
            <a class="delete" href="deletepost.php?id=<?php echo $film['id']; ?>">Effacer</a>
          </td>
       </tr>
    <?php } ?>
    <tr>
      <a href="#">Plus</a>
    </tr>
  </tbody>
</table>

<?php include('../inc/footer.php'); ?>
