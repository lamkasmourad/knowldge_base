<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{

    protected $table = 'keywords';

    protected $fillable = array('label');

    public function contenus()
    {
        return $this->belongsToMany('App\Models\Contenu','contenu_keywords')->withPivot(['weight','is_synonym','is_synonym_global']);
    }

    public function voisin(){
        return $this->belongsTo('App\Models\Voisin');
    }

}
