<?php

require_once __DIR__ . '/vendor/autoload.php';

use wishlist\conf\ConnectionFactory as CF;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\User;

use wishlist\fonction\FctnItem as FI;
use wishlist\fonction\FctnListe as FL;
use wishlist\fonction\CreateurItem as CI;
use wishlist\fonction\GestionImage as GI;

use wishlist\pages\PageItem as PI;
use wishlist\pages\PageCompte as PC;

use wishlist\fonction\Authentification as AUTH;

use wishlist\divers\Outils;


session_start();

Outils::headerHTML("MyWishList");
Outils::menuHTML();

// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();

echo '<h1>Application MyWishList</h1>
	<div class="small button-group">
	  <a href="/MyWishList/liste" class="button">Listes publiques</a>
	  <a href="/MyWishList/add-liste-form" class="button">Créer une liste</a>
	</div>';

// connection utilisateur
$connected_user = AUTH::Identification();


$app = new \Slim\Slim();


if ($connected_user)
{
	echo '<h2>Ajouter une liste a votre compte utilisateur</h2>
				<form action="add-user" method="post">
					<p>Token privé de la liste : <br/><input type="text" name="token" /></p>
					<p><input class="button" type="submit" name="Ajouter liste" value="Ajouter au compte"></p>
				</form>';
} else {
}


//Affiche l'ensemble des listes
$app->get('/liste', function ()
{
	echo 'Accéder à une liste
				<form action"/liste/" method="get">
					<p>Token : <br/><input type="text" name="token" /></p>
					<p><input class="button" type="submit" value="Accès à la liste"></p>
				</form>';
    FL::allListe();
});
//Affiche une liste particulière lorsque le token est renseigné dans l'URL
$app->get('/liste/:one', function($token){
	FL::liste($token);
});

//Supprime un item de la liste (l'item ou juste effacer de la liste ?)
$app->get('/liste-remove/:item', function($item){
	FL::delItem($item);
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
$app->get('/deconnection', function(){
	AUTH::Deconnection();
});

// affiche details d'un compte
$app->get('/compte', function() {
	PC::displayCompte();
});

//  modifier un compte
$app->post('/edit-compte', function (){
	$_SESSION['compte_action'] = "edit";
	PC::displayCompte();
});

//  changer mot de passe
$app->post('/change-password-compte', function (){
	$_SESSION['compte_action'] = "change_password";
	PC::displayCompte();
});


// si url vide
$app->get('/', function (){
	echo 'Bienvenu sur l`utilitaire de liste de souhait.';
});

$app->run();

Outils::footerHTML();
