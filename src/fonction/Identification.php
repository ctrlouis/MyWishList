<?php

namespace wishlist\fonction;

use Illuminate\Database\Capsule\Manager as DB;

use wishlist\modele\User;
use wishlist\divers\Outils;


class Identification {

  public static function IdentificationCookie()
  {
    if (isset($_COOKIE['wishlist_username']) && isset($_COOKIE['wishlist_password']))
    {
      $user = User::select('id', 'username', 'password')
        ->where('username', 'like', $_COOKIE['wishlist_username'])
        ->first();

      if ($user && $_COOKIE['wishlist_password'] == $user->password)
      {
        echo 'Connected as ' . $user->username ;
        return true;
      }
    }
    return false;
  }

  public static function FormulaireConnection()
  {
    echo '<form action="connection" method="post">
            <p>Username : <input type="text" name="username" /></p>
            <p>Password : <input type="text" name="password" /></p>
            <p><input type="submit" name="signin" value="Sign in"><input type="submit" name="signup" value="Sign up"></p>
          </form>';
  }

  public static function Connection($username, $password)
  {
    $user = User::select('id', 'username', 'password', 'token')
      ->where('username', 'like', $username)
      ->first();

    if ($user && $password== $user->password)
    {
      setcookie("wishlist_username", $user->username, time() + 60 * 60 * 2, "/cours/MyWishList.app");
      setcookie("wishlist_password", $user->password, time() + 60 * 60 * 2, "/cours/MyWishList.app");
      setcookie("wishlist_token", $user->token, time() + 60 * 60 * 2, "/cours/MyWishList.app");
    }
    else {
    }
  }

  public static function Inscription($username, $password)
  {
    $user = new User();
    $user->username = $username;
    $user->password = $password;
    $user->token = Outils::generateToken();
    $user->save();
  }

}
