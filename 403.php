<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php'); ?>

<a class="back" href ="index.php">
    <div class="container">
      <div class="spooky">
        <div class="body">
          <div class="eyes"></div>
          <div class="mouth"></div>
          <div class="feet">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
        <h2 class="noAccess">403</h2>
      </div>
      <div class="shadow"></div>
    </div>
  </a>
    <h2 class ="noAccess">Accès non autorisé<br/>
    <span>cliquer sur moi pour retourner sur le site.</span><br><br/>
    <span>Si vous êtes banni du site, vous resterez sur cette page</span><br/>
  </h2>
  

<?php include ('inc/footer.php') ?>
