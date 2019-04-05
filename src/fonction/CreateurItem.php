<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class CreateurItem {

	public static function itemDetails($item)
	{
		echo '<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr;
	}

	public static function itemAddForm ()
	{
		echo '<form action="add-item" method="post">
			<p>Nom : (obligatoire)<input type="text" name="nom" /></p>
			<p>Description : (obligatoire)<br/><input type="text" name="descr" /></p>
			<p>Prix : (obligatoire)<br/><input type="number" name="tarif" /></p>
			<p>URL : <br/><input type="text" name="url" /></p>
			<p><input type="submit" name="Ajouter item"></p>
			</form>';
	}

	public static function itemAdd ()
	{
		// stop si un champ requis vide
		if (!$_POST['nom'] || !$_POST['descr'] || !$_POST['tarif']) {
			echo 'Création impossible, des champs requis sont vides.'; //alerte
			exit();
		}

		// stop si un item avec le même nom existe deja
		$test = Item::where('nom', 'like', $_POST['nom'])->first();
    	if ($test) {
        	echo 'Un item avec le même nom existe déjà'; // alerte
			exit();
    	}

		// creation de l'item
		$item = new Item();
		$item->liste_id = 1;
		$item->nom = htmlspecialchars($_POST['nom']);
		$item->descr = htmlspecialchars($_POST['descr']);
		$item->tarif = htmlspecialchars($_POST['tarif']);
		$item->token_private = Outils::generateToken();
		$item->save();
		echo 'URL de modification : edit-item-form/' . $item->token_private;
	}

	public static function itemEditForm ($item_name)
	{
		echo '<form action="../edit-item/' . $item_name . '" method="post">
			<p>Nom : <input type="text" name="nom" /></p>
			<p>Description : <br/><input type="text" name="descr" /></p>
			<p>Prix : <br/><input type="number" name="tarif" /></p>
			<p>URL : <br/><input type="text" name="url" /></p>
			<p><input type="submit" name="" value="Modifier"></p>
			</form>';
	}

	public static function itemEdit ()
	{

		// stop si pas de token renseigné
		if (!isset($_SESSION['wishlist_item_token'])) {
			echo 'Token erroné';
			exit();
		}

		// stop si pas de champs renseigné
		if (!$_POST['nom'] && !$_POST['descr'] && !$_POST['tarif'] && !$_POST['url']) {
			echo 'Aucunes modification effectué, pas de champs renseigné.'; //alerte
			exit();
		}

		// test token publique
		$list = Liste::select('no', 'token_publique')
			->where('token_publique', 'like', $_SESSION['liste_token'])
			->first();

		$item = Item::where('liste_id', '=', $list->no)
			->where('nom', 'like', $item_name)
			->first();

		// si aucuns item trouvé
		if (!$item) {
			echo 'Erreur, item introuvable';
			exit();
		}

		if (!$_POST['nom'] && $_POST['nom'] != '') $item->nom = $_POST['nom'];
		if (!$_POST['descr'] && $_POST['descr'] != '') $item->descr = $_POST['descr'];
		if (!$_POST['tarif'] && $_POST['tarif'] != '') $item->tarif = $_POST['tarif'];
		if (!$_POST['url'] && $_POST['url'] != '') $item->url = $_POST['url'];
		echo $item;
		$item->save();
		echo 'Item modifié';

		$_POST['nom'] = null;
		$_POST['descr'] = null;
		$_POST['tarif'] = null;
		$_POST['url'] = null;
	}

}
