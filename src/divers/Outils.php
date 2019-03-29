<?php

namespace factcli\divers;


class Outils
{
	
    static function headerHTML($title)
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

    static function footerHTML()
    {
        echo '</body></html>';
    }

}