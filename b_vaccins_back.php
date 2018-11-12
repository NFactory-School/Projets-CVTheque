<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}
// Requete sql pagination
$sql ="SELECT COUNT(*) as nbVaccins
      FROM vax_vaccins";
$query = $pdo -> prepare($sql);
$query -> execute();
$countVaccins = $query -> fetch();

// Variables pagination
$nbVaccins = $countVaccins['nbVaccins'];
$vaccinsParPages = 2;
$nbPages = ceil($nbVaccins/$vaccinsParPages);

if(!empty($_GET['p']) && $_GET['p']>0 && $_GET['p'] <= $nbPages){
  $cPage = $_GET['p'];
}else{
  $cPage = 1;
}

// Requete SQL affichage
$sql = "SELECT * FROM vax_vaccins
        ORDER BY id DESC LIMIT ".(($cPage - 1) * $vaccinsParPages).", $vaccinsParPages";
$query = $pdo -> prepare($sql);
$query -> execute();
$vaccins = $query -> fetchAll();

// liens de pagination
for ($i = 1; $i <=  $nbPages; $i++) {
  if ($i==$cPage) {
    echo $i, '/';
  }else {
    echo ' <a href="b_vaccins_back.php?p='.$i.'">'.$i.'</a>/';
  }
}
?>

<!-- Affichage des vaccins en tableau -->
<table>
  <thead>
    <th>id</th>
    <th>nom du vaccin</th>
    <th>maladie ciblée</th>
    <th>laboratoire de production</th>
    <th>Informations complémentaires</th>
    <th>Supprimer un vaccin</th>
    <th>statut (0 = supprimé, 1 = visible)</th>
  </thead>
  <tbody>
    <?php foreach ($vaccins as $vaccin):?>
      <td><?php echo $vaccin['id'] ?></td>
      <td><?php echo $vaccin['nom'] ?></td>
      <td><?php echo $vaccin['maladie_cible'] ?></td>
      <td><?php echo $vaccin['labo'] ?></td>
      <td><?php echo $vaccin['info'] ?></td>
      <td> <a href="b_rm_vaccin.php?id=<?php echo $vaccin['id'] ?>">Supprimer</a>
           <a href="b_cancel_vaccin.php?id=<?php echo $vaccin['id'] ?>">Annuler</a> </td>
      <td><?php echo $vaccin['status'] ?></td>
    </tbody>
  <?php endforeach; ?>
</table>

<!-- Boutons pratiques -->
<a href="b_add_vaccin.php">Ajouter un vaccin</a>
<a href="b_back.php">Retour à l'accueil</a>

<?php include 'inc/footer.php'; ?>
