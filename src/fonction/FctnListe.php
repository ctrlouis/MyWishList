<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;

use wishlist\divers\Outils;


class FctnListe {

	public static function listeAddForm ()
	{
		echo '<form action="add-liste" method="post">
			<p>Titre : (obligatoire)<br/><input type="text" name="titre" /></p>
			<p>Utilisateur : <br/><input type="number" name="user_id" /></p>
			<p>Description : <br/><input type="text" name="description" /></p>
			Format de la date dexpiration (YYYY-MM-DD)
			<p>Date dexpiration : <br/><input type="date" min=' . date('Y-m-d') . ' name="expiration" /></p>
			<p><input type="submit" name="Ajouter liste"></p>
			</form>';
	}

	public static function listeAdd ()
	{
		// stop si un champ requis vide
		if (!$_POST['titre']) {
			echo 'Création impossible, le champ requis est vide.'; //alerte
			exit();
		}

		// stop si une liste avec le même nom existe deja
		$test = Liste::where('titre', 'like', $_POST['titre'])->first();
    	if ($test) {
        	echo 'Une liste avec le même nom existe déjà'; // alerte
			exit();
    	}

		// creation d'une liste
		$liste = new Liste();
		$liste->titre = htmlspecialchars($_POST['titre']);
		$liste->description = htmlspecialchars($_POST['description']);
		$liste->user_id = htmlspecialchars($_POST['user_id']);
		$liste->expiration = htmlspecialchars($_POST['expiration']);
		$liste->token_private = Outils::generateToken();
		$liste->save();
		echo '<a href ="edit-liste-form/' . $liste->token_private . '">URL de modification : </a>';
	}

	public static function listeEditForm ($token)
	{
		$liste = Liste::where('token_private', 'like', $token)->first();

		if (!$liste) {
			echo 'Aucune liste trouvée'; // alerte
			exit();
		}

		//Affiche la liste séléctionner à l'aide du token
		echo "<h2></br>No : " . $liste->no .
						"<br/>Titre : " . $liste->titre .
						"<br/>
					</h2>";

		$_SESSION['wishlist_liste_token'] = $liste->token_private;

		echo '<form action="../edit-liste/'. $token .'" method="post">
			<p>Titre : <input type="text" name="titre" /></p>
			<p>Utilisateur : <br/><input type="number" name="user_id" /></p>
			<p>Description : <br/><input type="text" name="description" /></p>
			<p><input type="submit" name="Modifier"></p>
			</form>';
	}

	public static function listeEdit ($token)
	{

		// stop si pas de token renseigné
		if (!isset($_SESSION['wishlist_liste_token'])) {
			echo 'Token erroné';

		}

		if (!$_POST['titre'] && !$_POST['description'] && !$_POST['user_id'] && !$_POST['url']) {
			echo 'Aucunes modification effectué, pas de champs renseigné.'; //alerte

		}

		$liste = Liste::where('token_private', 'like', $_SESSION['wishlist_liste_token'])
						 ->first();

		// stop si aucuns item trouvé
		if (!$liste) {
			echo 'Aucune liste trouvé';
			exit();
		}

			echo "Modifications effectuées sur la liste " . $liste->titre;
			$liste->titre = htmlspecialchars($_POST['titre']);
			$liste->description = htmlspecialchars($_POST['description']);
			$liste->user_id = htmlspecialchars($_POST['user_id']);
			$liste->save();
    }

    public static function liste()
    {
        $lists=Liste::get();
        echo "<h1>Listes de souhaits</h1>"; // HTML CODE titre1
        foreach ($lists as $key => $value)
        {

            echo "<h2></br>No : " . $value->no .
            "<br/>Titre : " . $value->titre .
            "<br/></h2>";

            $itemlist=$value->item;
            echo "<ul>"; // HTML CODE debut liste
            foreach($itemlist as $item)
            {
                echo "<li>Item id : " . $item->id .
                "<br/>Nom de l'objet : ". $item->nom .
                "<br/><a href=item/". $item->name .">Details</a><br/>
                </li>";
            }
            echo "</ul>"; // HTML CODE fin liste
        }
    }


}
