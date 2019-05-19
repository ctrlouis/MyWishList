<?php

namespace wishlist\divers;

use wishlist\fonction\Alerte;
use wishliste\divers\Outils;

class Formulaire {

	// #########
	// # LISTE #
	// #########

	//Formulaire pour ajouter une liste
	public static function creeListe() {
		echo '<form action="add-liste" method="post">
			<p>Titre : (obligatoire)<br/><input type="text" name="titre" /></p>
			<p>Description : <br/><input type="text" name="description" /></p>
			Format de la date dexpiration (YYYY-MM-DD)
			<p>Date dexpiration : <br/><input type="date" min=' . date('Y-m-d') . ' name="expiration" /></p>
			<p><input class="button" type="submit" name="Ajouter liste"></p>
		</form>';
	}

	//Ajoute la liste à son compte (pour le créateur)
	public static function ajouterListe() {
		echo '<h2>Ajouter une liste a votre compte utilisateur</h2>
	        <form action="add-user" method="post">
				<p>Token privé de la liste : <br/><input type="text" name="token" /></p>
				<p><input class="button" type="submit" name="Ajouter liste" value="Ajouter au compte"></p>
	        </form>';
	}

	public static function ajoutItem() {
	    Alerte::getErrorAlert("empty_field", "Les champs nom, description et tarifs sont obligatoire");
	    Alerte::getErrorAlert("liste_not_found", "Aucune liste spécifié pour l'ajout");
	    Alerte::getErrorAlert("already_exists", "L'item existe déjà dans cette liste");
	    Alerte::getErrorAlert("invalide_price", "Le prix doit être un nombre");
	    echo '
		<form action="../add-item" method="post">
			<p><input type="text" name="nom" placeholder="Nom*" required/></p>
			<p><br/><input type="text" name="descr" placeholder="Description*" required/></p>
			<p><br/><input type="number" name="tarif" placeholder="Prix*" step="0.01" required/></p>
			<p><br/><input type="text" name="url" placeholder="url"/></p>
			<p><input type="submit" class="button" name="Ajouter item" value="Ajouter item"></p>
		</form>';
	}

	public static function rechercheListe() {
		echo '<form action="liste" method="get">
				<div class="input-group input-group-rounded">
				<input class="input-group-field" type="search" placeholder="token de liste" name="token">
				<div class="input-group-button">
				<input type="submit" class="button secondary" value="Search">
				</div>
				</div>
			</form>';
	}


	// ####################
	// # AUTHENTIFICATION #
	// ####################

	public static function connection() {
		echo '
		<div class= "row column align-center medium-6 large-4">
			<form action="connection" method="post" class="log-in-form">

				<h4 class="text-center">Connection / Inscription</h4>';

		Alerte::getErrorAlert("field_missing", "Un ou plusieurs champs requis sont vide");
		Alerte::getErrorAlert("authentification_fail", "Identifiant ou mot de passe erroné");
		Alerte::getSuccesAlert("password_change", "Mot de passe modifié. Veuillez vous reconnecter");
		Alerte::getSuccesAlert("user_signup", "Compte crée ! Veuillez vous connecter");

		echo '
				<label>Username
					<input type="text" name="username" placeholder="MyPseudo" required/>
				</label>

				<label>Password
					<input type="password" name="password" placeholder="Mot de passe" required/>
				</label>

				<input type="submit" class="button expanded" name="signin" value="Connection"/>
			</form>
			<form action="auth-inscription" method="get" class="log-in-form">
				<input type="submit" class="hollow button success expanded" name="" value="Inscription"/>
			</form>
		</div>';
	}

	public static function inscription() {
		echo '
		<div class= "row column align-center medium-6 large-4">
			<form action="connection" method="post" class="log-in-form">

				<h4 class="text-center">Connection / Inscription</h4>';

			Alerte::getErrorAlert("field_missing", "Un ou plusieurs champs requis sont vide");
			Alerte::getWarningAlert("username_already_existe", "L'identifiant est déjà utilisé");
			Alerte::getErrorAlert("pass_not_match", "Les mots de passes doivent être identiques");
			Alerte::getErrorAlert("username_invalid", "L'identifiant doit contenir de 3 à 20 caractères, et aucuns caractère spécial");
			Alerte::getErrorAlert("password_invalid", "Le mot de passe doit contenir de 6 à 30 caractères, et au moins 1 caractère spécial");
			Alerte::getErrorAlert("name_invalid", "Le nom est prenom ne doit contenir que des lettres");

		echo '
				<label>Nom d\'utilisateur
					<input type="text" name="username" placeholder="MyPseudo*" required/>
				</label>

				<label>Nom
					<input type="text" name="last_name" placeholder="Nom*" required/>
				</label>

				<label>Prenom
					<input type="text" name="first_name" placeholder="Prenom*" required/>
				</label>

				<label>Mot de passe
					<input type="password" name="password" placeholder="Mot de passe*" required/>
				</label>

				<label>Confirmation de mot de passe
					<input type="password" name="passwordConf" placeholder="Confirmation de mot de passe*" required/>
				</label>

				<input type="submit" class="button expanded" name="signup" value="Inscription"/>


			</form>
			<form action="auth-connexion" method="get" class="log-in-form">
				<input type="submit" class="hollow button success expanded" name="" value="Connection"/>
			</form>
		</div>';
	}

}
