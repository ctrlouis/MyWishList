<?php

require_once __DIR__ . '/vendor/autoload.php';

use wishlist\conf\ConnectionFactory as CF;
use wishlist\divers\Outils;
use wishlist\divers\Formulaire;

use wishlist\fonction\Authentification as AUTH;
use wishlist\fonction\Alerte;
use wishlist\fonction\FctnListe as FL;
use wishlist\fonction\FctnCagnotte as CG;
use wishlist\fonction\CreateurItem as CI;
use wishlist\fonction\GestionImage as GI;

use wishlist\pages\PageItem as PI;
use wishlist\pages\PageCompte as PC;


session_start();

Outils::headerHTML("MyWishList");
Outils::menuHTML();

// Connection base de données
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();


$app = new \Slim\Slim();

// ###########
// # ACCUEIL #
// ###########
$app->get('/', function () {
	Alerte::clear();
	echo '<h4>Bienvenu sur l`utilitaire de liste de souhait.</h4>';
	Formulaire::rechercheListe();
	echo '
		<div class="small button-group">
		  <a href="/MyWishList/liste" class="button">Listes publiques</a>
		  <a href="/MyWishList/add-liste-form" class="button">Créer une liste</a>
		</div>';

});


// #########
// # LISTE #
// #########

// Affiche l'ensemble des listes
$app->get('/liste', function () {
		Formulaire::rechercheListe();
    FL::displayAll();
});
// Affiche une liste particulière lorsque le token est renseigné dans l'URL
$app->get('/liste/:one', function($token) {
	FL::liste($token);
});
// Affiche les listes créer par l'utilisateur
$app->get('/myliste', function() {
	FL::displayOwnListe();
});
// Affiche les listes d'autres personnes enregistré par l'utilisateur
$app->get('/saveliste', function() {
	FL::displaySaveListe();
});
// Enregistre une liste d'un autre utilisateur
$app->post('/saveliste-add', function() {
	FL::saveListe();
});
// Supprime une liste enregistré par l'utilisateur
$app->post('/saveliste-remove/:token', function($token) {
	FL::unsaveListe($token);
});
// Supprime un item de la liste (l'item ou juste effacer de la liste ?)
$app->get('/liste-remove/:item', function($item) {
	FL::delItem($item);
});


// Créer une liste
$app->get('/add-liste-form', function() {
	Formulaire::ajouterListe();
	Formulaire::creeListe();
});
$app->post('/add-liste', function() {
	FL::cree();
});
$app->post('/add-user', function() {
	FL::ajoutUtilisateur();
});

// Ajout un message à une liste
$app->post('/add-mess/:token', function($token) {
  FL::addMessage($token);
});
// Rend la liste visible par tous
$app->post('/liste-published/:id', function($token) {
  FL::publication($token);
});
$app->post('/edit-liste/:id', function($token) {
  FL::modifier($token);
});


// Créer un item
$app->get('/add-item-form', function() {
	Formulaire::ajoutItem();
});
$app->post('/add-item', function() {
	CI::itemAdd();
});

// Affiche les details d'un item
$app->get('/item/:name', function($item_name) {
	PI::displayItem($item_name);
});
// Ajout d'une cagnotte pour un item
$app->post('/add-cagnotte/:name', function($item_name) {
	CG::addCagnotte($item_name);
});
// Défini une cagnotte pour un objet
$app->get('/set-cagnotte/:name', function($item_name) {
	CG::setCagnotte($item_name);
});


// ########
// # ITEM #
// ########
// Reserver un item
$app->post('/reserver/:name', function($item_name) {
	$_SESSION['item_action'] = "reserve";
	PI::displayItem($item_name);
});

//  Modifier item
$app->post('/edit-item/:name', function($item_name) {
	$_SESSION['item_action'] = "edit";
	PI::displayItem($item_name);
});

// Supprimer un item
$app->post('/delete-item/:name', function($item_name) {
	$_SESSION['item_action'] = "delete";
	PI::displayItem($item_name);
});

// Uploader imager
$app->post('/upload-image/:name', function($item_name) {
	$_SESSION['item_action'] = "uploadImage";
	PI::displayItem($item_name);
});

// Supprimer une image
$app->post('/delete-image/:name', function($item_name) {
	$_SESSION['item_action'] = "deleteImage";
	PI::displayItem($item_name);
});


// ####################
// # AUTHENTIFICATION #
// ####################
// Connection & inscription
$app->post('/connection', function() {
	if (isset($_POST['signin']))
		AUTH::Connection();
	else if (isset($_POST['signup']))
    	AUTH::Inscription();
});
// Deconnection
$app->get('/deconnection', function() {
	AUTH::Deconnection();
});


// ###########
// # COMPTE #
// ##########
// Affiche details d'un compte
$app->get('/compte', function() {
	PC::displayCompte();
});
$app->get('/auth-connexion', function() {
	Formulaire::connection();
});
$app->get('/auth-inscription', function() {
	Formulaire::inscription();
});

//  Modifier un compte
$app->post('/edit-compte', function () {
	$_SESSION['compte_action'] = "edit";
	PC::displayCompte();
});

//  Changer mot de passe
$app->post('/change-password', function () {
	$_SESSION['compte_action'] = "change_password";
	PC::displayCompte();
});

//  Modifier un compte
$app->post('/delete-compte', function () {
	AUTH::deleteUser();
	Outils::goTo('index.php', 'Compte supprimé!');
});

$app->run();

Outils::footerHTML();
