
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Le bonneauteau</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css" charset="utf-8" media="screen">
	</head>
	<body style="background-image: url(css/img/background_drawing_blue_line_texture_69444_4853x3600.jpg);background-size: cover;">
		<div id="acceuil">
			<h1 class="titre">Jeu du boneteau</h1>

			<form action="php/jeu.php" method="POST" accept-charset="utf-8">
				<p><label for="nom">Votre nom:</label><input type="text" name="nom" id="nom" required="true" />
				<p><input type="submit" value="Démmarer le jeu" /></p>
				
			</form>

			<?php

				if(!empty($_GET['erreur'])){
					$erreur = $_GET['erreur'];
						if($erreur == 1){
							$msg = $_GET['nom']." n'est pas un nom valide!!!";
						}else{
							$msg ="Merci de bien vouloir saisir votre nom!!!";
						}	
						echo '<h1 class="erreur">'.$msg.'</h1>';
				}

	    	?>

		</div>
	</body>
</html>