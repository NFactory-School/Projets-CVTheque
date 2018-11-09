<?php include('../inc/fonction.php');
include('../inc/pdo.php');
//verif admin
isAdmin();

//film existe?
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
	$idfilm = $_GET['id'];
} else { $idfilm = ''; }

$error = array();
$title = '';
$content = '';
$auteur = '';

//si le formulaire est soumis
  if ( !empty($_POST['submiteditpost']) ) {
      // Protection XSS
      $auteur = trim(strip_tags($_POST['auteur']));
      $title = trim(strip_tags($_POST['title']));
      $content = trim(strip_tags($_POST['content']));

      //verification auteur
      if (!empty($auteur)){
          if(strlen($auteur) < 3 ) {
      $error['auteur'] = 'Votre nom est trop court. (minimum 3 caractères)';
    } elseif(strlen($auteur) > 40) {
      $error['auteur'] = 'Votre nom est trop long.';
    }

      } else {
        $error['auteur'] = 'Veuillez entrer votre nom';
      }

      //verification title
      if (!empty($title)){
          if(strlen($title) < 3 ) {
      $error['title'] = 'Votre titre est trop court. (minimum 3 caractères)';
    } elseif(strlen($title) > 220) {
      $error['title'] = 'Votre titre est trop long.';
    }

      } else {
        $error['title'] = 'Veuillez renseigner un titre';
      }

      //verification content
      if (!empty($content)){
          if(strlen($content) < 3 ) {
      $error['content'] = 'Votre contenu est trop court. (minimum 3 caractères)';
    }

      } else {
        $error['content'] = 'Veuillez renseigner un contenu';
      }

      // Si aucune error
      if (count($error) == 0){
        // ICI faire un UPDATE
          $sql = "UPDATE articles SET title = :title, content = :content, auteur = :auteur, modified_at = NOW() WHERE id = :id";
          // preparation de la requête
          $stmt = $pdo->prepare($sql);

          // Protection injections SQL
          $stmt->bindValue(':title',$title, PDO::PARAM_STR);
          $stmt->bindValue(':content',$content, PDO::PARAM_STR);
          $stmt->bindValue(':auteur',$auteur, PDO::PARAM_STR);
          $stmt->bindValue(':id',$idarticle, PDO::PARAM_INT);

          // execution de la requête preparé
          $stmt->execute();
          // redirection vers page accueil
          header("Location: dashboard.php");
          die;
      }

  }  else {
    if(!empty($idarticle)) {

      // recuperation des donnée d'un article à partir de son id
      $sql2 = "SELECT id,title,content,auteur FROM articles WHERE id = :id";
      $stmt = $pdo->prepare($sql2);
      $stmt->bindValue(':id',$idarticle, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch();

      // debug($article);  // cf inc/functions.php
      if(!empty($article)) {
        $title = $article['title'];
        $content = $article['content'];
        $auteur = $article['auteur'];
      }

    }

  }

?>

<?php include('inc/admin-header.php'); ?>
<h2><?php echo $titre; ?></h2>
<?php if(!empty($idarticle)) { ?>

  <form action="" method="POST">

        <div class="form-group">
          <label for="title">Titre*</label>
          <span class="error"><?php if(!empty($error['title'])) { echo $error['title']; } ?></span>
          <input type="text" name="title" id="title" class="form-control" value="<?php if(!empty($title)) { echo $title; } ?>" />
        </div>

         <div class="form-group">
      <label for="content">Content:</label>
      <span class="error"><?php if(!empty($error['content'])) { echo $error['content']; } ?></span>
      <textarea name="content" class="form-control" rows="5" id="content"><?php if(!empty($_POST['content'])) { echo $_POST['content']; } else { echo $content; } ?></textarea>
    </div>

        <div class="form-group">
          <label for="auteur">Auteur*</label>
          <span class="error"><?php if(!empty($error['auteur'])) { echo $error['auteur']; } ?></span>
          <input type="text" name="auteur" id="auteur" class="form-control" value="<?php if(!empty($_POST['auteur'])) { echo $_POST['auteur']; } else { echo $auteur; } ?>" />
        </div>

        <input type="submit" name="submiteditpost" class="btn btn-primary" value="Update" />

    </form>


<?php }  // fermeture de la condition if !empty $_GET['id'] ?>

<?php include('inc/admin-footer.php');
