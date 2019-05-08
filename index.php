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

use wishlist\fonction\Authentification as AUTH;


session_start();

// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();


// connection utilisateur
$connected_user = AUTH::Identification();

if ($connected_user)
{
	// si connecté...
} else {
	AUTH::FormulaireConnection();
}

$app = new \Slim\Slim();

echo '<a href="../liste">Accueil</a></br>';


//Affiche l'ensemble des listes
$app->get('/liste', function ()
{
    FL::allListe();
});
//Affiche une liste particulière lorsque le token est renseigné dans l'URL
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

//Ajout un message à une liste
$app->post('/add-mess/:token', function($token){
  FL::addMessage($token);
});
//Rend la liste visible par tous
$app->post('/liste-published/:id', function($token){
  FL::publication($token);
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

// connection & inscription
$app->post('/connection', function(){
	if (isset($_POST['signin']))
		AUTH::Connection($_POST['username'], $_POST['password']);
	else if (isset($_POST['signup']))
    	AUTH::Inscription($_POST['username'], $_POST['password']);
	header("/");
});

// deconnection
$app->post('/deconnection', function(){
	AUTH::Deconnection();
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
