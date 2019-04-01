<?php

namespace wishlist\modele;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /*public function liste() {
        return $this->hasMany('wishlist\modele\Liste', 'liste_id');
    }*/
}
