<?php

namespace factcli\divers;


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
                <link href="src/divers/style.css" rel="stylesheet" type="text/css">
            </head>
            <body>';
    }

    public static function footerHTML()
    {
        echo '</body></html>';
    }

		public function generateToken()
		{
			return base_convert(hash('sha256', time() . mt_rand()), 16, 36);
		}

}
