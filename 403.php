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
    <h2 class ="noAccess">Access not granted ! <br/>
    <span>click me to go home.</span><br>
  </h2>
  <span>Si le fantôme ne fonctionne pas, c'est que vous êtes banni du site</span>

<?php include ('inc/footer.php') ?>
