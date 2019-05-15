<?php

namespace wishlist\fonction;

use wishlist\divers\Outils;

use wishlist\fonction\Alerte;

use wishlist\modele\Item;
use wishlist\modele\Liste;


class CreateurItem {

	public static function itemDetails($item) {
		echo '
		<div class= "row column align-center medium-6 large-4">
			<div class="card-flex-article card">';

		if ($item->img) {
			echo'
				<div class="card-image">
					<img src="../' . $item->img .'">
				</div>';
		}
		echo '
			<div class="card-section">
				<h3 class="article-title">' . $item->nom . '</h3>
				<p class="article-summary">' . $item->descr . '</p>
				<p class="article-summary">Prix : ' . $item->tarif . '€</p>
			</div>
			<div class="card-divider align-middle">';
		if (Outils::listeExpiration($item->liste->expiration))
		{
			echo 'Reservation : ';
			if ( $item->reservation == 0) {
				echo 'Non reservé';
			}
			else if ($item->cagnotte == 0){
				echo 'Reservé par '. $item->participant_name;
				if($item->mesage){
					echo ' son message '. $item->message;
				}
			}
			else if ($item->cagnotte == 1){
				echo 'Reservé par cagnotte
							<ul>';
				$contribution = $item->cagnottes;
				foreach ($contribution as $key) {
					echo '<li>'.$key->name. ' a contribué à une hauteur de '. $key->montant . '€';
				}
				echo '</ul>';
			}

		} else {
			echo '<p>Veuillez attendre l\'expiration de la liste</p>';
		}
		echo '
				</div>
			</div>
		</div>';
	}

	public static function itemAddForm() {
		Alerte::getErrorAlert("empty_field", "Les champs nom, description et tarifs sont obligatoire");
		Alerte::getErrorAlert("liste_not_found", "Aucune liste spécifié pour l'ajout");
		Alerte::getErrorAlert("already_exists", "L'item existe déjà dans cette liste");
		echo '
		<form action="../add-item" method="post">
			<p><input type="text" name="nom" placeholder="Nom*" required/></p>
			<p><br/><input type="text" name="descr" placeholder="Description*" required/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix*" required/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
			<p><input type="submit" class="button" name="Ajouter item" value="Ajouter item"></p>
		</form>';
	}

	public static function itemAdd() {
		if (SELF::itemVerify()) {
			$liste = Liste::select('no')
					->where('token_private', 'like', $_SESSION['wishlist_liste_token'])
					->first();

			$item = new Item();
			$item->liste_id = $liste->no;
			$item->nom = htmlspecialchars($_POST['nom']);
			$item->descr = htmlspecialchars($_POST['descr']);
			$item->tarif = htmlspecialchars($_POST['tarif']);
			$item->token_private = Outils::generateToken();
			$item->save();
		}
		Outils::goTo('/MyWishList/liste/' . $_SESSION['wishlist_liste_token'], 'Retour a la liste');
	}

	public static function itemEditForm($item_name) {
		echo '
			<form action="../edit-item/' . $item_name . '" method="post">

				<div class= "row align-center medium-5 large-3">
					<input type="text" name="nom" placeholder="Nom"/>
				</div>
				<div class="row align-center medium-5 large-3">
					<input type="text" name="descr" placeholder="Description"/>
				</div>
				<div class= "row align-center medium-5 large-3">
					<input type="number" name="tarif" placeholder="Prix en €"/>
				</div>
				<div class="row align-center medium-5 large-3">
					<input type="text" name="url" placeholder="url"/>
				</div>
				<div class="row align-center medium-5 large-3">
					<button type="submit" class="button">
						<div class ="row">
							<div class="columns small-2 fi-pencil"></div>
							<div class="columns">Modifier</div>
						</div>
					</button>
				</div>

			</form>';
	}

	public static function itemEdit($item) {
		if ($_POST['nom'] && $_POST['nom'] != '') $item->nom = $_POST['nom'];
		if ($_POST['descr'] && $_POST['descr'] != '') $item->descr = $_POST['descr'];
		if ($_POST['tarif'] && $_POST['tarif'] != '') $item->tarif = $_POST['tarif'];
		if ($_POST['url'] && $_POST['url'] != '') $item->url = $_POST['url'];
		$item->save();
	}

	public static function itemDeleteForm($item_name) {
		echo '
			<form action="../delete-image/' . $item_name . '" method="POST">
			<div class= "row column align-center medium-6 large-4">
				<button type="submit" class="alert button">
					<div class ="row">
						<div class="columns small-2 fi-trash"></div>
						<div class="columns">Supprimer item</div>
					</div>
				</button>

			</div>
		</form>';
	}

	public static function itemDelete($item) {
		$item->delete();
		echo 'Item supprimé';
	}

	public static function itemVerify() {
		// erreur si un champ requis vide
		if (!$_POST['nom'] || !$_POST['descr'] || !$_POST['tarif']) {
			Alerte::set('empty_field');
			return false;
		}

		// erreur si token invalide
		$liste = Liste::select('no')
				->where('token_private', 'like', $_SESSION['wishlist_liste_token'])
				->first();
		if (!$liste) {
			Alerte::set('liste_not_found');
			return false;
		}

		// erreur si un item avec le même nom existe deja
		$test_item = Item::where('nom', 'like', $_POST['nom'])
				->where('liste_id', "=", $liste->no)
				->first();
    	if ($test_item) {
			Alerte::set('already_exists');
        	return false;
    	}
		return true;
	}

}
