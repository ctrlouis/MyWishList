<?php

namespace wishlist\divers;

class Bouton {

	public static function imageDelete($item_name) {
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
	
}
