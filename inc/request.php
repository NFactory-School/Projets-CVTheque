<?php
// Functions basics
function basic_where_STR($value, $key, $bdd){
  global $pdo;
  $sql = "SELECT * FROM $bdd WHERE $key = :$key";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':'.$key, $value, PDO::PARAM_STR);
  $query -> execute();
  $return = $query -> fetch();
  return $return;
}

function basic_where_ID($value, $key, $bdd, $select){
  global $pdo;
  $sql = "SELECT $select FROM $bdd WHERE $key = :$key";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':'.$key, $value, PDO::PARAM_INT);
  $query -> execute();
  $return = $query -> fetch();
  return $return;
}

function basic_where_ID_Complexe($id, $where, $to, $value, $bdd){
  global $pdo;
  $sql = "SELECT $value$where FROM $bdd WHERE $value$to = :$value";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':'.$value, $id, PDO::PARAM_INT);
  $query -> execute();
  $return = $query -> fetch();
  return $return;
}

function countSql($value, $bdd){
  global $pdo;
  $sql = "SELECT COUNT($value)
          FROM $bdd";
  $query = $pdo->prepare($sql);
  $query->execute();
  $count = $query->fetch();
  return $count;
}

function countSqlColumn($value, $bdd){
  global $pdo;
  $sql = "SELECT COUNT($value)
          FROM $bdd";
  $query = $pdo->prepare($sql);
  $query->execute();
  $count = $query->fetchColumn();
  return $count;
}

function set_statut($id, $value, $bdd){
  global $pdo;
  $sql = "UPDATE $bdd
          SET status = '$value'
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
}

function contact_statut($id, $statut){
  global $pdo;
  $sql = "UPDATE vax_contact
          SET statut = $statut
          WHERE id = $id";
  $query = $pdo -> prepare($sql);
  $query -> execute();
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

function b_select_nom_from_pivot($id){
  global $pdo;
  $sql = "SELECT nom, rappel FROM vax_vaccins INNER JOIN vax_pivot ON vax_vaccins.id = vax_pivot.id_vaccins WHERE id_profil = :id";
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
  $sql = "UPDATE vax_pivot SET rappel = :rappel WHERE id_profil = :id_profil AND id_vaccins = :id_vaccins";
  $query = $pdo -> prepare($sql);
  $query -> bindValue(':id_profil', $id_profil, PDO::PARAM_INT);
  $query -> bindValue(':id_vaccins', $id_vaccins, PDO::PARAM_INT);
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

function b_back1($offset, $itemsPerPage){
  global $pdo;
  $sql = "SELECT * FROM vax_contact
          ORDER BY statut ASC LIMIT $offset, $itemsPerPage";
    $query = $pdo -> prepare($sql);
    $query -> execute();
    $contacts = $query -> fetchAll();
  return $contacts;
}

function b_vaccins_back($offset, $itemsPerPage){
  global $pdo;
  $sql = "SELECT * FROM vax_vaccins
          ORDER BY id DESC LIMIT $offset, $itemsPerPage";
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

function profil_edit1($id, $nom, $prenom, $taille, $poids, $sexe, $notif){
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
