<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/header.php';

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}?>

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
      <p class="noAccess">Vous savez tout :3</p>
    </div>
    <div class="shadow"></div>
  </div>
</a>

<?php include 'inc/footer.php';
