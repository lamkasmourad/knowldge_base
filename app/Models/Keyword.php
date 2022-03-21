<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Keyword extends Model
{

    protected $table = 'keywords';

    protected $fillable = array('label');

    public function contenus()
    {
        return $this->belongsToMany('App\Models\Contenu','contenu_keywords')->withPivot(['weight','is_synonym','is_synonym_global']);
    }

    public function voisins(){
        return $this->belongsToMany('App\Models\Voisin','voisin_keywords')->withPivot(['is_keyword']);
    }

    public function getSynonyms($excluded = [])
    {
        $synonyms= [];

        foreach ($this->voisins()->get() as $voisin){
            foreach ($voisin->keywords()->get() as $keyword){
                if($this->id != $keyword->id && (empty($excluded) || !in_array($keyword->id,$excluded))){
                    $synonyms[$keyword->id] = $keyword;
                }
            }
        }
        return collect(array_values($synonyms));
    }

}
