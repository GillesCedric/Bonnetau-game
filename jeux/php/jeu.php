<?php
 require_once("config.php"); 
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Le bonneteau</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/style.css" charset="utf-8" media="screen">
</head>
<body style="background-image: url(../css/img/images13.jpg); background-size: cover; ">
		<div class="table">
			<h1>Jeu du bonneteau</h1>
			<form action="jeu.php" method="POST" accept-charset="utf-8">
				<div class="tapis">

					<?php if($partie): ?>

						<?php for($i=0;$i<count($tabCarte);$i++): ?>
						<div class="cartes">
							<div class="carte <?= $tabCarte[$i]; ?>">
							</div>
						<div class="choix">
							<?php if($tour != 0): ?>
							<input type="radio" name="carte" value="<?= $i+1; ?>">
							<?php endif; ?>
						</div>
					</div>

					<?php endfor; ?>
					
					<?php else: ?>
							<h1 id="partie"><?= $reponse; ?></h1>
							<h2 id="Rejouer"><a href="jeu.php?rejouer=oui">Rejouer ?</a></h2>
							<h2 id="Terminer"><a href="jeu.php?rejouer=non">Terminer ?</a></h2>
					<?php endif; ?>
				</div>
				<div id="infos">
					<div>
						<p><b>Nom du joueur:</b> <?= $nom; ?></p>
						<?php if($tour == 0 && $depart==true && $gain == 500): 
						?>
						<p><b>Gain de départ:</b>
						<?php else: 
						$depart=false;
						?>
						<p><b>Gain actuel:</b>
						<?php endif; ?>
						<?= $gain; ?></p>
						<p><b>Nombre de chances:</b><?= $chance; ?></p>
					</div>
					<br>
					<?php if($tour == 0): ?>
					<div>
						<?php if($gain == 0 AND $_SESSION['gain'] == 0 OR $gain >10000 AND $_SESSION['gain'] > 10000){?>
						<p><input type="text" name="mise" placeholder="Inscrire votre mise" style="margin-bottom: 5px;" disabled="true" />
						<input type="submit" value="Enregistrer la mise" disabled="true">
						<?php }else{ ?>
						<p><input type="text" name="mise" placeholder="Inscrire votre mise" style="margin-bottom: 5px;"/>
						<input type="submit" value="Enregistrer la mise">
						<?php } ?>
						<?php if($erreur != ""): ?>
							<h4 style="color: red"><?= $erreur; ?></h4>
						<?php endif; ?>
						</p>
					</div>
					<?php else: ?>
							<p><b>Gain parié:</b><?= $mise; ?></p>
							<br>
					<?php endif; ?>
					<div>
						<?php afficheBtn($tour) ?>
					</div>
				</div>

				<!-- <div class="debug">
					<pre>
						<?php 

						/*if(!empty($_SESSION)) {
							print_r($_SESSION);
						}*/ 

						?> 	
					</pre>
				</div> -->

				</form>
				<div class="regle">
			<p><b>Les règles du bonneteau:</b></p>
			<ul>
				<li>Mélanger 3 cartes faces cachées, dans les 3 cartes il y'a 2 as et une figure, le but étant de retrouver la figure après mélange virtuel.</li>
				<li>Le joueur choisit sa carte puis on retourne une des deux cartes qui n'a pas été choisie.</li>
			    <li>Enfin on propose au joueur une dernière chance de pouvoir changer son choix.</li>
				<li>Si le joueur ne change pas de choix depuis le début et qu'il gange, alors il triple sa mise, si i fait un changement de choix et qu'il gagne, alors on double sa mise; sinon il a perdu.</li>
				<li>Pour gangner la partie le joueur doit obtenir 10000 points, si le joueur à 0 points, alors le jeu est terminé et le joueur a perdu</li>
				<li>La mise mininum est de 100 et la mise maximum est celle de vos gains en cours.</li>
			</ul>
		</div>
	</div> <!-- fin de table -->
</body>
</html>