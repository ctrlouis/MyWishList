<?php

require_once __DIR__ . '/vendor/autoload.php';

//use Illuminate\Database\Capsule\Manager as DB;
use wishlist\conf\ConnectionFactory as CF;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;

use wishlist\fonction\FctnItem as FI;
use wishlist\fonction\FctnListe as FL;
use wishlist\fonction\CreateurItem as CI;
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
$_SESSION['item_action'] = null; // TEST


// connection utilisateur
$connected_user = LOG::Identification();

if ($connected_user)
{
	// si connecté...
}

$app = new \Slim\Slim();

//Affiche l'ensemble des listes
$app->get('/liste', function ()
{
    FL::allListe();
});
$app->get('/liste/:one', function($token){
	FL::liste($token);
});


// Créer une liste
$app->get('/add-liste-form', function(){
	FL::listeAddForm();
});
$app->post('/add-liste', function(){
	FL::listeAdd();
});

$app->post('/liste-public/:id', function($token){
  FL::rendPublic($token);
});


// créer un item
$app->get('/add-item-form', function (){
	CI::itemAddForm();
});
$app->post('/add-item', function (){
	CI::itemAdd();
});

// affiche les details d'un item
$app->get('/item/:name', function ($item_name){
	PI::displayItem($item_name);
});

// reserver un item
$app->post('/reserver/:name', function ($item_name){
	$_SESSION['item_action'] = "reserve";
	PI::displayItem($item_name);
});

//  modifier item
$app->post('/edit-item/:name', function ($item_name){
	$_SESSION['item_action'] = "edit";
	PI::displayItem($item_name);
});

// supprimer un item
$app->post('/delete-item/:name', function ($item_name){
	$_SESSION['item_action'] = "delete";
	PI::displayItem($item_name);
});

// uploader imager
$app->post('/upload-image/:name', function ($item_name){
	$_SESSION['item_action'] = "uploadImage";
	PI::displayItem($item_name);
});

// supprimer un item
$app->post('/delete-image/:name', function ($item_name){
	$_SESSION['item_action'] = "deleteImage";
	PI::displayItem($item_name);
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
	echo '<a href="add-liste-form">creer une liste</a><br/>';
	echo '<a href="liste/*token*">affiche un item(token requis, si variable de session correspondante modification effectuable)</a><br/>';
});

$app->run();
