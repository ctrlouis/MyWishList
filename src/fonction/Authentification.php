<?php

namespace wishlist\fonction;

use Illuminate\Database\Capsule\Manager as DB;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

use wishlist\modele\User;
use wishlist\divers\Outils;


class Authentification {

		public static function Identification()
		{
			if (SELF::isConnect())
			{
				$user = Sentinel::findById($_SESSION['wishlist_userid']);

				if ($user) {
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
				$_SESSION["wishlist_username"] = $user->email;
				echo '
				<div class= "row column align-center medium-6 large-6">
					<h4>Authentification reussi, Redirection en cours..</h4>
				</div>';
				header('Refresh: 2; url=compte');
			}
			else {
				echo '
				<div class= "row column align-center medium-6 large-6">
					<h4>Erreur identifiants, veuillez rééssayer.</h4>
				</div>';
				header('Refresh: 2; url=compte');
			}
		}

		public static function Deconnection()
		{
			$_SESSION["wishlist_userid"] = null;
			echo '
			<div class= "row column align-center medium-6 large-6">
				<h4>Deconnecté. Redirection en cours..</h4>
			</div>';
			header('Refresh: 0; url=index.php');
		}

		public static function Inscription($username, $password)
		{
			$user = User::select('email')
				->where('email', 'like', $username)
				->first();

			if ($user) {
				echo '
				<div class= "row column align-center medium-6 large-6">
					<h4>Nom d\'utilisateur déjà utilisé. Veuillez chang.</h4>
				</div>';
				header('Refresh: 2; url=compte');
			} else {
				Sentinel::register([
	    			'email'    => $username,
	    			'password' => $password,
				]);
				echo '
				<div class= "row column align-center medium-6 large-6">
					<h4>Compte crée ! Veuillez vous authentifier.</h4>
				</div>';
				header('Refresh: 2; url=compte');
			}
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
				return '<a href="/MyWishList/compte">Connexion</a>';
			}
			else {
				return '
					<ul class="dropdown menu align-right" data-dropdown-menu>
						<li>
							<a href="">Connecté en tant que <strong><i>' . $_SESSION['wishlist_username'] . '</i></strong></a>
							<ul class="menu">
								<li><a href="/MyWishList/compte">Mon Compte</a></li>
								<li><a href="/MyWishList/deconnection">Deconnexion <i class="step fi-power size-24"></i></a></li>
							</ul>
						</li>
					</ul>';
			}
		}

}
