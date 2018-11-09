<?php
include ('inc/pdo.php');
include ('inc/fonction.php');


if(islogged()){
  header('Location:carnet.php');
}else {


    if(!empty($_POST['connexion'])){
    $mail = trim(strip_tags($_POST['mail']));
    $mdp = trim(strip_tags($_POST['mdp']));

  // Vérif pseudo & MDP
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


    if(count($errors) == 0){

      $_SESSION['user'] = array(
        'id' => $user['id'],
        'pseudo' => $user['pseudo'],
        'mail' => $user['mail'],
        'status' => $user['status'],
        'ip' => $_SERVER['REMOTE_ADDR']
      );
      if($user['status'] == 'admin'){
        header('Location:back/back_office.php');
      }else{
       header('Location:carnet.php');
     }


    }
  }
}
?>