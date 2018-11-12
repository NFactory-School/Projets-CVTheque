<?php include ('inc/pdo.php') ;
      include ('inc/fonction.php') ;

$errors = array();
$success = false;

if(!empty($_POST['sub'])){

  $nom = trim(strip_tags($_POST['nom']));
  $prenom = trim(strip_tags($_POST['prenom']));
  $ddn = $_POST['jj'].'/'.$_POST['mm'].'/'.$_POST['aaaa'];
  $sexe = $_POST['sexe'];
  $poids = trim(strip_tags($_POST['poids']));
  $taille = trim(strip_tags($_POST['taille']));
  if(!empty($_POST['notif'])){
    $notif = 1;
  }else{
    $notif = 2;
  }


$jj=$_POST['jj'];
$mm=$_POST['mm'];
$aaaa=$_POST['aaaa'];

   vTxt($errors,$nom,3,100,'nom',$empty = true);
   vTxt($errors,$prenom,3,100,'prenom',$empty = true);
   vnum($error,$jj,1,31,'jj');
   vnum($error,$mm,1,12,'mm');
   vnum($error,$aaaa,1900,date('Y'),'aaaa');

$id = $_SESSION['user']['id'];
   if(count($errors) == 0){
     $success = true;
     $sql = "UPDATE vax_profils
            SET modified_at = NOW(), nom = :nom, prenom = :prenom, ddn = :ddn, sexe = :sexe, taille = :taille, poids = :poids, notif = $notif
            WHERE id = $id";
     $query = $pdo -> prepare($sql);

     $query -> bindValue(':nom', $nom, PDO::PARAM_STR);
     $query -> bindValue(':prenom', $prenom, PDO::PARAM_STR);
     $query -> bindValue(':taille', $taille, PDO::PARAM_INT);
     $query -> bindValue(':poids', $poids, PDO::PARAM_INT);
     $query -> bindValue(':sexe', $sexe, PDO::PARAM_INT);
     $query -> bindValue(':ddn', $ddn, PDO::PARAM_STR);
     $query -> execute();

     $sql = "SELECT * FROM vax_profils
             WHERE  id = $id";
     $query = $pdo -> prepare($sql);
     $query -> execute();
     $user = $query -> fetch();

     $_SESSION['user'] = array(
       'id' => $user['id'],
       'status' => $user['status'],
       'nom' => $user['nom'],
       'prenom' => $user['prenom'],
       'ddn' => $user['ddn'],
       'taille' => $user['taille'],
       'poids' => $user['poids'],
       'notif' => $user['notif'],
       'ip' => $_SERVER['REMOTE_ADDR']
     );
     header('Location:profil.php');
   }
}
