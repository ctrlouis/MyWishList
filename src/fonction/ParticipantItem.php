<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Reservation;

use wishlist\divers\Outils;


class ParticipantItem {

	public static function itemDetails ($item)
	{
		$reserv = $item->reservation[0];
		if ($reserv->reservation == 0) $reservation_state = 'non';
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
				</div>

				<div class="card-divider align-middle">
					<br/>Reservé : ' . $reservation_state . '
				</div>
			</div>
		</div>';

		if($reserv->reservation == 0) SELF::itemReserveForm($item->nom);
	}

	public static function itemReserveForm ($item_name)
	{
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

	public static function itemReserve ($item)
	{
		$reservation = Reservation::where('item_id', '=', $item->id)
			->first();
		$reservation->reservation = 1;
		$reservation->participant_name = htmlspecialchars($_POST['name']);
		$reservation->message = htmlspecialchars($_POST['message']);
		$reservation->save();

		echo 'Item reservé !';
	}

}
