<?php

namespace wishlist\fonction;

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use wishlist\modele\Item;
use wishlist\modele\Liste;
use wishlist\conf\ConnectionFactory as CF;

// db connection
$cf = new CF();
$cf->setConfig('src/conf/conf.ini');
$db = $cf->makeConnection();

$item = Item::select('id', 'nom', 'img')
  ->where('id', '=', $_GET['id'])
  ->first();

if ($item)
{
  if ($item->reserv == 0) $reserv = 'disponible';
  else $reserv = 'reservé'
  echo 'id :'. $id.
      '<br/>nom : ' . $item->nom .
      '<br/>description : ' . $item->descr
      '<br/>etait reservation : ' . $reserv;

}
else
        echo 'Aucun item avec l\'id n°' . $id . ' n\'a été trouvé';
});
