<?php

namespace wishlist\fonction;

use wishlist\modele\User;

use Cartalyst\Sentinel\Native\Facades\Sentinel;


class Compte {

	public static function compteDetails() {
		$user = User::where('id', '=', $_SESSION['wishlist_userid'])
			->first();

		echo '<br>Username : ' . $user->email;

		$last_name = $user->last_name;
		if ($last_name != NULL) $last_name = 'Non renseigné';
		echo '<br>Last name : ' . $user->last_name;

		$first_name = $user->first_name;
		if (!$first_name) $first_name = 'Non renseigné';
		echo '<br>First name : ' . $first_name;
	}

	public static function compteEditForm() {
		echo '<form action="edit-compte" method="post">
			<p><input type="text" name="last_name" placeholder="Last name"/></p>
			<p><br/><input type="text" name="first_name" placeholder="First name"/></p>
			<p><input type="submit" name="" value="Modifier"></p>
			</form>';
	}

	public static function compteEdit() {
		$user = User::where('id', '=', $_SESSION['wishlist_userid'])
			->first();

		if ($_POST['last_name'] && $_POST['last_name'] != '') $user->last_name = $_POST['last_name'];
		if ($_POST['first_name'] && $_POST['first_name'] != '') $item->first_name = $_POST['first_name'];
		$user->save();
		echo 'Compte modifié';
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
