<?php

namespace wishlist\pages;

use wishlist\fonction\Authentification as AUTH;
use wishlist\fonction\Compte;
use wishlist\fonction\GestionImage as GI;


class PageCompte {

	public static function displayCompte() {

		if (!AUTH::isConnect()) {
			AUTH::FormulaireConnection();
		} else if (AUTH::isConnect()) {

			if (isset($_SESSION['compte_action']) && $_SESSION['compte_action']) // par défault
			{
				switch ($_SESSION['compte_action']) {
				    case "edit":
						$_SESSION['compte_action'] = null;
						Compte::compteEdit();
						break;
				    case "change-Password":
						$_SESSION['compte_action'] = null;
						Compte::compteChangePassword();
				        break;
				    case "uploadImage":
						$_SESSION['compte_action'] = null;
						GI::imageUploadCompte();
						break;
					case "deleteImage":
						/*$_SESSION['compte_action'] = null;
						GI::imageUploadItem($item);*/
						break;
				}
			}

			Compte::compteDetails();

			if (!isset($_SESSION['compte_action']) || !$_SESSION['compte_action']) // par défault
			{
				Compte::compteEditForm();
				GI::imageUploadCompteForm();
			}
			else // si action
			{
				$_SESSION['compte_action'] = null;
			}

		}
	}

}
