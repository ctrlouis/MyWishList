<?php

namespace wishlist\fonction;

use wishlist\modele\Item;

// https://openclassrooms.com/fr/courses/1085676-upload-de-fichiers-par-formulaire
class GestionImage {

	public static function imageUploadForm($item_name)
	{
		echo '<div class= "row align-center medium-8 large-6">';
		Alerte::getErrorAlert("transfer_error", "Erreur lors du transfert, veuillez réessayer");
		Alerte::getErrorAlert("max_file_size", "L'image peut peser 10mo max");
		Alerte::getErrorAlert("invalide_extension", "Selectionnez une image en .jpg .jpeg .gif .png");
		echo '</div>';
		echo '
			<form method="post" action="../upload-image/' . $item_name . '" enctype="multipart/form-data">
				<div class= "row align-center medium-6 large-4">
					<div class="columns small-12 medium-expand">
						<button type="submit" class="button" name="submit">
							<div class ="row">
								<div class="columns small-2 fi-pencil"></div>
								<div class="columns">Modifier image</div>
							</div>
						</button>
					</div>
					<div class="columns small-12 medium-expand">
						<label for="icone" class="button">
						<div class ="row">
							<div class="columns small-2 fi-folder-add large"></div>
							<div class="columns">Selectionnez</div>
						</div>
						</label>
						<input type="file" class="show-for-sr" name="icone" id="icone" />
					</div>
				</div>
			</form>';
	}

	public static function imageUpload($item)
	{
		if (SELF::imageVerify($_FILES)) {
			if ($item->img) unlink($item->img);
			if (!is_dir('img/')) mkdir('img/');

			$nom = "img/$item->id-icone.png";
			$resultat = move_uploaded_file($_FILES['icone']['tmp_name'],$nom);
			if ($resultat) echo "Transfert réussi";

			$item->img = $nom;
			$item->save();
		}
	}

	public static function imageDeleteForm($item_name)
	{
		echo '
			<form action="../delete-image/' . $item_name . '" method="POST">
				<div class= "row align-center medium-6 large-4">
					<div class="columns small-12 medium-expand">
						<button type="submit" class="alert button">
							<div class ="row">
								<div class="columns small-2 fi-trash large"></div>
								<div class="columns">Supprimer image</div>
							</div>
						</button>
					</div>
				</div>
			</form>';
	}

	public static function imageDelete($item)
	{
		if ($item->img) unlink($item->img);
		$item->img = NULL;
		$item->save();
	}

	public static function imageVerify($file)
	{
		if ($_FILES['icone']['error'] > 0) {
			Alerte::set('transfer_error');
			return false;
		}

		if ($_FILES['icone']['size'] > 10000000) {
			Alerte::set('max_file_size');
			return false;
		}

		$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
		$extension_upload = strtolower(  substr(  strrchr($_FILES['icone']['name'], '.')  ,1)  );
		if ( !in_array($extension_upload, $extensions_valides) ) {
			Alerte::set('invalide_extension');
			return false;
		}

		return true;
	}

}
