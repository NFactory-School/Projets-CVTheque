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

function b_select_vaccin_from_vaccins(){
  global $pdo;
  $sql = "SELECT id, nom FROM vax_vaccins WHERE status = 1";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $vaccinUser = $query -> fetchAll();
  return $vaccinUser;
}

function b_select_vaccinanduser_from_pivot($id){
  global $pdo;
  $sql = "SELECT id_vaccins FROM vax_pivot WHERE id_profil = :id";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':id', $id, PDO::PARAM_INT);
  $query -> execute();
  $vaccinUser = $query -> fetchAll();
  return $vaccinUser;
}

function b_insert_vaccin_from_pivot($tab){
  global $pdo;
  $sql = "INSERT INTO vax_pivot (id_profils, id_vaccins, date, rappel)   VALUES (, , NOW(), )";
  $query = $pdo -> prepare($sql);
  $idUser == $tab['id'];
  $idVaccin == $tab['vaccin'];
  $query -> execute();
  $vaccinUser = $query -> fetchAll();
  return $vaccinUser;
}

function b_insert_vaccin_in_pivot ($id_profil,$id_vaccins){
  global $pdo;
  $sql = "INSERT INTO vax_pivot (id_profil, id_vaccins, date)
          VALUES (:id_profil, :id_vaccins, NOW())";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':id_profil', $id_profil, PDO::PARAM_INT);
  $query -> bindValue(':id_vaccins', $id_vaccins, PDO::PARAM_INT);
  $query -> execute();
}

function b_update_rappel_in_pivot ($id_profil,$id_vaccins,$rappel){
  global $pdo;
  $sql = "INSERT INTO vax_pivot (rappel)
          VALUES (:rappel)";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':rappel', $rappel, PDO::PARAM_STR);
  $query -> execute();
}

function b_add_vaccin1($nom,$cible,$info,$age){
  global $pdo;
  $sql = "INSERT INTO vax_vaccins (nom, maladie_cible, info, age_recommande)
          VALUES (:nom, :cible, :info, :age)";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
  $query -> bindValue(':cible', $cible, PDO::PARAM_STR);
  $query -> bindValue(':info', $info, PDO::PARAM_STR);
  $query -> bindValue(':age', $age, PDO::PARAM_INT);
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
  $sql ="SELECT COUNT(id) FROM vax_profils";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $totalItems = $query -> fetchColumn();
  return $totalItems;
}

function b_back3($offset, $itemsPerPage){
  global $pdo;
  $sql = "SELECT * FROM vax_contact
          ORDER BY statut ASC LIMIT $offset, $itemsPerPage";
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

function b_contact_lu($id){
  global $pdo;
  $sql = "UPDATE vax_contact
          SET statut = 2
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}
function b_contact_nonlu($id){
  global $pdo;
  $sql = "UPDATE vax_contact
          SET statut = 1
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
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

function profil_edit($id, $nom, $prenom, $ddn, $taille, $poids, $sexe, $notif){
  global $pdo;
  $sql = "UPDATE vax_profils
         SET modified_at = NOW(), nom = :nom, prenom = :prenom, ddn = :ddn, sexe = :sexe, taille = :taille, poids = :poids, notif = $notif
         WHERE id = $id";
  $query = $pdo -> prepare($sql);

  $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
  $query -> bindValue(':prenom', $prenom, PDO::PARAM_STR);
  $query -> bindValue(':ddn', $ddn, PDO::PARAM_STR);
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

function b_contact_back($id){
  global $pdo;
  $sql = "SELECT * FROM vax_contact WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $contacts = $query -> fetch();
  return $contacts;
}

function b_deban_user($id){
  global $pdo;
  $sql = "UPDATE vax_profils
          SET status = 'user'
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}

function b_rm_vaccin($id){
  global $pdo;
  $sql = "UPDATE vax_vaccins
          SET status = 2
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}

function b_user_admin($id){
  global $pdo;
  $sql = "UPDATE vax_profils
          SET status = 'admin'
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}

function b_user_back(){
  global $pdo;
  $sql ="SELECT COUNT(*) as nbUsers
        FROM vax_profils";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $countUsers = $query -> fetch();
  return $countUsers;
}

function b_user_back1($cPage, $UsersParPages){
  global $pdo;
  $sql = "SELECT * FROM vax_profils
          ORDER BY id DESC LIMIT ".(($cPage - 1) * $UsersParPages).", $UsersParPages";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $Users = $query -> fetchAll();
  return $Users;
}

function contact($obj, $msg, $name, $mail){
  global $pdo;
  $sql = "INSERT INTO vax_contact (objet, message, nom, mail, created_at, statut)
          VALUES (:obj, :msg, :name, :mail, NOW(), 'non lu')";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':obj', $obj, PDO::PARAM_STR);
  $query -> bindValue(':msg', $msg, PDO::PARAM_STR);
  $query -> bindValue(':name', $name, PDO::PARAM_STR);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> execute();
}

function oublimail($mail){
  global $pdo;
  $sql = "SELECT mail, token FROM vax_profils WHERE mail = :mail";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
  $query -> execute();
  $user = $query -> fetch();
  return $user;
}

function oublimdp($token, $mail){
  global $pdo;
  $sql = "SELECT id FROM vax_profils
          WHERE mail = :mail AND token = :token";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':token', $token);
  $query -> bindValue(':mail', $mail);
  $query -> execute();
  $user = $query -> fetch();
  return $user;
}

function oublimdp1($hash, $token, $userid){
  global $pdo;
  $sql = "UPDATE vax_profils
          SET mdp = :hash, token = :token
          WHERE id = :id";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':hash', $hash);
  $query -> bindValue(':token', $token);
  $query -> bindValue(':id', $userid);
  $query -> execute();
}

function profil($id){
  global $pdo;
  $sql = "SELECT * FROM vax_profils
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $user = $query -> fetch();
  return $user;
}

function allVaccin(){
  global $pdo;
  $sql = "SELECT * FROM vax_profils
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
  $user = $query -> fetch();
  return $user;
}
