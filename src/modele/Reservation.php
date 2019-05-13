<?php

namespace wishlist\modele;

class Reservation extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    public function item() {
        return $this->belongsTo('wishlist\modele\Item' , 'id');
    }

    public function cagnotte() {
        return $this->hasMany('wishlist\modele\Cagnotte' , 'item_id');
    }

}
