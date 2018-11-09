<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');
/*ceci est un test a supprimer*/

?>

    <div class="intro">

        <h2>Bienvenue sur <span>VAX</span></h2>
		<p>Gérer vos vaccins<br></p>
		<span class="texte-intro">en ligne.</span>
    </div>

<div class="login-wrap">
	<div class="login-html">
	<form action="incription.php" method="post">

		<input id="tab-1" type="radio" name="tab" class="sign-in" checked>
		<label for="tab-1" class="tab">S'incrire</label>
		<input id="tab-2" type="radio" name="tab" class="sign-up">
		<label for="tab-2" class="tab">Connexion</label>

		<div class="login-form">

			<div class="sign-in-htm">



				<div class="group">
					<span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span>
					<input type="text" placeholder="Adresse E-mail" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>"><br>
					<?php br(); ?>
				</div>

				<div class="group">
				<span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span>
					<input type="password" placeholder="Mot de passe" name="mdp" value=""><br>
					<?php br(); ?>
				</div>

				<div class="group">
					<input type="password" placeholder="Répéter mot de passe" name="mdpV" value=""><br>
				</div>

				<div class="group">
					<input type="submit" name="submit" value="S'inscrire">
				</div>
				<div class="hr"></div>
			</div>

	</form>

	<form action="connection.php" method="post">

			<div class="sign-up-htm">

				<div class="group">
					<input type="text" placeholder="mail" name="mail" value="<?php if(!empty($_POST['mail'])) {echo $_POST['mail'];}?>"><br>
					<span class="error"><?php if(!empty($errors['mail'])){echo $errors['mail'];};?></span><?php br(); ?>
				</div>

				<div class="group">
					<input type="password" placeholder="Mot de passe" name="mdp" value=""><br>
					<span class="error"><?php if(!empty($errors['mdp'])){echo $errors['mdp'];};?></span><?php br(); ?>
				</div>

				<div class="group">
					<input type="submit" class="send" value="Se connecter" name="connexion">
				</div>
				<div class="hr"></div>
			</div>
		</div>
	</form>
	</div>
</div>

<?php
include 'inc/footer.php'; ?>
