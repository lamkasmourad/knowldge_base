<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voisin extends Model
{


    protected $table = 'voisins';

    public function keywords(){
        return $this->hasMany('App\Models\Keyword');
    }
}
