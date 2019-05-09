<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Message;
use wishlist\fonction\CreateurItem as CI;
use wishlist\modele\Reservation;
use wishlist\divers\Outils;


class FctnListe {
	//Formulaire pour ajouter une liste
	public static function listeAddForm ()
	{
		echo '<form action="add-liste" method="post">
			<p>Titre : (obligatoire)<br/><input type="text" name="titre" /></p>
			<p>Description : <br/><input type="text" name="description" /></p>
			Format de la date dexpiration (YYYY-MM-DD)
			<p>Date dexpiration : <br/><input type="date" min=' . date('Y-m-d') . ' name="expiration" /></p>
			<p><input type="submit" name="Ajouter liste"></p>
			</form>';
	}

	//Rediriger vers cette fonction par listeAddForm, crée la liste dans la base de donnée
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
        	echo 'Une liste avec le même nom existe déjà </br>
								<a href="add-liste-form">Retour vers la creation de liste</a>'; // alerte
			exit();
    	}

		if($_POST['expiration'] < date('Y-m-d'))
		{
			echo 'Date invalide ! </br>
						<a href="add-liste-form">Retour vers la creation de liste</a>';
		}
		else {
			// creation d'une liste
			$liste = new Liste();
			$liste->titre = htmlspecialchars($_POST['titre']);
			$liste->description = htmlspecialchars($_POST['description']);
			if(isset($_SESSION['wishlist_userid']))
				$liste->user_id = htmlspecialchars($_SESSION['wishlist_userid']);
			$liste->expiration = htmlspecialchars($_POST['expiration']);
			$liste->token_private = Outils::generateToken();
			$liste->token_publique = Outils::generateToken();
			$liste->save();
			$_SESSION['wishlist_liste_token'] = $liste->token_private;
			echo '<a href ="liste/' . $liste->token_private . '">URL de la liste : </a>';
		}
	}

	//Rediriger par un bouton lorsqu'on édite une liste, rend la liste public ou privée selon son état actuel
	public static function publication($token)
	{
		$liste = Liste::where('token_private', 'like', $token)
						 ->first();
		if ($liste->published == true)//Si la liste est publique elle deviendra privée
		{
			$liste->published = false;
			$liste->save();
			echo 'La liste a été rendu privée</br>
						<a href="../liste/'. $token .'">Retourner sur la liste</a>';
		}
		else
		{
			$liste->published = true;
			$liste->save();
			echo 'La liste a été rendu publique</br>';
		}

	}

	public static function addUser()
	{
		if($_SESSION["wishlist_userid"] != null)
		{
			if($_POST['token'] != null){
				$liste = Liste::where('token_private', 'like', $_POST['token'])->first();
				if($liste)
				{
					if ($liste->user_id == $_SESSION["wishlist_userid"]) {
						echo "Cette liste vous appartient déjà.";
					}
					else if($liste->user_id == null)
					{
						$liste->user_id = htmlspecialchars($_SESSION["wishlist_userid"]);
						$liste->save();
						echo 'La liste a bien été ajouter à votre compte';
					}
					else{
						echo "Cette liste appartient déjà à un autre utilisateur.";
					}
				}
				else {
					echo "Aucune liste correspond au token indiquer";
				}
			}
			else {
				echo "Aucun token introduit";
			}
		}
	}

	public static function listeEdit ($token)
	{
		// stop si pas de token renseigné
		if (!isset($_SESSION['wishlist_liste_token']))
		{
			echo 'Token erroné';
		}
		if (!$_POST['titre'] && !$_POST['description'] && !$_POST['user_id'] && !$_POST['url'])
		{
			echo 'Aucunes modification effectué, pas de champs renseigné.'; //alerte
		}
		$liste = Liste::where('token_private', 'like', $_SESSION['wishlist_liste_token'])
						 ->first();
		// stop si aucuns item trouvé
		if (!$liste)
		{
			echo 'Aucune liste trouvé';
			exit();
		}
		echo "Modifications effectuées sur la liste " . $liste->titre;
		$liste->titre = htmlspecialchars($_POST['titre']);
		$liste->description = htmlspecialchars($_POST['description']);
		$liste->save();
  }




		//Affiche chaque liste publiques existante avec leur items correspondants
    public static function allListe()
    {
				$_SESSION['wishlist_liste_token'] = null;
        $lists=Liste::where('published', 'like', '1')->orderBy('expiration', 'asc')->whereDate('expiration', '>', date('Y-m-d'))->get();
        echo "<h1>Listes de souhaits</h1>"; // HTML CODE titre
				if (sizeof($lists) == 0)
				{
					echo 'Aucune liste publique existante';
				}
        foreach ($lists as $key => $value)
        {//Si le token privée d'une liste est dans la variable de session, le lien menera vers la liste en mode édition
						if($_SESSION['wishlist_liste_token'] == $value->token_publique)
						{
							echo '</br>No : ' . $value->no .
	            '<br/><a href="liste/' . $value->token_publique . '">' . $value->titre .
	            '</a></br>';
						}
						else
						{
							echo '</br>No : ' . $value->no .
	            '<br/><a href="liste/' . $value->token_private . '">' . $value->titre .
	            '</a></br>';
						}
        }
    }


		public static function addMessage($token)
		{
			$liste = Liste::where('token_private', 'like', $token)->orWhere('token_publique', 'like', $token)->first();
			$message = new Message;
			$message->no_liste=htmlspecialchars($liste->no);
			$message->msg=htmlspecialchars($_POST['message']);
			$message->save();
			echo 'Message ajouté à la liste';
		}

		public static function delItem($id){
			$item = Item::where('id', '=', $id)->first();
			if($item)
			{
				$reservation = Reservation::where('item_id', '=', $item->id)->first();
				if($reservation->reservation == 1){
					echo "L'item ne peut être supprimé car il est déjà réservé";
				}
				else{
					$item->delete();
					echo 'Item supprimer';
				}
			}
			else {
				echo "Erreur item introuvable";
			}
			echo '<br/><a href="../liste/'. $_SESSION['wishlist_liste_token'] .'">Retourner sur la liste</a>';
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

				//Bouton permettant de basculer entre privée et publique
				if($liste->published == true)
				{
					echo '<form action="../liste-published/'. $token .'" method="post">
									<button type="submit">Rend la liste privée</button>
								</form>';
				}
				else {
					echo '<form action="../liste-published/'. $token .'" method="post">
									<button type="submit">Rend la liste publique</button>
								</form>';
				}

				//Affiche l'ensemble des items pour chaque liste
				$itemlist=$liste->item;
				$messlist=$liste->message;
				echo "<h1>Nom de la liste : " . $liste->titre . "</h1>"; // HTML CODE titre1
				echo "<ul>"; // HTML CODE debut liste
				foreach($itemlist as $item)
						{
							echo '<li>Item id : ' . $item->id . '
										  <a href="../item/'. $item->nom .'"> Details</a>
											<br/>Nom de l\'objet : '. $item->nom . '<br/>
										</li>
										<form action="../liste-remove/'. $item->id .'" method="get">
											<button type="submit">Supprimer l`item</button>
										</form>';
						}
				echo "Message : <br/>";

				//Affiche chaque message lié à la liste
				foreach ($messlist as $message)
				{
					echo '- ' . $message->msg . '<br/>';
				}

				echo "</ul>"; // HTML CODE fin liste

				//Ajout d'un message dans la liste
				echo 'Ajouter un message à la liste</br>
					<form action="../add-mess/'. $token .'" method="post">
						<p>Message : <input type="text" name="message" /></p>
						<p><input type="submit" name="Poster" value="Poster"></p>
					</form></br>';

				//Si le tokenprivé est renseigner, on peut modifier la liste et ajouter des items
				if($liste->token_private == $_SESSION['wishlist_liste_token'])
				{
					echo 'Modification de la liste</br>
						<form action="../edit-liste/'. $token .'" method="post">
							<p>Titre : <input type="text" name="titre" /></p>
							<p>Description : <br/><input type="text" name="description" /></p>
							<p><input type="submit" name="Modifier" value="Modifier"></p>
						</form></br>
					Ajouter d un item dans votre liste';
					CI::itemAddForm ();

					//Partage de la liste via le token
					echo '<h3>Token de partage<h3>
								<input type="text" value="'. $liste->token_publique .'" id="publicListe">
								<button id="bouttonCopie">Copier le lien de la liste</button>
								<script>
									function copyListeLink()
									{
										var copyText = document.getElementById("publicListe");
										copyText.select();
										document.execCommand("copy");
									}
									let copy = document.getElementById("bouttonCopie");
					  			copy.addEventListener("click", copyListeLink);
								</script>';

					//javascript bouton qui copie le lien publique de la liste
					/*echo '<script type="text/javascript" src="FonctionListe.js"></script>';  //Importation de fichier JS cause des erreurs

					echo '<button id="bouttonCopie">Copie le lien vers la liste pulbique</button>';*/



				}
			}
		}
