<?php include ('pdo.php');

function b_add_vaccin(){
$sql = "SELECT nom FROM vax_vaccins WHERE nom = :nom";
$query = $pdo -> prepare($sql);
$query -> bindValue(':nom', $nom, PDO::PARAM_STR);
$query -> execute();
$nomVaccin = $query -> fetch();
}

function b_add_vaccin1(){
  $sql = "INSERT INTO vax_vaccins(nom, maladie_cible, labo, info)
          VALUES (:nom, :cible, :labo, :info)";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
  $query -> bindValue(':cible', $cible, PDO::PARAM_STR);
  $query -> bindValue(':labo', $labo, PDO::PARAM_STR);
  $query -> bindValue(':info', $info, PDO::PARAM_STR);
  $query -> execute();
}

function connection(){
  $sql = "SELECT * FROM vax_profils
          WHERE  mail = :mail";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> execute();
  $user = $query -> fetch();
}
