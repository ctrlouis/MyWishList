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
		echo '<form action="reserver/' . $item_id . '" method="post">
			<p>Name : <input type="text" name="name" /></p>
			<p>Drop a little message : <br/><input type="text" name="message" /></p>
			<p><input type="submit" name="Make a present"></p>
			</form>';
	}

	public static function reserver($item_id)
	{
		// reserver un item
		// - recuperer en fonction de $item_id
		// - ajouter le message contenu dans la variable Post (maybe variable de session ?? voir avantages POST VS SESSION)
		// - update la bdd !! (envoyer mais pas avec methode Item->new, maybe Item->update ?)
		// - a voir comment faire pour gérer la personne ayant reservé dans la bdd (maybe une table faisant le lien entre item_id et nom de personne ayant reservé)
	}

}
