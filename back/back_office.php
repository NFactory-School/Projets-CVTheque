<?php include('../inc/fonction.php');
include('../inc/pdo.php');
//verif admin
isAdmin();

//compte les films
$sql = "SELECT COUNT(title) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$count_films = $query->fetch();
//compte les users
$sql = "SELECT COUNT(pseudo) FROM nf_user";
$query = $pdo->prepare($sql);
$query->execute();
$count_users = $query->fetch();
//prend les 30 meilleurs films
//$sql = "SELECT nb_add FROM movies_full ORDER BY nb_add DESC LIMIT 30";
//$query = $pdo->prepare($sql);
//$query->execute();
//$best_films = $query->fetchAll();


include('inc/header.php'); ?>
<!-- Affiche les stats à l'Admin -->
<p class="stats"><h2>Le nombre de films dans votre site est de :<?php echo $count_films['COUNT(title)'] ?></h2><br/>
<h2>Le nombre d'utilisateurs dans votre site est de :<?php echo $count_users['COUNT(pseudo)'] ?></h2><br/>
<!--<h2>Les 30 meilleurs films sont :<?php// echo $best_films['nb_add'] ?></h2></p>-->

<p><a href="aff_film.php">Consultation de films</a></p>
<p><a href="inc/add_film.php">Ajout d'un film</a></p>
<p><a href="inc/aff_user.php">Consultation d'utilisateurs'</a></p>

<?php include('../inc/footer.php');
