<?php

namespace wishlist\fonction;

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use wishlist\divers\Outils;

use wishlist\modele\User;


class Authentification {

	public static function Identification() {
		if (SELF::isConnect()) {
			$user = Sentinel::findById($_SESSION['wishlist_userid']);

			if ($user) return $user;
		}
		return null;
	}

	public static function FormulaireConnection() {
		echo '
		<div class= "row column align-center medium-6 large-4">
			<form action="connection" method="post" class="log-in-form">

				<h4 class="text-center">Connection / Inscription</h4>';

		Alerte::getWarningAlert("username_already_existe", "L'identifiant est déjà utilisé");
		Alerte::getErrorAlert("username_invalid", "L'identifiant doit contenir de 3 à 20 caractères, et aucuns caractère spécial");
		Alerte::getErrorAlert("password_invalid", "Le mot de passe doit contenir de 6 à 30 caractères");
		Alerte::getErrorAlert("authentification_fail", "Identifiant ou mot de passe erroné");
		Alerte::getSuccesAlert("password_change", "Mot de passe modifié. Veuillez vous reconnecter");

		echo '
				<label>Username
					<input type="text" name="username" placeholder="MyPseudo" required/>
				</label>

				<label>Password
					<input type="password" name="password" placeholder="Mot de passe" required/>
				</label>

				<input type="submit" class="button expanded" name="" value="Connection"/>
			</form>
			<form action="auth-inscription" method="get" class="log-in-form">
				<input type="submit" class="button expanded" name="" value="Inscription"/>
			</form>
		</div>';
	}

	public static function Connection($username, $password) {
		$username = htmlspecialchars($username);
		$password = htmlspecialchars($password);
		$credentials = [
			'email'    => $username,
			'password' => $password,
		];
		$user = Sentinel::authenticate($credentials);
		if (!$user) {
			Alerte::set('authentification_fail');
			Outils::goTo('compte', 'Erreur authentification');
		} else {
			$_SESSION["wishlist_userid"] = $user->id;
			$_SESSION["wishlist_username"] = $user->email;
			Outils::goTo('index.php', 'Authentification reussi, Redirection en cours..');
		}
	}

	public static function FormulaireInscription() {
		echo '
		<div class= "row column align-center medium-6 large-4">
			<form action="connection" method="post" class="log-in-form">

				<h4 class="text-center">Connection / Inscription</h4>';

		Alerte::getWarningAlert("username_already_existe", "L'identifiant est déjà utilisé");
		Alerte::getErrorAlert("username_invalid", "L'identifiant doit contenir de 3 à 20 caractères, et aucuns caractère spécial");
		Alerte::getErrorAlert("password_invalid", "Le mot de passe doit contenir de 6 à 30 caractères");

		echo '
				<label>Username
					<input type="text" name="username" placeholder="MyPseudo*" required/>
				</label>

				<label>Username
					<input type="text" name="last_name" placeholder="Nom*" required/>
				</label>

				<label>Username
					<input type="text" name="first_name" placeholder="Prenom*" required/>
				</label>

				<label>Password
					<input type="password" name="password" placeholder="Mot de passe*" required/>
				</label>

				<label>Password
					<input type="password" name="passwordConf" placeholder="Confirmer mot de passe*" required/>
				</label>

				<input type="submit" class="button expanded" name="signin" value="Connection"/>


			</form>
			<form action="auth-connexion" method="get" class="log-in-form">
				<input type="submit" class="button expanded" name="signup" value="Inscription"/>
			</form>
		</div>';
	}

	public static function Inscription($username, $password) {

		$username = htmlspecialchars($username);
		$password = htmlspecialchars($password);

		if (!SELF::usernameIsConform($username)) {
			Outils::goTo("compte", "Nom d'utilisateur invalide");
			exit();
		} else if (!SELF::passwordIsConform($password)) {
			Outils::goTo("compte", "Mot de passe invalide");
			exit();
		} else if (!SELF::usernameIsUnique($username)) {
			Outils::goTo("compte", "Nom d'utilisateur déjà utilisé");
			exit();
		} else {
			Sentinel::registerAndActivate([
    			'email'    => $username,
    			'password' => $password,
			]);
			Outils::goTo('compte', 'Compte crée ! Veuillez vous authentifier.');
		}
	}

	public static function Deconnection() {
		$_SESSION["wishlist_userid"] = null;
		Outils::goTo('index.php', 'Deconnecté. Redirection en cours..');
	}

	public static function passwordEditForm() {
		echo '<div class= "row align-center medium-5 large-3">';
		Alerte::getErrorAlert("password_invalid", "Le mot de passe doit contenir de 6 à 30 caractères");
		Alerte::getErrorAlert("pass_not_match", "Les nouveaux mot de passes doivent être identique");
		Alerte::getErrorAlert("authentification_fail", "Mot de passe erroné");
		echo '
		</div>
		<form action="change-password" method="post">
			<div class= "row align-center medium-5 large-3">
				<input type="text" name="oldPassword" placeholder="Ancien mot de passe*" required/>
			</div>
			<div class= "row align-center medium-5 large-3">
				<input type="text" name="newPassword" placeholder="Nouveau mot de passe*" required/>
			</div>
			<div class= "row align-center medium-5 large-3">
				<input type="text" name="newPasswordConf" placeholder="Confirmer mot de passe*" required/>
			</div>
			<div class="row align-left medium-5 large-3">
				<button type="submit" class="button" name="">Changer mot de passe</button>
			</div>
		</form>';
	}

	public static function passwordEdit() {
		$oldPassword = htmlspecialchars($_POST['oldPassword']);
		$newPassword = htmlspecialchars($_POST['newPassword']);
		$newPasswordConf = htmlspecialchars($_POST['newPasswordConf']);

		if ($newPassword != $newPasswordConf) {
			Alerte::set('pass_not_match');
			Outils::goTo("compte", "Nouveaux mot de passe pas identiques");
			exit();
		}

		if (!SELF::passwordIsConform($newPassword)) {
			Alerte::set('password_invalid');
			Outils::goTo("compte", "Mot de passe invalide");
			exit();
		}

		$user = Sentinel::findById($_SESSION['wishlist_userid']);

		$hasher = Sentinel::getHasher();
		if (!$hasher->check($_POST['oldPassword'], $user->password)) {
			Alerte::set('authentification_fail');
			Outils::goTo("compte", "Mot de passe érroné");
			exit();
        }
		Sentinel::update($user, array('password' => $newPassword));
		$_SESSION["wishlist_userid"] = null;
		Alerte::set('password_change');
		Outils::goTo('compte', 'Mot de passe modifié ! Veuillez vous réauthentifier');
	}

	public static function isConnect() {
		if (isset($_SESSION["wishlist_userid"]) && $_SESSION["wishlist_userid"] != null) {
			return true;
		} else {
			return false;
		}
	}

	public static function menuDisplay($arbo) {
		if (!SELF::isConnect()) {
			return '<a href="' . $arbo .'compte">Connexion</a>';
		} else {
			return '
				<ul class="dropdown menu align-right" data-dropdown-menu>
					<li>
						<a href="">Connecté en tant que <strong><i>' . $_SESSION['wishlist_username'] . '</i></strong></a>
						<ul class="menu">
							<li><a href="' . $arbo .'compte">Mon Compte</a></li>
							<li><a href="' . $arbo .'deconnection">Deconnexion <i class="step fi-power size-24"></i></a></li>
						</ul>
					</li>
				</ul>';
		}
	}

	public static function usernameIsConform($username) {
		$size = strlen($username);
		if (($size < 3 || $size > 20) || (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))) {
			Alerte::set('username_invalid');
			return false;
		}
		return true;
	}

	public static function passwordIsConform($password) {
		$size = strlen($password);
		if ($size < 6 && $size > 30) {
			Alerte::set('password_invalid');
			return false;
		}
		if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
			Alerte::set('password_invalid');
			return false;
		}
		return true;
	}

	public static function usernameIsUnique($username) {
		$user = User::select('id')
			->where('email', 'like', $username)
			->first();

		if ($user) {
			Alerte::set('username_already_existe');
			return false;
		}
		return true;
	}

	public static function deleteUser() {
		$user = Sentinel::findById($_SESSION['wishlist_userid']);
		$user->delete();
		$_SESSION["wishlist_userid"] = null;
	}
}
