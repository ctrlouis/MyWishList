<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\fonction\CreateurItem as CI;
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
		$_SESSION['wishlist_liste_token'] = $liste->token_private;
		echo '<a href ="liste/' . $liste->token_private . '">URL de la liste : </a>';
	}

	public static function rendPublic($token)
	{
		$liste = Liste::where('token_private', 'like', $token)
						 ->first();
		if (isset($liste->token_publique))
			echo 'Liste déjà public';
		else
		{
			$liste->token_publique = Outils::generateToken();
			$liste->save();
		}
		echo 'La liste à était rendu publique</br>
					<a href="../liste">Aller vers les listes publiques</a>';
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

		//Affiche chaque liste publiques existante avec leur items correspondants
    public static function allListe()
    {
        $lists=Liste::whereNotNull('token_publique')->get();
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

		//Affiche une liste particulière, gére la modification de la liste si..
		//..token_private dans la variable de session
		public static function liste($token)
		{
			  $liste = Liste::where('token_private', 'like', $token)->first();

				//Si la liste n'existe pas
				if (!$liste)
				{
					$liste = Liste::where('token_publique', 'like', $token)->first();
					if (!$liste)
					{
						echo 'Aucune liste trouvée'; // alerte
						exit();
					}
					else
					{
						$_SESSION['wishlist_liste_token'] = $liste->token_publique;
					}
				}
				else
				{
					$_SESSION['wishlist_liste_token'] = $liste->token_private;
				}

				$itemlist=$liste->item;
				echo "<h1>Nom de la liste : " . $liste->titre . "</h1>"; // HTML CODE titre1
				echo "<ul>"; // HTML CODE debut liste
				foreach($itemlist as $item)
						{
							echo '<li>Item id : ' . $item->id .
							'<br/>Nom de l\'objet : '. $item->nom .
							'<br/><a href="../item/'. $item->nom .'">Details</a><br/>
							</li>';
						}
				echo "</ul>"; // HTML CODE fin liste
				if($liste->token_private == $_SESSION['wishlist_liste_token'])//Si le tokenprivé est renseigner, on peut modifier la liste et ajouter des items
				{
					echo 'Modification de la liste</br>
						<form action="../edit-liste/'. $token .'" method="post">
						<p>Titre : <input type="text" name="titre" /></p>
						<p>Utilisateur : <br/><input type="number" name="user_id" /></p>
						<p>Description : <br/><input type="text" name="description" /></p>
						<p><input type="submit" name="Modifier"></p>
						</form></br>
						Ajouter d un item dans votre liste';
					CI::itemAddForm ();

					//javascript bouton qui copie le lien publique de la liste
					/*echo '<script type="text/javascript" src="FonctionListe.js"></script>';  //Importation de fichier JS cause des erreurs
					echo '<input type="text" value="'. $liste->token_publique .'" id="publicListe">';
					echo '<button id="bouttonCopie">Copie le lien vers la liste pulbique</button>';*/

					echo "</br><a href=" . $liste->token_publique . ">Lien publique de la liste</a>";

					echo '<form action="../liste-public/'. $token .'" method="post">
									<button type="submit">Rend la liste publique</button>
								</form>';
				}
			}
		}
