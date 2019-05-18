<?php

namespace wishlist\divers;

use wishlist\fonction\Alerte;
use wishliste\divers\Outils;

class Formulaire{

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

}
