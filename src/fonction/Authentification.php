<?php

namespace wishlist\fonction;

use Illuminate\Database\Capsule\Manager as DB;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

use wishlist\modele\User;
use wishlist\divers\Outils;


class Authentification {

		public static function Identification()
		{
			if (isset($_SESSION['wishlist_userid']))
			{
				$user = Sentinel::findById($_SESSION['wishlist_userid']);

				if ($user) {
					echo 'Connected as ' . $user->email . '<br/>';
					return $user;
				}
			}
			return null;
		}

		public static function FormulaireConnection()
		{
			echo '<form action="connection" method="post">
				<p>Username : <input type="text" name="username" /></p>
				<p>Password : <input type="text" name="password" /></p>
				<p><input type="submit" name="signin" value="Sign in">
				<input type="submit" name="signup" value="Sign up"></p>
				</form>';
		}

		public static function Connection($username, $password)
		{
			$credentials = [
    			'email'    => $username,
    			'password' => $password,
			];

			$user = Sentinel::forceAuthenticate($credentials);

			if ($user)
			{
				$_SESSION["wishlist_userid"] = $user->id;
				echo "Connexion reussi";
			}
			else {
				echo "Erreur identifiants";
			}
		}

		public static function FormulaireDeconnection()
		{
			echo '<form action="deconnection" method="post">
				<input type="submit" name="signout" value="Sign out"></p>
				</form>';
		}

		public static function Deconnection()
		{
			$_SESSION["wishlist_userid"] = null;
		}

		public static function Inscription($username, $password)
		{
			Sentinel::register([
    			'email'    => $username,
    			'password' => $password,
			]);
		}

}
