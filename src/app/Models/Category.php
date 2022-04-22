<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = "categories";

    public function contenus(){
        return $this->belongsToMany('App\Models\Contenu','contenu_categories');
    }

}
