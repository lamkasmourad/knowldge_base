<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{

    protected $table = 'contenus';

    protected $fillable = array('text','check_question','scenario','active');


    public function keywords()
    {
        return $this->belongsToMany('App\Models\Keyword','contenu_keywords')->withPivot(['weight','is_synonym','is_synonym_global']);
    }

    public function category()
    {
        return $this->belongsTo(PerimetreDetaille::class, 'perimetre_detaille_id');
    }



}
