<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class CreateurItem {

	public static function itemDetails ($item)
	{
		echo '<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr;
	}

	public static function itemAddForm ()
	{
		echo '<form action="../add-item" method="post">
			<p><input type="text" name="nom" placeholder="Nom" required/></p>
			<p><br/><input type="text" name="descr" placeholder="Description" required/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix" required/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
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

		$list = Liste::where('token_private', 'like', $_SESSION['liste_token'])
			->first();

		// stop si token invalide
		if (!$list) {
			echo "Aucuns token de liste correspondant"; // alerte
			exit();
		}

		// stop si un item avec le même nom existe deja
		$test = Item::where('nom', 'like', $_POST['nom'])
			->where('liste_id', "==", $list->id)
			->first();
    	if ($test) {
        	echo 'Un item avec le même nom existe déjà'; // alerte
			exit();
    	}

		// creation de l'item
		$item = new Item();
		$item->liste_id = $list->id;
		$item->nom = htmlspecialchars($_POST['nom']);
		$item->descr = htmlspecialchars($_POST['descr']);
		$item->tarif = htmlspecialchars($_POST['tarif']);
		$item->token_private = Outils::generateToken();
		$item->save();
	}

	public static function itemEditForm ($item_name)
	{
		echo '<form action="../edit-item/' . $item_name . '" method="post">
			<p><input type="text" name="nom" placeholder="Nom"/></p>
			<p><br/><input type="text" name="descr" placeholder="Description"/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix"/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
			<p><input type="submit" name="" value="Modifier"></p>
			</form>';
	}

	public static function itemEdit ($item)
	{
		if ($_POST['nom'] && $_POST['nom'] != '') $item->nom = $_POST['nom'];
		if ($_POST['descr'] && $_POST['descr'] != '') $item->descr = $_POST['descr'];
		if ($_POST['tarif'] && $_POST['tarif'] != '') $item->tarif = $_POST['tarif'];
		if ($_POST['url'] && $_POST['url'] != '') $item->url = $_POST['url'];
		$item->save();
		echo 'Item modifié';
	}

	public static function itemDeleteForm ($item_name)
	{
		echo '<form action="../delete-item/' . $item_name . '" method="POST">
				<input type="submit" name="" value="Delete" >
			</form>';
	}

	public static function itemDelete ($item)
	{
		$item->delete();
		echo 'Item supprimé';
	}

}
