<nav>
  <?php
tab($_SESSION);
        if (islogged()) {
          if(!empty($_SESSION['user']['prenom'])){
            echo '<p>'. $_SESSION['user']['prenom'] .' </p>
                  <p>'. $_SESSION['user']['nom'] .' </p><br/>';
          }else {
            echo '<p>'. $_SESSION['user']['mail'] .' </p><br/>';
          }

          echo '<a href="profil.php">Votre profil |</a>
                <a href="carnet.php">Votre carnet | </a>
                <a href="contact.php">Contact | </a>
                <a href="deconnection.php"> Deconnexion </a>';
        }else{
          echo '<p>vax beta</p>';
        }
  ?>
</nav>
