<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class FctnListe {

	public static function listeAddForm ()
	{
		$today = getDate();
		$date = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
		echo '<form action="add-liste" method="post">
			<p>Titre : (obligatoire)<br/><input type="text" name="titre" /></p>
			<p>Utilisateur : <br/><input type="number" name="user_id" /></p>
			<p>Description : <br/><input type="text" name="description" /></p>
			<p>Date dexpiration : <br/><input type="date" min=' . $date . ' name="expiration" /></p>
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
		echo '<a href ="edit-liste-form/' . $liste->token_private . '">URL de modification : </a>';
	}

	public static function listeEditForm ($token)
	{
		$liste = Liste::where('token_private', 'like', $token)->first();

		if (!$liste) {
			echo 'Aucune liste trouvée'; // alerte
			exit();
		}

		echo $liste . '<br/>';
		$_SESSION['wishlist_liste_token'] = $liste->token_private;

		echo '<form action="../edit-liste" method="post">
			<p>Titre : <input type="text" name="titre" /></p>
			<p>Utilisateur : <br/><input type="text" name="user_id" /></p>
			<p>Description : <br/><input type="number" name="description" /></p>
			<p><input type="submit" name="Modifier"></p>
			</form>';
	}

	public static function listeEdit ()
	{

		// stop si pas de token renseigné
		if (!isset($_SESSION['wishlist_liste_token'])) {
			echo 'Token erroné';
			exit();
		}

		if (!$_POST['titre'] && !$_POST['description'] && !$_POST['user_id'] && !$_POST['url']) {
			echo 'Aucunes modification effectué, pas de champs renseigné.'; //alerte
			exit();
		}

		$item = Item::select(/*'nom', 'descr', 'tarif', 'url', 'token_private'*/)
			->where('token_private', 'like', $_SESSION['wishlist_liste_token'])
			->first();

		// stop si aucuns item trouvé
		if (!$item) {
			echo 'Aucune liste trouvé';
			exit();
		}

}
