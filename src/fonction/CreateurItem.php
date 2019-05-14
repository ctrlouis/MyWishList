<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Reservation;

use wishlist\divers\Outils;


class CreateurItem {

	public static function itemDetails ($item)
	{
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
				<p class="article-summary">' . $item->tarif . '€</p>
			</div>
			<div class="card-divider align-middle">';
		if (Outils::listeExpiration($item->liste->expiration))
		{
			echo '<h4>Reservation</h4>';
			if ( $item->reservation[0]->reservation == 0) {
				echo '<p>Item non reservé</p>';
			} else {
				echo '<p>Item reservé par ' . $item->reservation[0]->participant_name . '</p>' .
					'<p>Son message : ' . $item->reservation[0]->message . '<p>';
			}
		} else {
			echo '<p>Veuillez attendre l\'expiration de la liste</p>';
		}
		echo '
				</div>
			</div>
		</div>';
	}

	public static function itemAddForm ()
	{
		echo '<form action="../add-item" method="post">
			<p><input type="text" name="nom" placeholder="Nom" required/></p>
			<p><br/><input type="text" name="descr" placeholder="Description" required/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix" required/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
			<p><input type="submit" class="button" name="Ajouter item" value="Ajouter item"></p>
			</form>';
	}

	public static function itemAdd ()
	{

		// stop si un champ requis vide
		if (!$_POST['nom'] || !$_POST['descr'] || !$_POST['tarif']) {
			echo 'Création impossible, des champs requis sont vides. <br/>
			 			<a href="/MyWishList/liste/' . $_SESSION['wishlist_liste_token'].'">Retour à la liste '. $list->titre.'</a>';
			exit();
		}

		$list = Liste::where('token_private', 'like', $_SESSION['wishlist_liste_token'])
			->first();

		// stop si token invalide
		if (!$list) {
			echo 'Aucuns token de liste correspondant <br/>
			 			<a href="/MyWishList/liste/' . $_SESSION['wishlist_liste_token'].'">Retour à la liste '. $list->titre.'</a>';
			exit();
		}

		// stop si un item avec le même nom existe deja
		$test = Item::where('nom', 'like', $_POST['nom'])
									->where('liste_id', "=", $list->no)
									->first();
    	if ($test) {
        	echo 'Un item avec le même nom existe déjà <br/>
								<a href="/MyWishList/liste/' . $_SESSION['wishlist_liste_token'].'">Retour à la liste '. $list->titre.'</a>';
			exit();
    	}

		// creation de l'item
		$item = new Item();
		$item->liste_id = $list->no;
		$item->nom = htmlspecialchars($_POST['nom']);
		$item->descr = htmlspecialchars($_POST['descr']);
		$item->tarif = htmlspecialchars($_POST['tarif']);
		$item->token_private = Outils::generateToken();
		$item->save();

		$reservation = new Reservation();
		$reservation->item_id = $item->id;
		$reservation->save();

		echo $_POST['nom'] . ' est ajouté à la liste.<br/>' .
				 '<a href="/MyWishList/liste/' . $_SESSION['wishlist_liste_token'].'">Retour à la liste '. $list->titre.'</a>';
	}

	public static function itemEditForm ($item_name)
	{
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
					<button type="submit" class="button" name="">Modifier</button>
				</div>

			</form>';
	}

	public static function itemEdit ($item)
	{
		if ($_POST['nom'] && $_POST['nom'] != '') $item->nom = $_POST['nom'];
		if ($_POST['descr'] && $_POST['descr'] != '') $item->descr = $_POST['descr'];
		if ($_POST['tarif'] && $_POST['tarif'] != '') $item->tarif = $_POST['tarif'];
		if ($_POST['url'] && $_POST['url'] != '') $item->url = $_POST['url'];
		$item->save();
	}

	public static function itemDeleteForm ($item_name)
	{
		echo '
			<form action="../delete-image/' . $item_name . '" method="POST">
			<div class= "row column align-center medium-6 large-4">
				<input type="submit" class="alert button" name="" value="Supprimer item" >
			</div>
		</form>';
	}

	public static function itemDelete ($item)
	{
		$item->delete();
		echo 'Item supprimé';
	}

}
