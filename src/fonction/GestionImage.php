<?php

namespace wishlist\fonction;

use wishlist\modele\Item;

// https://openclassrooms.com/fr/courses/1085676-upload-de-fichiers-par-formulaire
class GestionImage {

	public static function imageUploadForm($item_name)
	{
			echo '
				<form method="post" action="../upload-image/' . $item_name . '" enctype="multipart/form-data">
					<div class= "row align-center medium-6 large-4">
						<div class="columns small-12 medium-expand">
							<button type="submit" class="button" name="submit">Modifier image</button>
						</div>
						<div class="columns small-12 medium-expand">
							<label for="icone" class="button">Selectionner un fichier...</label>
							<input type="file" class="show-for-sr" name="icone" id="icone" />
						</div>
					</div>
				</form>';
	}

	public static function imageUpload($item)
	{
		// si une erreur est survenu
		$erreur = SELF::imageVerify($_FILES);
		if ($erreur) {
			echo $erreur;
			exit;
		}

		if(!is_dir('img/')){
   			mkdir('img/');
		}

		$nom = "img/$item->id-icone.png";
		$resultat = move_uploaded_file($_FILES['icone']['tmp_name'],$nom);
		if ($resultat) echo "Transfert réussi";

		$item->img = $nom;
		$item->save();
		echo 'Item modifié';
	}

	public static function imageVerify($file)
	{
		echo $file['icone']['name'] . '<br/>' .		//Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
			$file['icone']['type'] . '<br/>' .		//Le type du fichier. Par exemple, cela peut être « image/png ».
			$file['icone']['size'] . '<br/>' .		//La taille du fichier en octets.
			$file['icone']['tmp_name'] . '<br/>' .	//L'adresse vers le fichier uploadé dans le répertoire temporaire.
			$file['icone']['error'];					//Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

		if ($_FILES['icone']['error'] > 0) {
			$erreur = "Erreur lors du transfert";
		}

		//if ($_FILES['icone']['size'] > $maxsize) $erreur = "Le fichier est trop gros";

		$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
		$extension_upload = strtolower(  substr(  strrchr($_FILES['icone']['name'], '.')  ,1)  );
		if ( !in_array($extension_upload, $extensions_valides) ) {
			return "Extension invalide";
		}

		/*$image_sizes = getimagesize($_FILES['icone']['tmp_name']);
		if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) return "Image trop grande";*/

		return null;

	}

	public static function imageDeleteForm($item_name)
	{
		echo '
			<form action="../delete-image/' . $item_name . '" method="POST">
				<div class= "row align-center medium-6 large-4">
					<div class="columns small-12 medium-expand">
						<button type="submit" class="alert button">Delete image</button>
					</div>
				</div>
			</form>';
	}

	public static function imageDelete($item)
	{
		$item->img = NULL;
		$item->save();
		echo "Image supprimé";
	}

}
