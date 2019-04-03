<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;


class FctnItem {

	public static function displayDetails ($item_id)
	{
		if ($item_id)
		{
			$item = Item::select('id', 'nom', 'img')
				->where('id', '=', $item_id)
				->first();

			if ($item->reserv == 0) $reserv = 'disponible';
			else $reserv = 'reservé';

			echo 'id :'. $item->id .
				'<br/>nom : ' . $item->nom .
				'<br/>description : ' . $item->descr .
				'<br/>etat reservation : ' . $reserv;
			SELF::FormulaireReservation($item_id);
		}
		else {
			echo 'L\'item n\'existe pas';
		}

	}

	public static function formulaireReservation($item_id)
	{
		echo '<form action="../reserver/' . $item_id . '" method="post">
			<p>Name : <input type="text" name="name" /></p>
			<p>Drop a little message : <br/><input type="text" name="message" /></p>
			<p><input type="submit" name="Make a present"></p>
			</form>';
	}

	public static function reserver($item_id)
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
		else echo 'Erreur, item introuvable';
	}

}
