<?php

namespace wishlist\fonction;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use wishlist\modele\User;


class Compte {

	public static function compteDetails() {
		$user = User::where('id', '=', $_SESSION['wishlist_userid'])
			->first();

		echo '
		<div class= "row column align-center medium-6 large-4">
		<ul class="compte-box">
			<li class="username">';
		echo '<strong>' . $user->email . '</strong>';
		echo '
			</li>
			<li>';
		if ($user->last_name) echo 'Nom : ' . $user->last_name;
		else echo 'Nom : non renseigné';
		echo '
			</li>
			<li>';
		if ($user->first_name) echo 'Prenom : ' . $user->first_name;
		else echo 'Prenom : non renseigné';
		echo '
			</li>
		</ul>
		</div>';
	}

	public static function compteEdit() {
		$user = User::where('id', '=', $_SESSION['wishlist_userid'])
			->first();

		if ($_POST['last_name'] && $_POST['last_name'] != '') $user->last_name = strip_tags($_POST['last_name']);
		if ($_POST['first_name'] && $_POST['first_name'] != '') $user->first_name = strip_tags($_POST['first_name']);
		$user->save();
	}

}
