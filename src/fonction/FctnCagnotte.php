<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\modele\Reservation;
use wishlist\modele\Cagnotte;

use wishlist\divers\Outils;
class FctnCagnotte{

  public static function setCagnotte($item_name){
    $liste = Liste::where('token_publique', 'like', $_SESSION['wishlist_liste_token'])->first();
    $item = Item::where('nom', 'like', $item_name)->where('liste_id', '=', $liste->no)->first();


    if($item->reservation[0]->cagnotte == 0) {
      $reservation = $item->reservation[0];
      $reservation->cagnotte = 1;
      $reservation->save();
      echo 'Cagnotte crée pour '. $item_name.' ! </br>';
    }
    else {
      echo "Cagnotte déjà crée pour cette item </br>";
    }
    echo '<a href="/MyWishList/item/' . $item_name .'">Retour à l`item</a>';
  }

  public static function addCagnotteForm($item_name){
    echo '<h3>Ajout participation</h3>
          <form action="../add-cagnotte/' . $item_name . '" method="post">';
    if(!isset($_SESSION['wishlist_userid']))
      echo '<p><input type="text" name="name" placeholder="Nom" required/></p>';

    echo   '<p><input type="number" name="montant" placeholder="Montant..." required/></p>
            <p><textarea type="text" name="message" placeholder="Laissez votre message..." required/></textarea></p>
            <p><input type="submit" name="Make a present"></p>
          </form>';
  }

  public static function addCagnotte($item_name){

    $liste = Liste::where('token_publique', 'like', $_SESSION['wishlist_liste_token'])->first();
    if($liste){
      $item = Item::where('nom', 'like', $item_name)->where('liste_id', '=', $liste->no)->first();
      $participation = Cagnotte::where('item_id', '=', $item->id)->where('name', 'like', $_POST['name'])->first();
      if(!$participation){
        $cagnotte = new Cagnotte();
        $cagnotte->item_id = $item->id;
        if(isset($_SESSION['wishlist_userid'])){
          $cagnotte->user_id = htmlspecialchars($_SESSION['wishlist_userid']);
          $user = User::where('id', 'like', $_SESSION['wishlist_userid']);
          $cagnotte->name = htmlspecialchars($user->email);
        }
        else {
          $cagnotte->name = htmlspecialchars($_POST['name']);
        }
        $cagnotte->montant = htmlspecialchars($_POST['montant']);
        $cagnotte->message = htmlspecialchars($_POST['message']);
        $cagnotte->save();
        echo 'Participation effectué !';
      }
      else
        echo "Participation déjà effectué ! </br>";
      echo '<a href="/MyWishList/item/' . $item_name .'">Retour à l`item</a>';
    }
    else {
      echo "Erreur, veuillez ressayer !";
    }
  }
}