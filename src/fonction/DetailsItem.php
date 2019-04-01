<?php

namespace wishlist\fonction;

use wishlist\modele\Item;
use wishlist\modele\Liste;


class DetailsItem {

  public static function displayDetails ($id) {

    if ($id)
    {
      $item = Item::select('id', 'nom', 'img')
        ->where('id', '=', $id)
        ->first();

      if ($item->reserv == 0) $reserv = 'disponible';
      else $reserv = 'reservé';
      echo 'id :'. $id .
          '<br/>nom : ' . $item->nom .
          '<br/>description : ' . $item->descr .
          '<br/>etait reservation : ' . $reserv;
    }
    else
      echo 'L\'item n\'existe pas';
  }

}
