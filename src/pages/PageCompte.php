<?php

namespace wishlist\pages;

use wishlist\fonction\Authentification as AUTH;
use wishlist\fonction\Compte;


class PageCompte {

	public static function displayCompte() {

		if (!AUTH::isConnect()) {
			AUTH::FormulaireConnection();
		} else if (AUTH::isConnect()) {
			if (isset($_SESSION['compte_action']) && $_SESSION['compte_action']) {
				switch ($_SESSION['compte_action']) {
				    case "edit":
						$_SESSION['compte_action'] = null;
						Compte::compteEdit();
						break;
				    case "change_password":
						$_SESSION['compte_action'] = null;
						AUTH::passwordEdit();
				        break;
				}
			}
			Compte::compteDetails();
			Compte::compteEditForm();
			AUTH::passwordEditForm();

		}
	}

}
