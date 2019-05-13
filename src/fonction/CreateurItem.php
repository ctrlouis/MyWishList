<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Reservation;

use wishlist\divers\Outils;


class CreateurItem {

	public static function itemDetails ($item)
	{
		if ($item->img)
			echo '<img class="icone" src="../' . $item->img . '" alt="Image of ' . $item->name . '" />';

		echo '<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr;

		if (Outils::listeExpiration($item->liste->expiration))
		{
			echo '<br/><h2>Reservation</h2>';

			if ( $item->reservation[0]->reservation == 0) {
				echo 'Item non reservé';
			} else {
				echo 'Item reservé par ' . $item->reservation[0]->participant_name .
					'<br/>Son message : ' . $item->reservation[0]->message;
			}
		} else {
			echo "Veuillez attendre l'expiration de la liste";
		}
	}

	public static function itemAddForm ()
	{
		echo '<form action="../add-item" method="post">
			<p><input type="text" name="nom" placeholder="Nom" required/></p>
			<p><br/><input type="text" name="descr" placeholder="Description" required/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix" required/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
			<p><input type="submit" name="Ajouter item" value="Ajouter item"></p>
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

		echo $_POST['nom'] . ' est ajouté à la liste.<br/>' .
				 '<a href="/MyWishList/liste/' . $_SESSION['wishlist_liste_token'].'">Retour à la liste '. $list->titre.'</a>';
	}

	public static function itemEditForm ($item_name)
	{
		echo '<form action="../edit-item/' . $item_name . '" method="post">
			<p><input type="text" name="nom" placeholder="Nom"/></p>
			<p><br/><input type="text" name="descr" placeholder="Description"/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix"/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
			<p><input type="submit" name="" value="Modifier"></p>
			</form>';
	}

	public static function itemEdit ($item)
	{
		if ($_POST['nom'] && $_POST['nom'] != '') $item->nom = $_POST['nom'];
		if ($_POST['descr'] && $_POST['descr'] != '') $item->descr = $_POST['descr'];
		if ($_POST['tarif'] && $_POST['tarif'] != '') $item->tarif = $_POST['tarif'];
		if ($_POST['url'] && $_POST['url'] != '') $item->url = $_POST['url'];
		$item->save();
		echo 'Item modifié';
	}

	public static function itemDeleteForm ($item_name)
	{
		echo '<form action="../delete-image/' . $item_name . '" method="POST">
				<input type="submit" name="" value="Delete" >
			</form>';
	}

	public static function itemDelete ($item)
	{
		$item->delete();
		echo 'Item supprimé';
	}

}
