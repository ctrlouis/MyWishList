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


$app = new \Slim\Slim();
echo '<h1>Application MyWishList</h1>
			<a href="/MyWishList/liste">Affichage des listes publiques</a></br>
			<a href="/MyWishList/add-liste-form">Crée une liste</a><br/>';

if ($connected_user)
{
	AUTH::FormulaireDeconnection();
	echo '<form action="add-user" method="post">
		<p>Token privé de la liste : <br/><input type="text" name="token" /></p>
		<p><input type="submit" name="Ajouter liste"></p>
		</form>';
} else {
	AUTH::FormulaireConnection();
}


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
$app->post('/add-user', function(){
	FL::addUser();
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
	echo 'Bienvenu sur l`utilitaire de liste de souhait.';
});

$app->run();
