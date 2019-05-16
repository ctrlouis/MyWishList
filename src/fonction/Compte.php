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

	public static function compteEditForm() {
		echo '
			<form action="edit-compte" method="post">

				<div class= "row align-center medium-5 large-3">
					<input type="text" name="last_name" placeholder="Nom"/>
				</div>
				<div class="row align-center medium-5 large-3">
					<input type="text" name="first_name" placeholder="Prenom"/>
				</div>
				<div class="row align-left medium-5 large-3">
					<button type="submit" class="button" name="">Modifier</button>
				</div>

			</form>';
	}

	public static function compteEdit() {
		$user = User::where('id', '=', $_SESSION['wishlist_userid'])
			->first();

		if ($_POST['last_name'] && $_POST['last_name'] != '') $user->last_name = htmlspecialchars($_POST['last_name']);
		if ($_POST['first_name'] && $_POST['first_name'] != '') $user->first_name = htmlspecialchars($_POST['first_name']);
		$user->save();
	}

	public static function compteDeleteForm() {
		echo '
		<form action="delete-compte" method="POST">
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

}
