<?php

namespace wishlist\pages;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;

use wishlist\fonction\TousItem as TI;
use wishlist\fonction\ParticipantItem as PI;
use wishlist\fonction\CreateurItem as CI;
use wishlist\fonction\GestionImage as GI;


class PageItem {

	public static function displayItem($item_name) {

		// stop si pas de token enregistré
		if (!isset($_SESSION['liste_token']) && !$_SESSION['liste_token']) {
			echo "Aucunes liste trouvé"; // alerte
			exit();
		}

		// test token publique
		$list = Liste::where('token_publique', 'like', $_SESSION['liste_token'])
			->first();

		$createur = false; // défini en accès publique par défault

		// test token privée
		if(!$list) {
			$list = Liste::where('token_private', 'like', $_SESSION['liste_token'])
				->first();

			if ($list) {
				$createur = true; // défini en accès privée si token privée
			} else { // stop si token invalid
				echo "Aucuns token de liste correspondant"; // alerte
				exit();
			}
		}

		$item = Item::where('liste_id', '=', $list->no)
			->where('nom', 'like', $item_name)
			->first();

		// stop si aucuns item trouvé dans la liste
		if (!$item) {
			echo "Aucuns item trouvé";
			exit();
		}

		// choix vue privée ou publique
		if ($createur) {
			SELF:: privateView($item);
		} else {
			SELF::publicView($item);
		}
	}


	// PRIVATE VIEW
	public static function privateView($item)
	{
		if (isset($_SESSION['item_action']) && $_SESSION['item_action']) // par défault
		{
			if ($_SESSION['item_action'] == "edit") {
				CI::itemEdit($item);
				$_SESSION['item_action'] = null;
			}
			if ($_SESSION['item_action'] == "delete") {
				CI::itemDelete($item);
				$_SESSION['item_action'] = null;
				exit();
			}
			if ($_SESSION['item_action'] == "uploadImage") {
				GI::imageUpload($item);
				$_SESSION['item_action'] = null;
				exit();
			}
			if ($_SESSION['item_action'] == "deleteImage") {
				GI::imageDelete($item);
				$_SESSION['item_action'] = null;
				exit();
			}
		}

		CI::itemDetails($item);

		if (!isset($_SESSION['item_action']) || !$_SESSION['item_action']) // par défault
		{
			GI::imageUploadForm($item->nom);
			GI::imageDeleteForm($item->nom);
			CI::itemEditForm($item->nom);
			CI::itemDeleteForm($item->nom);
		}
		else // si action
		{

			$_SESSION['item_action'] = null;
		}

	}


	// PUBLIC VIEW
	public static function publicView($item)
	{
		if (isset($_SESSION['item_action']) && $_SESSION['item_action']) // par défault
		{
			if ($_SESSION['item_action'] == "reserve") {
				PI::itemReserve($item);
				$_SESSION['item_action'] = null;
			}
		}

		PI::itemDetails($item);

		if (!isset($_SESSION['item_action']) || $_SESSION['item_action'] == null) // par défault
		{
			// enter code here..
		}
		else // si action
		{

			$_SESSION['item_action'] = null;
		}

	}

}
