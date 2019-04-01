<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\conf\ConnectionFactory as CF;

use wishlist\fonction\DetailsItem as DI;
use wishlist\fonction\Identification as LOG;

if(isset($_POST['username']) && isset($_POST['password']))
{
    //$user = new User();
}
else
    echo "Erreur dans le formulaire";
