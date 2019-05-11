<?php

namespace wishlist\modele;

class Reservation extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    public function item() {
        return $this->hasMany('wishlist\modele\Item' , 'id');
    }

}
