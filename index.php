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
          $list=Liste::first();
          $itemlist=$list->item;
          echo "<h1>Liste de souhait</h1>";
          foreach ($lists as $key => $value)
          {
            echo "</br>No : " . $lists[$key]->no . "<br/>Titre : " . $lists[$key]->titre . "<br/>";
            foreach($itemlist as $key1 => $value1)
            {
                echo "Item id : " . $itemlist[$key1]->id . "<br/>Nom de l'objet : " . $itemlist[$key1]->nom . "<br/>";
            }
          }
});

/* enter code here if you want to use slim (and uncomment next line) */
$app->run();

/* or here if you don't want to use it... */
