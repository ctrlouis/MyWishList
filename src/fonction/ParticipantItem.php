<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class ParticipantItem {

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

		// si aucuns item trouvé
		if (!$item) {
			echo 'Erreur, item introuvable';
			exit();
		}

		$item->reserv = 1;
		$item->message = $_POST['message'];
		$item->save();
		echo 'Item reservé !';
	}

}
