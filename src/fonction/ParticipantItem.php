<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class ParticipantItem {

	public static function itemDetails ($item)
	{
		if ($item->reserv == 0) $reserv = 'disponible';
		else $reserv = 'reservé';

		if ($item->img) echo '<img class="icone" src="../' . $item->img . '" alt="Image of ' . $item->name . '" />';
		echo '<br/>nom : ' . $item->nom .
			'<br/>description : ' . $item->descr .
			'<br/>etat reservation : ' . $reserv;

		if($item->reserv == 0) SELF::itemReserveForm($item->nom);
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
		$item->reserv = 1;
		$item->message = $_POST['message'];
		$item->save();
		echo 'Item reservé !';
	}

}
