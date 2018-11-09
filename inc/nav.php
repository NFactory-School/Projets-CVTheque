<nav>
  <?php

        if (!islogged()) {
          echo '<li><p> <a href="incription.php"> Inscription </a> </li>
          <p> <a href="connection.php"> Connexion </a> </p>';
        }else{
          echo '<p>Bienvenue : '. $_SESSION['user']['pseudo'] .' </p> <br/>
          <p> <a href="deconnection.php"> Deconnexion </a> </p>';
        }
  ?>
</nav>
