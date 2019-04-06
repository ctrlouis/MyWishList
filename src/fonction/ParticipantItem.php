<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class ParticipantItem {

	public static function itemDetails ($item)
	{
		if ($item->reserv == 0) $reserv = 'disponible';
		else $reserv = 'reservé';

		echo '<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr .
			'<br/>etat reservation : ' . $reserv;

		if($item->reserv == 0) SELF::itemReserveForm($item->nom);
	}

	public static function itemReserveForm ($item_name)
	{
		echo '<form action="../reserver/' . $item_name . '" method="post">
			<p>Name : <input type="text" name="name" /></p>
			<p>Drop a little message : <br/><input type="text" name="message" /></p>
			<p><input type="submit" name="Make a present"></p>
			</form>';
	}

	public static function itemReserve ($item_name)
	{
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

		$item->reserv = 1;
		$item->message = $_POST['message'];
		$item->save();
		echo $item;
		echo 'Item reservé !';
	}

}
