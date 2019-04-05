<?php

require_once __DIR__ . '/vendor/autoload.php';

//use Illuminate\Database\Capsule\Manager as DB;
use wishlist\conf\ConnectionFactory as CF;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;

// use wishlist\fonction\FctnItem as FI;
// use wishlist\fonction\FctnListe as FL;
// use wishlist\fonction\CreateurItem as CI;
use wishlist\pages\pageItem as PI;
use wishlist\fonction\GestionImage as GI;

// use wishlist\fonction\ParticipantItem as PI;

use wishlist\fonction\Identification as LOG;


session_start();

// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();

$_SESSION['liste_token'] = 'tokenlisteprivate2'; // TEST
$_SESSION['item_action'] = null;


// connection utilisateur
$connected_user = LOG::Identification();

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
	            "<br/><a href=item/". $item->name .">Details</a><br/>
	            </li>";
	    }
	    echo "</ul>"; // HTML CODE fin liste

	}
});


// Créer une liste
$app->get('/add-liste-form', function(){
	FL::listeAddForm();
});
$app->post('/add-liste', function(){
	FL::listeAdd();
});
$app->post('/edit-liste-form', function(){
	FL::listeEditForm();
});
$app->post('/edit-liste', function(){
	FL::listeEdit();
});


// créer un item
/*$app->get('/add-item-form', function (){
	CI::itemAddForm();
});
$app->post('/add-item', function (){
	CI::itemAdd();
});*/

// affiche les details d'un item
$app->get('/item/:name', function ($item_name){
	PI::displayItem($item_name);
});

// reserver un item
$app->post('/reserver/:name', function ($item_name){
	$_SESSION['item_action'] = "reserver";
	PI::displayItem($item_name);
});

//  modifier item
$app->post('/edit-item/:name', function ($item_name){
	CI::itemEdit($item_name);
});

// modifier un item
/*$app->get('/edit-item-form/:token', function ($token){
	CI::itemEditForm($token);
});*/


// uploader imager
$app->post('/upload-image', function (){
	GI::imageUpload();
});

// connection
$app->post('/connection', function(){
	if (isset($_POST['signin']))
		LOG::Connection($_POST['username'], $_POST['password']);
	else if (isset($_POST['signup']))
    	LOG::Inscription($_POST['username'], $_POST['password']);
	header("/");
});

// si url vide
$app->get('/', function (){
	echo '<br/>';
	echo '<a href="liste">affiche les listes<br/>';
	echo '<a href="add-item-form"> creer un item</a><br/>';
	echo '<a href="edit-item-form">modifier un item</a><br/>';
	echo '<a href="add-liste-form">creer une liste</a><br/>';
	echo '<a href="edit-item-form/*token*">modifier un item(token requis)</a><br/>';
});

$app->run();
