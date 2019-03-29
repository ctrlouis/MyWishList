<?php

namespace wishlist\modele;

class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item() {
        return $this->hasMany('wishlist\modele\Item', 'liste_id');
    }
}