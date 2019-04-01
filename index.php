<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\conf\ConnectionFactory as CF;

// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();


$app = new \Slim\Slim();
$app->get('/liste', function ()
{
          $lists=Liste::get();
          echo "<h1>Listes de souhaits</h1>"; // HTML CODE titre1
          foreach ($lists as $key => $value)
          {
            echo "<h2></br>No : " . $value->no . "<br/>Titre : " . $value->titre . "<br/></h2>"; // HTML CODE titre2
            $itemlist=$value->item;

            echo "<ul>"; // HTML CODE debut liste
            foreach($itemlist as $item)
            {
                echo "<li>Item id : " . $item->id . "<br/>Nom de l'objet : " . $item->nom . "<br/></li>"; // HTML CODE li
            }
            echo "</ul>"; // HTML CODE fin liste

          }
});

/* enter code here if you want to use slim (and uncomment next line) */
$app->run();

/* or here if you don't want to use it... */
