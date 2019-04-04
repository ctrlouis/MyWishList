<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class ParticipantItem {

	public static function itemDisplay ($item_id)
	{
		$item = Item::select('id', 'nom', 'img', 'reserv')
			->where('id', '=', $item_id)
			->first();

		if (!$item_id) {
			echo 'L\'item n\'existe pas'; // alerte
			exit();
		}

		if ($item->reserv == 0) $reserv = 'disponible';
		else $reserv = 'reservé';

		echo 'id :'. $item->id .
			'<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr .
			'<br/>etat reservation : ' . $reserv;

		if($item->reserv == 0) SELF::itemReserveForm($item_id);
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
