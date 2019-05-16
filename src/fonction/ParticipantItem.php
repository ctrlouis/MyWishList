<?php

namespace wishlist\fonction;

use wishlist\modele\User;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Reservation;

use wishlist\fonction\FctnCagnotte as CG;

use wishlist\divers\Outils;


class ParticipantItem {

	public static function itemDetails ($item)
	{
		if ($item->reservation == 0) $reservation_state = 'non';
		else $reservation_state = 'oui';

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

				<div class="card-divider align-middle">
					<br/>Reservé : ' . $reservation_state . '
				</div>
			</div>
		</div>';

		if($item->reservation == 0 && $item->cagnotte == 0) SELF::itemReserveForm($item->nom);
		else if ($item->reservation == 0 && $item->cagnotte == 1) {
			CG::addCagnotteForm($item->nom);
		}
	}

	public static function itemReserveForm ($item_name)
	{
		if (isset($_SESSION['wishlist_userid'])) {
			$user = User::select('first_name', 'last_name')
				->where('id', '=', $_SESSION['wishlist_userid'])
				->first();
			$last_name = $user->last_name;
			$first_name = $user->first_name;

			echo '
				<form action="../reserver/' . $item_name . '" method="post">
					<div class= "row align-center medium-5 large-3">
						<input type="text" name="name" value="' . $last_name . ' ' . $first_name . '" placeholder="Nom" required/>
					</div>
					<div class="row align-center medium-5 large-3">
						<input type="text" name="message" placeholder="Laissez votre message..." required/>
					</div>
					<div class="row align-center medium-5 large-3">
						<button type="submit" class="button" name="submit">Réserver</button>
					</div>
				</form>';
		} else {
			echo '
				<form action="../reserver/' . $item_name . '" method="post">
					<div class= "row align-center medium-5 large-3">
						<input type="text" name="name" placeholder="Nom" required/>
					</div>
					<div class="row align-center medium-5 large-3">
						<input type="text" name="message" placeholder="Laissez votre message..." required/>
					</div>
					<div class="row align-center medium-5 large-3">
						<button type="submit" class="button" name="submit">Réserver</button>
					</div>
				</form>';
		}

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
