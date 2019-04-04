<?php

namespace wishlist\pages;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;

use wishlist\fonction\TousItem as TI;
use wishlist\fonction\ParticipantItem as PI;
use wishlist\fonction\CreateurItem as CI;


class PageItem {

	public static function displayItem($item_name) {

		// si pas de token enregistré
		if (!isset($_SESSION['liste_token']) && !$_SESSION['liste_token']) {
			echo "Aucuns item trouvé"; // alerte
			exit();
		}

		$list = Liste::select()
			->where('token_publique', 'like', $_SESSION['liste_token'])
			->first();
		$list = null;

		if(!$list) { // si pas de liste trouvé en publique
			$list = Liste::where('token_private', 'like', $_SESSION['liste_token'])
				->first();
		}

		$createur = false;

		if (!$list) { // si aucunes listes n'est trouvé en privé
			echo "Aucuns token de liste correspondant"; // alerte
			exit();
		} else {
			$createur = true;
		}

		$item = Item::where('liste_id', '=', $list->no)
			->first();

		if (!$item) {
			echo "Aucuns item trouvé";
			exit();
		}

		// DETAILS ITEM
		TI::itemDetails($item);

		// APRES AFFICHER DETAILS ITEM

		// par défault
		if (!isset($_SESSION['item_action']) || $_SESSION['item_action'] == null) {

			// si créateur
			if ($createur ) {
				CI::itemEditForm();
			}

			// si participant

		}

		// si action demandé
		if (isset($_SESSION['item_action']) && !$_SESSION['item_action']) {
			$_SESSION = null;

			if (!$createur && $_SESSION['item_action'] == 'reserver') {
				// enter code here...
			}

		}

	}

}
