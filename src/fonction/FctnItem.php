<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class FctnItem {

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

	public static function itemEditForm ($token)
	{
		$item = Item::where('token_private', 'like', $token)->first();

		if (!$item) {
			echo 'Aucuns item trouvé'; // alerte
			exit();
		}

		echo $item . '<br/>';
		$_SESSION['wishlist_item_token'] = $item->token_private;

		echo '<form action="../edit-item" method="post">
			<p>Nom : <input type="text" name="nom" /></p>
			<p>Description : <br/><input type="text" name="descr" /></p>
			<p>Prix : <br/><input type="number" name="tarif" /></p>
			<p>URL : <br/><input type="text" name="url" /></p>
			<p><input type="submit" name="Modifier"></p>
			</form>';
	}

	public static function itemEdit ()
	{

		// stop si pas de token renseigné
		if (!isset($_SESSION['wishlist_item_token'])) {
			echo 'Token erroné';
			exit();
		}

		if (!$_POST['nom'] && !$_POST['descr'] && !$_POST['tarif'] && !$_POST['url']) {
			echo 'Aucunes modification effectué, pas de champs renseigné.'; //alerte
			exit();
		}

		$item = Item::select('nom', 'descr', 'tarif', 'url', 'token_private')
			->where('token_private', 'like', $_SESSION['wishlist_item_token'])
			->first();

		// stop si aucuns item trouvé
		if (!$item) {
			echo 'Aucuns item trouvé';
			exit();
		}

		echo $item;

		echo $_POST['nom'] . '<br/>';
		echo $_POST['descr'] . '<br/>';
		echo $_POST['tarif'] . '<br/>';
		echo $_POST['url'] . '<br/>';

		//if ($_POST['nom'] != '') $item->nom = $_POST['nom'];
		if ($_POST['descr'] != '') $item->descr = $_POST['descr'];
		if ($_POST['tarif'] != '') $item->tarif = $_POST['tarif'];
		if ($_POST['url'] != '') $item->url = $_POST['url'];
		echo $item;
		$item->save();
		echo 'Item modifié';

		$_POST['nom'] = null;
		$_POST['descr'] = null;
		$_POST['tarif'] = null;
		$_POST['url'] = null;
	}

	public static function displayDetails ($item_id)
	{
		if ($item_id)
		{
			$item = Item::select('id', 'nom', 'img', 'reserv')
				->where('id', '=', $item_id)
				->first();


			if ($item->reserv == 0)
				$reserv = 'disponible';
			else
				$reserv = 'reservé';

			echo 'id :'. $item->id .
				'<br/>nom : ' . $item->nom .
				'<br/>description : ' . $item->descr .
				'<br/>etat reservation : ' . $reserv;
			if($item->reserv == 0) SELF::itemReserveForm($item_id);

		}
		else {
			echo 'L\'item n\'existe pas'; // alerte
		}
	}

	public static function itemReserveForm($item_id)
	{
		echo '<form action="../reserver/' . $item_id . '" method="post">
			<p>Name : <input type="text" name="name" /></p>
			<p>Drop a little message : <br/><input type="text" name="message" /></p>
			<p><input type="submit" name="Make a present"></p>
			</form>';
	}

	public static function itemReserve($item_id)
	{
		$item = Item::select('id', 'reserv', 'message')
			->where('id', '=', $item_id)
			->first();

		if ($item)
		{
		$item->reserv = 1;
		$item->message = $_POST['message'];
		$item->save();
		echo 'Item reservé !';
		}
		else
			echo 'Erreur, item introuvable';
	}

}
