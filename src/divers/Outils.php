<?php

namespace wishlist\divers;

use wishlist\fonction\Authentification as AUTH;

class Outils
{

    public static function headerHTML($title)
    {
        echo
            '<!DOCTYPE html>
            <html lang=\"fr\">
            <head>
                <meta charset=\"UTF-8\">
                <title>'.$title.'</title>
                <link href="/MyWishList/src/css/foundation.css" rel="stylesheet" type="text/css">
				<link href="/MyWishList/src/css/foundation-icons.css" rel="stylesheet"/>
				<link href="/MyWishList/src/css/style.css" rel="stylesheet" type="text/css">
            </head>
            <body>';
    }

	public static function menuHTML()
    {
		if (AUTH::isConnect()) $connect = "Connexion";
		else $connect = "Mon compte";
        echo
		'<div data-sticky-container>
  			<div class="title-bar" data-sticky data-options="marginTop:0;" style="width:100%">

	    		<div class="title-bar-left">
					<span class="title-bar-title">MyWishList</span>
					<a href="/MyWishList/">Accueil</a>
				</div>

	    		<div class="title-bar-right"> ' .
					AUTH::menuDisplay() . '
				</div>

  			</div>
		</div>';
    }

    public static function footerHTML()
    {
        echo '
			<script src="/MyWishList/src/js/jquery.js"></script>
	    	<script src="/MyWishList/src/js/what-input.js"></script>
	    	<script src="/MyWishList/src/js/foundation.js"></script>
	    	<script src="/MyWishList/src/js/app.js"></script>
		</body></html>';
    }

	public static function generateToken()
	{
		return base_convert(hash('sha256', time() . mt_rand()), 16, 36);
	}

	public static function listeExpiration($date_expiration)
	{
		if (date($date_expiration) < time())
			return true; // si la date expiration est passé
		else
			return false; // si la date expiration n'est pas passé
	}

	public static function clearSession($session_name_tab)
	{
		foreach ($session_name_tab as $session_name)
			$_SESSION[$session_name];
	}

}
