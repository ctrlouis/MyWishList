<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class FctnListe {

	public static function listeAddForm ()
	{
		echo '<form action="add-liste" method="post">
			<p>Titre : (obligatoire)<br/><input type="text" name="titre" /></p>
			<p>Utilisateur : <br/><input type="number" name="user_id" /></p>
			<p>Description : <br/><input type="text" name="description" /></p>
			<p>Date dexpiration : <br/><input type="date" name="expiration" /></p>
			<p><input type="submit" name="Ajouter liste"></p>
			</form>';
	}

	public static function listeAdd ()
	{
		// stop si un champ requis vide
		if (!$_POST['titre']) {
			echo 'Création impossible, le champ requis est vide.'; //alerte
			exit();
		}

		// stop si une liste avec le même nom existe deja
		$test = Liste::where('titre', 'like', $_POST['titre'])->first();
    	if ($test) {
        	echo 'Une liste avec le même nom existe déjà'; // alerte
			exit();
    	}

		// creation d'une liste
		$liste = new Liste();
		$liste->titre = htmlspecialchars($_POST['titre']);
		$liste->description = htmlspecialchars($_POST['description']);
		$liste->expiration = htmlspecialchars($_POST['expiration']);
		$liste->token_private = Outils::generateToken();
		$liste->save();
		echo 'URL de modification : edit-liste-form/' . $liste->token_private;
	}

}
