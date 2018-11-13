<?php

function b_add_vaccin($nom){
  global $pdo;
  $sql = "SELECT nom FROM vax_vaccins WHERE nom = :nom";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
  $query -> execute();
  $nomVaccin = $query -> fetch();
  return $nomVaccin;
}

function b_select_vaccin_from_user($id){
  global $pdo;
  $sql = "SELECT id_vaccins FROM vax_pivot WHERE id_profil = :id";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':id', $id, PDO::PARAM_INT);
  $query -> execute();
  $vaccinUser = $query -> fetch();
  return $vaccinUser;
}

function b_add_vaccin1($nom,$cible,$info,$age){
  global $pdo;
  $sql = "INSERT INTO vax_vaccins(nom, maladie_cible, info, age_recommande)
          VALUES (:nom, :cible, :info, :age)";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
  $query -> bindValue(':cible', $cible, PDO::PARAM_STR);
  $query -> bindValue(':info', $info, PDO::PARAM_STR);
  $query -> bindValue(':age', $age, PDO::PARAM_STR);
  $query -> execute();
}

function index($mail){
  global $pdo;
  $sql = "SELECT mail FROM vax_profils WHERE mail = :mail";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> execute();
  $userMail = $query -> fetch();
  return $userMail;
}

function index1($mail, $token, $hash){
  global $pdo;
  $sql = "INSERT INTO vax_profils ( mail, mdp , created_at,token,status)
          VALUES ( :mail, :hash, NOW(), :token,'user')";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> bindValue(':token', $token, PDO::PARAM_STR);
  $query -> bindValue(':hash', $hash, PDO::PARAM_STR);
  $query -> execute();
}

function index2($mail){
  global $pdo;
  $sql = "SELECT * FROM vax_profils
          WHERE mail = :mail";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> execute();
  $user = $query -> fetch();
  return $user;
}

function b_back(){
  global $pdo;
  $sql = "SELECT COUNT(*)
          FROM vax_profils";
  $query = $pdo->prepare($sql);
  $query->execute();
  $count_users = $query->fetch();
  return $count_users;
}

function b_back1(){
  global $pdo;
  $sql = "SELECT COUNT(*)
          FROM vax_vaccins";
  $query = $pdo->prepare($sql);
  $query->execute();
  $count_vaccins = $query->fetch();
  return $count_vaccins;
}

function b_back2(){
  global $pdo;
  $sql ="SELECT COUNT(*) as nbContact
        FROM vax_contact";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $countMsg = $query -> fetch();
  return $countMsg;
}

function b_back3($cPage, $msgParPages){
  global $pdo;
  $sql = "SELECT * FROM vax_contact
          ORDER BY id DESC LIMIT ".(($cPage - 1) * $msgParPages).", $msgParPages";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $contacts = $query -> fetchAll();
  return $contacts;
}

function b_ban_user($id){
  global $pdo;
  $sql = "UPDATE vax_profils
          SET status = 'banni'
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}

function b_cancel_vaccin($id){
  global $pdo;
  $sql = "UPDATE vax_vaccins
          SET status = '1'
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}

function b_vaccins_back(){
  global $pdo;
  $sql ="SELECT COUNT(*) as nbVaccins
        FROM vax_vaccins";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $countVaccins = $query -> fetch();
  return $countVaccins;
}

function b_vaccins_back1($cPage, $vaccinsParPages){
  global $pdo;
  $sql = "SELECT * FROM vax_vaccins
          ORDER BY id DESC LIMIT ".(($cPage - 1) * $vaccinsParPages).", $vaccinsParPages";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $vaccins = $query -> fetchAll();
  return $vaccins;
}

function profil_edit($id, $nom, $prenom, $taille, $poids, $sexe){
  global $pdo;
  $sql = "UPDATE vax_profils
         SET modified_at = NOW(), nom = :nom, prenom = :prenom, sexe = :sexe, taille = :taille, poids = :poids, notif = $notif
         WHERE id = $id";
  $query = $pdo -> prepare($sql);

  $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
  $query -> bindValue(':prenom', $prenom, PDO::PARAM_STR);
  $query -> bindValue(':taille', $taille, PDO::PARAM_INT);
  $query -> bindValue(':poids', $poids, PDO::PARAM_INT);
  $query -> bindValue(':sexe', $sexe, PDO::PARAM_INT);
  $query -> execute();
}

function profil_edit1($id){
  global $pdo;
  $sql = "SELECT * FROM vax_profils
          WHERE  id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $user = $query -> fetch();
  return $user;
}
