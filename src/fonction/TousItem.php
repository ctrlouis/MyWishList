<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class TousItem {

	public static function itemDetails($item)
	{
		if ($item->reserv == 0) $reserv = 'disponible';
		else $reserv = 'reservé';

		echo 'id :'. $item->id .
			'<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr .
			'<br/>etat reservation : ' . $reserv;

		if($item->reserv == 0) SELF::itemReserveForm($item_id);
	}

}
