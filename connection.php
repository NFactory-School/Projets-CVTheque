<?php
include ('inc/pdo.php');
include ('inc/fonction.php');


if(islogged()){
  header('Location:carnet.php');
}else {


    if(!empty($_POST['connexion'])){
    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));

  // Vérif  & MDP
    $sql = "SELECT * FROM vax_profils
            WHERE  mail = :mail";
    $query = $pdo -> prepare($sql);
    $query -> bindValue(':mail', $mail, PDO::PARAM_STR);
    $query -> execute();
    $user = $query -> fetch();

  if(!empty($user)){

    if(!password_verify($mdp, $user['mdp'])){

      $errors['mdp'] = "mdp invalide";
    }
  }
  else{

    $errors['mail'] = 'Vous n\'êtes pas inscrit';
  }
  // if(!empty($_POST['remember'])){
  //   setcookie('user_id',$user -> id,time()+3600*24)
  // }

    if(count($errors) == 0){

      $_SESSION['user'] = array(
        'id' => $user['id'],
        'mail' => $user['mail'],
        'status' => $user['status'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'ddn' => $user['ddn'],
        'taille' => $user['taille'],
        'poids' => $user['poids'],
        'notif' => $user['notif'],
        'ip' => $_SERVER['REMOTE_ADDR']
      );
<<<<<<< HEAD
        header('Location:profil.php');
      }
    }
  }

=======

      if (!empty($user['status'])){
          if($user['status'] == 'admin'){
            header('Location:b_back.php');
          }elseif($user['status'] == 'user'){
            header('Location:carnet.php');
          }
      }
    }
  }
}
>>>>>>> 057d21e24259cbd98cc25b260f9c09d015c57976
?>
