<nav>
  <?php

        if (islogged()) {
          echo '<p>Votre profil :<a href="profil.php"> '. $_SESSION['user']['mail'] .' </a></p> <br/>
          <a href="carnet.php">Votre carnet</a>
          <a href="contact.php">Contact</a>
          <p> <a href="deconnection.php"> Deconnexion </a> </p>';
        }else{
          echo '<p>vax beta</p>';
        }
  ?>
</nav>
