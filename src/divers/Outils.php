<?php

namespace wishlist\divers;

use wishlist\fonction\Authentification as AUTH;

class Outils
{

	public static function getArbo() {
		return '/MyWishList/';
	}

    public static function headerHTML($title)
    {
		$arbo = SELF::getArbo();
        echo
            '<!DOCTYPE html>
            <html lang=\"fr\">
            <head>
                <meta charset=\"UTF-8\">
                <title>'.$title.'</title>
                <link href="' . $arbo .'src/css/foundation.css" rel="stylesheet" type="text/css">
				<link href="' . $arbo .'src/css/foundation-icons.css" rel="stylesheet"/>
				<link href="' . $arbo .'src/css/style.css" rel="stylesheet" type="text/css">
            </head>
            <body>';
    }

	public static function menuHTML()
    {
		$arbo = SELF::getArbo();
        echo
		'<div data-sticky-container>
  			<div class="title-bar" data-sticky data-options="marginTop:0;" style="width:100%">
		    	<div class="title-bar-left">
					<a class="item" href="' . $arbo .'"><i class="fi-home"></i> Accueil</a>
				</div>
		        <div class="title-bar-center">
		          <span class="title-bar-title">MyWishList</span>
		        </div>
		    	<div class="title-bar-right"> ' .
					AUTH::menuDisplay($arbo) . '
				</div>
  			</div>
		</div>
		<div class="app">';
    }

    public static function footerHTML()
    {
        echo '
				</div>
			<script src="/MyWishList/src/js/jquery.js"></script>
	    	<script src="/MyWishList/src/js/what-input.js"></script>
	    	<script src="/MyWishList/src/js/foundation.js"></script>
	    	<script src="/MyWishList/src/js/app.js"></script>
		</body></html>';
    }

	public static function goTo($link, $message, $time=0) {
		echo '
		<div class= "row column align-center medium-6 large-6">
			<h4>' . $message . '</h4>
		</div>';
		header('Refresh: ' . $time . '; url='. $link);
	}

	public static function generateToken()
	{
		return base_convert(hash('sha256', time() . mt_rand()), 16, 36);
	}

	public static function listeExpiration($date_expiration)
	{
    $date = date('Y-m-d');
		if (date($date_expiration) < date($date)){
      return true; // si la date expiration est passé
    }
		else
			return false; // si la date expiration n'est pas passé
	}

	public static function clearSession($session_name_tab)
	{
		foreach ($session_name_tab as $session_name)
			$_SESSION[$session_name];
	}

}
