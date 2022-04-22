<?php

namespace App\Services\Chat\Models;

class Contenu
{
    protected $text;
    protected $checkQuestion;
    protected $scenario;
    protected $active;

    public function __construct($text,$checkQuestion,$scenario,$active)
    {
        $this->text = $text;
        $this->checkQuestion = $checkQuestion;
        $this->scenario = $scenario;
        $this->active = $active;
    }

    public function getText(){
        return $this->text;
    }

    public function getCheckQuestion(){
        return $this->checkQuestion;
    }

    public function getScenario(){
        return $this->scenario;
    }

    public function isActive(){
        return $this->active;
    }



}
