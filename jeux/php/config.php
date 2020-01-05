<?php

session_start();

/*les variables du jeux */
$depart = true;

$erreur = "";
$partie = true;
$reponse = "";
$tabImg = array('dos','as','roi');

$carte1 = $tabImg[0];
$carte2 = $tabImg[0];
$carte3 = $tabImg[0];
$tabCarte = array($carte1,$carte2,$carte3);

//rejouer une partie ou non
if(!empty($_GET['rejouer'])){
	$rejoue = $_GET['rejouer'];
	if($rejoue == 'oui'){
		$depart=true;
		$gain = 500;
		$_SESSION['gain'] = $gain;
	}else{
		header("location: http://localhost:8080/jeux/");
	}
}

//test si on recoit un nom depuis la page index
if(!empty($_POST['nom'])){
	$nom = $_POST['nom'];
	//test si nom est une valeur numérique
	if(is_numeric($nom)){
		//redirection vers index.php car le nom n'est pas valide à cause de valeur numérique
		header("location: http://localhost:8080/jeux/index.php?erreur=1&nom=$nom");
		//test si nom est vide avec suppression des espaces blancs
	}elseif(empty(trim($nom))){
		//redirection vers acceuil car le nom est vide
		header("location: http://localhost:8080/jeux/index.php?erreur=2");
	//ici on a un nom admissible
	}else{
		//stockage des variables dans la session
		$_SESSION['nom'] = $nom;
		$_SESSION['gagnante'] = 0;
		$gain = 500;
		$chance = 2;
		$tour = 0;
		$choix = 0;
		$gagnante = 0;
		$mise = 0;
		$_SESSION['gain'] = $gain;
		$_SESSION['chance'] = $chance;
		$_SESSION['tour'] = $tour;
		$_SESSION['choix'] = $choix;
		$_SESSION['mise'] = $mise;

	}
}

//info: nombre max=2 147 483 647
//calcul de la carte gagnante
if(!empty($_SESSION['gagnante'])){
	$gagnante = $_SESSION['gagnante'];
}else{
	$gagnante = ceil(mt_rand(0,3000000)/1000000);
	$_SESSION['gagnante'] = $gagnante;
	$gagnante = 0;
	$chance = 0;
	$_SESSION['chance'] = $chance;
}

//test si on recoit une mise 
if(!empty($_POST['mise'])){
	if($_POST['mise'] < 100){
		$erreur = "La mise minimum autorisé est de 100!!!";
		$tour = 0;
		$_SESSION['tour'] = $tour;
	}elseif ($_POST['mise'] > $_SESSION['gain']) {
		$erreur = "La mise maximum autorisé est : ".$_SESSION['gain']."!!!";
		$tour = 0;
		$_SESSION['tour'] = $tour;
	}else{
		$mise = $_POST['mise'];
		$tour = $_SESSION['tour'];
		$_SESSION['mise'] = $mise;
		$tour++;
		$_SESSION['tour'] = $tour;
		$gagnante = 0;
		$chance = 2;
		$_SESSION['chance'] = $chance;
	}	
}

//mélange des cartes si on a fait une mise
if($_SESSION['tour'] == 0){
	$_SESSION['gagnante'] = 0;//mélange des cartes "la bonne réponse"
	$chance = 2;
	$tour = 0;
	$choix = 0;
	$gagnante = 0;
	$mise = 0;
	$_SESSION['chance'] = $chance;
	$_SESSION['choix'] = $choix;
	$_SESSION['tour'] = $tour;
	$_SESSION['mise'] = $mise;
}

//test de la présence d'un nom dans la session
if(!empty($_SESSION['nom'])){
	$nom = $_SESSION['nom'];

}

//test des variables en session $gain et $chance
if(!empty($_SESSION['gain']) AND !empty($_SESSION['chance'])){
	$gain = $_SESSION['gain'];
	$chance = $_SESSION['chance'];
}
//test de la présence de $tour et du $choix
if($_SESSION['tour']== 0 AND $_SESSION['choix'] == 0){
	$tour = $_SESSION['tour'];
	$choix = $_SESSION['choix'];
}else{
	$tour = $_SESSION['tour'];
	$choix = $_SESSION['choix'];
}

//test si on recoit une carte donc un choix
if(!empty($_POST['carte'])){
	$_SESSION['tour'] = ++$tour;
	$choix = $_POST['carte'];
	if($_SESSION['choix'] != $choix AND $_SESSION['choix'] != 0){
		$chance--;
		$_SESSION['chance'] = $chance;
	}
	$_SESSION['choix'] = $choix;
	$mise = $_SESSION['mise'];
}else{
	$mise = $_SESSION['mise'];
}

if($_SESSION['tour'] == 3){
	$tour = 0;
	$_SESSION['tour'] = $tour;
	if($_SESSION['choix'] == $_SESSION['gagnante']){
		if($_SESSION['chance'] != 2){
			$gain = $gain + ($mise * 2);
			$_SESSION['gain'] = $gain;
		}else{
			$gain = $gain + ($mise * 3);
			$_SESSION['gain'] = $gain;
		}
	}else{
		$gain = $gain - $mise;;
		$_SESSION['gain'] = $gain;
	}
	if($gain <= 0){
		$reponse = "Dommage! vous avez PERDU :/ !!!";
		$partie = false;
	}
	if($gain >= 10000){
		$reponse = "Felicitation! vous avez GAGNER :) !!!";
		$partie = false;
	}
	$_SESSION['gagnante'] = 0;
}

//retourne toutes les cartes
function carteDeDos(){
	global $carte1,$carte2,$carte3,$tabImg,$tabCarte;
	$carte1 =$tabImg[0];
	$carte2 =$tabImg[0];
	$carte3 =$tabImg[0];
	$tabCarte = array($carte1,$carte2,$carte3);
}

//retourne une carte sur les 3
function melange($combinaison){
	global $carte1,$carte2,$carte3,$tabImg,$tabCarte;
	switch($combinaison){
		case 1:
		{
			$carte1 =$tabImg[0];
			$carte2 =$tabImg[1];
			$carte3 =$tabImg[0];
		}
		break;

		case 2:
		{
			$carte1 =$tabImg[0];
			$carte2 =$tabImg[0];
			$carte3 =$tabImg[1];
		}
		break;

		case 3:
		{
			$carte1 =$tabImg[1];
			$carte2 =$tabImg[0];
			$carte3 =$tabImg[0];
		}
		break;
	}
	$tabCarte = array($carte1,$carte2,$carte3);
}

//retourne toutes les cartes
function donneReponse($resultat){
	global $carte1,$carte2,$carte3,$tabImg,$tabCarte;
	if($resultat == 1){
		$carte1 =$tabImg[2];
		$carte2 =$tabImg[1];
		$carte3 =$tabImg[1];
	}elseif($resultat == 2){
		$carte1 =$tabImg[1];
		$carte2 =$tabImg[2];
		$carte3 =$tabImg[1];
	}else{
		$carte1 =$tabImg[1];
		$carte2 =$tabImg[1];
		$carte3 =$tabImg[2];
	}
	$tabCarte = array($carte1,$carte2,$carte3);
}

//test de $gagnante pour connaitre le déroulment du jeu avec le choix du joueur
switch($gagnante){
	case 1:
	{
		if($choix == 1 AND $tour == 2){
			$plage = 1000000000;
			$tmp = mt_rand(0,$plage);
			$tmp = ($tmp <= $plage/2) ? 1 : 2;
			if($tmp == 1){
				melange(1);
			}else{
				melange(2);
			}		
		}elseif($choix == 2 AND $tour == 2){
			melange(2);
		}elseif($choix == 3 AND $tour == 2){
			melange(1);
		}elseif($tour == 1){
			carteDeDos();
		}else{
			donneReponse(1);
		}
	}	
	break;

	case 2:
	{
		if($choix == 1 AND $tour == 2){
			melange(2);
		}elseif($choix == 2 AND $tour == 2){
			$plage = 1000000000;
			$tmp = mt_rand(0,$plage);
			$tmp = ($tmp <= $plage/2) ? 1 : 2;
			$_SESSION['pile'] = $tmp;
			if($tmp == 1){
				melange(3);
			}else{
				melange(2);
			}		
		}elseif($choix == 3 AND $tour == 2){
			melange(3);
		}elseif($tour == 1){
			carteDeDos();
		}else{
			donneReponse(2);
		}
	}
	break;

	case 3:
	{
		if($choix == 1 AND $tour == 2){
			melange(1);
		}elseif($choix == 2 AND $tour == 2){
			melange(3);
		}elseif($choix == 3 AND $tour == 2){
			$plage = 1000000000;
			$tmp = mt_rand(0,$plage);
			$tmp = ($tmp <= $plage/2) ? 1 : 2;
			if($tmp == 1){
				melange(3);
			}else{
				melange(1);
			}		
		}elseif($tour == 1){
			carteDeDos();
		}else{
			donneReponse(3);
		}
	}
	break;

	case 0:
	{
		carteDeDos();
	}
	break;
}

//affiche les bouttons
function afficheBtn($nbTour){
	if($nbTour == 1){
		echo '<p><input type="submit" value="Valider mon choix" /></p>';
		echo '<p><input type="submit" value="Donner la réponse" disabled/></p>';
	}elseif ($nbTour == 2) {
		echo '<p><input type="submit" value="Valider mon choix" disabled/></p>';
		echo '<p><input type="submit" value="Donner la réponse" /></p>';
	}
}
?>