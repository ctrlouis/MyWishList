<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Reservation;

use wishlist\fonction\FctnCagnotte as CG;

use wishlist\divers\Outils;


class ParticipantItem {

	public static function itemDetails ($item)
	{
		$reserv = $item->reservation[0];
		if ($reserv->reservation == 0) $reservation_state = 'disponible';
		else $reservation_state = 'reservé';

		if ($item->img) echo '<img class="icone" src="../' . $item->img . '" alt="Image of ' . $item->name . '" />';
		echo '<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr .
			'<br/>etat reservation : ' . $reservation_state;
		if($reserv->reservation == 0 && $reserv->cagnotte == 0 ) SELF::itemReserveForm($item->nom);
		else if ($reserv->reservation == 0 && $reserv->cagnotte == 1) {
			echo '<br/>Mode cagnotte';
			CG::addCagnotteForm($item->nom);
		}
	}

	public static function itemReserveForm ($item_name)
	{
		echo '<form action="../reserver/' . $item_name . '" method="post">
			<p><input type="text" name="name" placeholder="Nom" required/></p>
			<p><textarea type="text" name="message" placeholder="Laissez votre message..." required/></textarea></p>
			<p><input type="submit" name="Make a present"></p>
			</form>';
	}

	public static function itemReserve ($item)
	{
		$reservation = Reservation::where('item_id', '=', $item->id)
			->first();
		$reservation->reservation = 1;
		$reservation->participant_name = htmlspecialchars($_POST['name']);
		$reservation->message = htmlspecialchars($_POST['message']);
		$reservation->save();

		echo 'Item reservé ! </br>
					<a href="/MyWishList/liste/' . $_SESSION['wishlist_liste_token'].'">Retour à la liste</a>';
	}

}
