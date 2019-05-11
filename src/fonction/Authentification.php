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
				echo '
				<div class= "row column align-center medium-6 large-4">
					<form action="connection" method="post" class="log-in-form">

						<h4 class="text-center">Connection / Inscription</h4>

						<label>Username
							<input type="text" name="username" placeholder="MyPseudo">
						</label>

						<label>Password
							<input type="password" name="password" placeholder="Password">
						</label>

						<p><input type="submit" class="button expanded" name="signin" value="Connection"></input></p>
						<p><input type="submit" class="button expanded" name="signup" value="Inscription"></input></p>

					</form>
				</div>';
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
			echo "Compte crée !";
		}

		public static function isConnect()
		{
			if (isset($_SESSION["wishlist_userid"]) && $_SESSION["wishlist_userid"] != null) {
				return true;
			} else {
				return false;
			}
		}

		public static function menuDisplay()
		{
			if (!SELF::isConnect()) {
				return '<a href="/MyWishList.app/compte">Connexion</a>';
			}
			else
				return '
				<a href="/MyWishList.app/compte">Mon Compte</a>
				<a href="/MyWishList.app/deconnection">Deconnexion <i class="step fi-power size-24"></i></a>';
		}

}
