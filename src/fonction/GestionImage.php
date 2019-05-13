<?php

namespace wishlist\fonction;

use wishlist\modele\Item;

// https://openclassrooms.com/fr/courses/1085676-upload-de-fichiers-par-formulaire
class GestionImage {

	public static function imageUploadForm($item_name)
	{
		echo '<form method="post" action="../upload-image/' . $item_name . '" enctype="multipart/form-data">
     			<label for="icone">Icône du fichier (JPG, PNG ou GIF | max. 15 Ko) :</label><br />
     			<input type="file" name="icone" id="icone" /><br />
     			<input type="submit" name="submit" value="Envoyer" />
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

	/*public static function picUpdate()
	{
		echo '<form action="connection" method="post">
			<p>Username : <input type="text" name="username" /></p>
			<p>Password : <input type="text" name="password" /></p>
			<p><input type="submit" name="signin" value="Sign in">
			<input type="submit" name="signup" value="Sign up"></p>
			</form>';
	}*/

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
		echo '<form action="../delete-image/' . $item_name . '" method="POST">
				<input type="submit" name="" value="Delete image" >
			</form>';
	}

	public static function imageDelete($item)
	{
		$item->img = NULL;
		$item->save();
		echo "Image supprimé";
	}

}
