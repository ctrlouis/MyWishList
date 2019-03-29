<?php

require_once __DIR__ . '/vendor/autoload.php';

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\conf\ConnectionFactory as CF;

// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();


$app = new \Slim\Slim();

/* enter code here if you want to use slim (and uncomment next line) */

//$app->run();

/* or here if you don't want to use it... */