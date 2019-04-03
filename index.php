<?php

require_once __DIR__ . '/vendor/autoload.php';

//use Illuminate\Database\Capsule\Manager as DB;
use wishlist\conf\ConnectionFactory as CF;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;

use wishlist\fonction\FctnItem as FI;
use wishlist\fonction\Identification as LOG;


// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();


// connection utilisateur
$connected_user = LOG::Identification();
//if (!$connected) LOG::FormulaireConnection();
echo '<br/>';

if ($connected_user)
{
	// si connecté...
}

$app = new \Slim\Slim();

$app->get('/liste', function ()
{
	$lists=Liste::get();
	echo "<h1>Listes de souhaits</h1>"; // HTML CODE titre1
	foreach ($lists as $key => $value)
    {

	    echo "<h2></br>No : " . $value->no .
	        "<br/>Titre : " . $value->titre .
	        "<br/></h2>";

		$itemlist=$value->item;
	    echo "<ul>"; // HTML CODE debut liste
	    foreach($itemlist as $item)
	    {
	        echo "<li>Item id : " . $item->id .
	            "<br/>Nom de l'objet : ". $item->nom .
	            "<br/><a href=details/". $item->id .">Details</a><br/>
	            </li>";
	    }
	    echo "</ul>"; // HTML CODE fin liste

	}
});

// Affiche les details d'un item
$app->get('/details/:id', function ($item_id){
	FI::displayDetails($item_id);
});

// Reserver un item
$app->post('/reserver/:item_id', function ($item_id){
	FI::reserver($item_id);
});

//connection
$app->post('/connection', function(){
	if (isset($_POST['signin']))
		LOG::Connection($_POST['username'], $_POST['password']);
	else if (isset($_POST['signup']))
    	LOG::Inscription($_POST['username'], $_POST['password']);
	header("/");
});

// si url vide
$app->get('/', function (){
	  echo '/liste -> affiche les listes';
});

$app->run();
