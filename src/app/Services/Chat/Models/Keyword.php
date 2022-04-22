<?php

namespace App\Services\Chat\Models;

use App\Enums\TypeExpressionEnum;
use Illuminate\Support\Collection;

class Keyword
{
    protected $label;
    protected $weight;
    protected Collection $contenus;
    public function __construct($label,$weight)
    {
        $this->label = $label;
        $this->weight = $weight;
        $this->contenus = new Collection ();
    }

    public function getLabel(){
        return $this->label;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function setWeight($weight){
        $this->weight = $weight;
    }

    public function addContenu(Contenu $contenu){
        $this->contenus->add($contenu);
    }

    public function getContenus(){
        return $this->contenus;
    }

    public function getType(){
        return TypeExpressionEnum::KEYWORD;
    }



}
