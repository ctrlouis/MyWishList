<?php

namespace wishlist\fonction;

use wishlist\modele\User;

use Cartalyst\Sentinel\Native\Facades\Sentinel;


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
		echo 'Compte modifié ! Redirection en cours...';
		header('Refresh: 0; url=index.php');
	}

	public static function compteChangePasswordForm() {
		echo '<form action="change-password-compte" method="post">
			<p><input type="text" name="oldPassword" placeholder="Old password"/></p>
			<p><br/><input type="text" name="newPassword" placeholder="New password"/></p>
			<p><br/><input type="text" name="newPasswordConf" placeholder="New password confirmation"/></p>
			<p><input type="submit" name="" value="Changer mot de passe"></p>
			</form>';
	}

	public static function compteChangePassword() {
		//$user = User::where('id', '=', $_SESSION['wishlist_userid'])->first();

		$user = Sentinel::findById($_SESSION['wishlist_userid']);

		$hasher = Sentinel::getHasher();

		if (!$hasher->check($_POST['oldPassword'], $user->password) || $_POST['newPassword'] != $_POST['newPasswordConf']) {
            //Session::flash('error', 'Check input is correct.');
            Sentinel::update($user, array('password' => $password));
        }
	}

}
