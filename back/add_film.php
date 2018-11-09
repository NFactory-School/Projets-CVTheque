<?php include('../inc/fonction.php');

isAdmin();

//compte les films
$sql = "SELECT COUNT(films) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$count_films = $query->fetch();
//compte les users
$sql = "SELECT COUNT(users) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$count_users = $query->fetch();
//prend les 30 meilleurs films
$sql = "SELECT nb_add FROM movies_full ORDER BY nb_add DESC LIMIT 30";
$query = $pdo->prepare($sql);
$query->execute();
$best_films = $query->fetchAll();


include('inc/header.php'); ?>
<!-- Affiche les stats à l'Admin -->
<table class="table">
  <thead>
    <tr>
      <th>ID :</th>
      <th>Titre :</th>
      <th>Year :</th>
      <th>Rating :</th>
      <th>Action :</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($articles as $article) { ?>
      <tr>
          <td><a href="single.php?id=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a></td>
          <td><?php echo substr($article['content'],0,70); ?> [...].</td>
          <td><?php echo $article['auteur']; ?></td>
          <td>
            <a href="editpost.php?id=<?php echo $article['id']; ?>">Edit</a>
            <a href="deletepost.php?id=<?php echo $article['id']; ?>">Delete</a>
          </td>
       </tr>
    <?php } ?>
  </tbody>
</table>

<?php include('../inc/footer.php'); ?>
