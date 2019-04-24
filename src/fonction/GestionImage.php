<?php

namespace wishlist\fonction;

// https://openclassrooms.com/fr/courses/1085676-upload-de-fichiers-par-formulaire
class GestionImage {

	public static function imageUploadForm()
	{
		echo '<form method="post" action="upload-image" enctype="multipart/form-data">
     			<label for="icone">Icône du fichier (JPG, PNG ou GIF | max. 15 Ko) :</label><br />
     			<input type="file" name="icone" id="icone" /><br />
     			<input type="submit" name="submit" value="Envoyer" />
			</form>';
	}

	public static function imageUpload()
	{
		/*echo $_FILES['icone']['name'] . '<br/>' .		//Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
			$_FILES['icone']['type'] . '<br/>' .		//Le type du fichier. Par exemple, cela peut être « image/png ».
			$_FILES['icone']['size'] . '<br/>' .		//La taille du fichier en octets.
			$_FILES['icone']['tmp_name'] . '<br/>' .	//L'adresse vers le fichier uploadé dans le répertoire temporaire.
			$_FILES['icone']['error'];					//Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.*/
	}

	public static function picUpdate()
	{
		echo '<form action="connection" method="post">
			<p>Username : <input type="text" name="username" /></p>
			<p>Password : <input type="text" name="password" /></p>
			<p><input type="submit" name="signin" value="Sign in">
			<input type="submit" name="signup" value="Sign up"></p>
			</form>';
	}

	public static function imageVerify($file)
	{
		echo $_FILES['icone']['name'] . '<br/>' .		//Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
			$_FILES['icone']['type'] . '<br/>' .		//Le type du fichier. Par exemple, cela peut être « image/png ».
			$_FILES['icone']['size'] . '<br/>' .		//La taille du fichier en octets.
			$_FILES['icone']['tmp_name'] . '<br/>' .	//L'adresse vers le fichier uploadé dans le répertoire temporaire.
			$_FILES['icone']['error'];					//Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
	}

	public static function picDelete()
	{
		echo '<form action="connection" method="post">
			<p>Username : <input type="text" name="username" /></p>
			<p>Password : <input type="text" name="password" /></p>
			<p><input type="submit" name="signin" value="Sign in">
			<input type="submit" name="signup" value="Sign up"></p>
			</form>';
	}

}
