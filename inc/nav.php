<nav>
  <?php
        if (islogged()) {
          if(!empty($_SESSION['user']['prenom'])){
            echo '<p class="bolder">'. $_SESSION['user']['prenom'] .' </p>
                  <p class="bolder">'. $_SESSION['user']['nom'] .' </p><br/>';
          }else {
            echo '<p class="bolder">'.$_SESSION['user']['mail'] .' </p><br/>';
          }
          if($_SESSION['user']['status'] == 'admin'){
            echo '<a href="b_back.php">Back-Office - </a>
                  <a href="profil.php">Votre profil - </a>
                  <a href="carnet.php">Votre carnet - </a>
                  <a href="contact.php">Contact - </a>
                  <a href="deconnection.php"> Deconnexion </a>';
          }elseif($_SESSION['user']['status'] == 'user'){
            echo '<a href="profil.php">Votre profil - </a>
                  <a href="carnet.php">Votre carnet - </a>
                  <a href="contact.php">Contact - </a>
                  <a href="deconnection.php"> Deconnexion </a>';
          }
      }

  ?>
</nav>
