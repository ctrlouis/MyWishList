<?php

namespace wishlist\pages;

use wishlist\fonction\Compte;

use wishlist\fonction\Authentification as AUTH;

class PageCompte {

	public static function displayCompte() {

		if (!AUTH::isConnect()) {
			AUTH::FormulaireConnection();
		} else if (AUTH::isConnect()) {

			if (isset($_SESSION['compte_action']) && $_SESSION['compte_action']) // par défault
			{
				if ($_SESSION['compte_action'] == "edit") {
					Compte::compteEdit();
					$_SESSION['compte_action'] = null;
				}
				if ($_SESSION['compte_action'] == "change-password") {
					Compte::compteChangePassword();
					$_SESSION['compte_action'] = null;
				}
			}

			Compte::compteDetails();

			if (!isset($_SESSION['compte_action']) || !$_SESSION['compte_action']) // par défault
			{
				Compte::compteEditForm();
				//Compte::compteChangePasswordForm();
			}
			else // si action
			{
				$_SESSION['compte_action'] = null;
			}

		}
	}

}
