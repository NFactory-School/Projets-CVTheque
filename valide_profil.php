<?php include ('inc/pdo.php') ;
      include ('inc/fonction.php') ;

$errors = array();
$success = false;

if(!empty($_POST['sub'])){

  $nom = trim(strip_tags($_POST['nom']));
  $prenom = trim(strip_tags($_POST['prenom']));
  $ddn = $_POST['ddn'];
  $sexe = $_POST['sexe'];
  $poids = trim(strip_tags($_POST['poids']));
  $taille = trim(strip_tags($_POST['taille']));
  if(!empty($_POST['notif'])){
    $notif = 1;
  }else{
    $notif = 2;
  }

tab($_POST);
tab($_SESSION);
   vTxt($errors,$nom,3,100,'nom',$empty = true);
   vTxt($errors,$prenom,3,100,'prenom',$empty = true);

$id = $_SESSION['user']['id'];
   if(count($errors) == 0){
     $success = true;
     $sql = "UPDATE vax_profils
            SET modified_at = NOW(), nom = :nom, prenom = :prenom, ddn = $ddn, sexe = $sexe, taille = :taille, poids = :poids, notif = $notif
            WHERE id = $id";
     $query = $pdo -> prepare($sql);
     $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
     $query -> bindValue(':prenom', $prenom, PDO::PARAM_STR);
     $query -> bindValue(':taille', $taille, PDO::PARAM_INT);
     $query -> bindValue(':poids', $poids, PDO::PARAM_INT);
     $query -> execute();

     $sql = "SELECT * FROM vax_profils
             WHERE  id = $id";
     $query = $pdo -> prepare($sql);
     $query -> execute();
     $user = $query -> fetch();

     $_SESSION['user'] = array(
       'id' => $user['id'],
       'status' => $user['status'],
       'ip' => $_SERVER['REMOTE_ADDR'],
       'nom' => $user['nom'],
       'prenom' => $user['prenom'],
       'ddn' => $user['ddn'],
       'taille' => $user['taille'],
       'poids' => $user['poids'],
       'notif' => $user['notif']
     );
     header('Location:profil.php');
   }
}
