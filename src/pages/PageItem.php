<?php

namespace wishlist\pages;

use wishlist\fonction\CreateurItem as CI;
use wishlist\fonction\FctnCagnotte as CG;
use wishlist\fonction\FctnListe as FL;
use wishlist\fonction\ParticipantItem as PI;
use wishlist\fonction\GestionImage as GI;

use wishlist\divers\Outils;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;
use wishlist\modele\Cagnotte;


class PageItem {

	public static function displayItem($item_name) {

		// stop si pas de token enregistré
		if (!isset($_SESSION['wishlist_liste_token']) && !$_SESSION['wishlist_liste_token']) {
			echo "Aucunes liste trouvé"; // alerte
			exit();
		}

		// test token publique
		$list = FL::getCurrentPublicList();

		$createur = false; // défini en accès publique par défault

		// test token privée
		if(!$list) {
			$list = FL::getCurrentPrivateList();

			if ($list) {
				$createur = true; // défini en accès privée si token privée
			} else { // stop si token invalid
				echo "Aucuns token de liste correspondant";
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
			SELF::privateView($item);
		} else {
			SELF::publicView($item);
		}
		echo '<br/><a href="../liste/'. $_SESSION['wishlist_liste_token'] .'">Retourner sur la liste</a>';
	}


	// PRIVATE VIEW
	public static function privateView($item)
	{
		if (isset($_SESSION['item_action']) && $_SESSION['item_action']) {
			switch ($_SESSION['item_action']) {
			    case "edit":
					$_SESSION['item_action'] = null;
					CI::itemEdit($item);
					break;
			    case "delete":
					$_SESSION['item_action'] = null;
					CI::itemDelete($item);
					exit();
			        break;
			    case "uploadImage":
					$_SESSION['item_action'] = null;
					GI::imageUpload($item);
			        break;
				case "deleteImage":
					$_SESSION['item_action'] = null;
					GI::imageDelete($item);
					break;
			}

		}

		CI::itemDetails($item);

		$list = FL::getCurrentPrivateList();
		//Si la liste n'est pas arrivé a expiration
		if(!Outils::listeExpiration($list->expiration)){
			GI::imageUploadForm($item->nom);
			GI::imageDeleteForm($item->nom);
			//Si l'item n'est pas reserver
			if($item->reservation == 0){
				CI::itemEditForm($item->nom);
				CI::itemDeleteForm($item->nom);
				if($item->cagnotte == 0)
					CG::boutonCreate($item->nom);
				else
					CG::boutonDel($item->nom);
			}
		}


	}


	// PUBLIC VIEW
	public static function publicView($item)
	{
		if (isset($_SESSION['item_action']) && $_SESSION['item_action']) // par défault
		{
			switch ($_SESSION['item_action']) {
			    case "reserve":
					$_SESSION['item_action'] = null;
					PI::itemReserve($item);
					break;
			}
		}

		PI::itemDetails($item);
	}

}
