<?php

namespace wishlist\modele;

class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function liste() {
        return $this->belongsTo('wishlist\modele\Liste' , 'liste_id');
    }

	public function reservation() {
        return $this->hasMany('wishlist\modele\Reservation', 'item_id');
    }

}
