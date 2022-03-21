<?php

namespace App\Repositories\Interfaces;


interface ContenuRepositoryInterface
{

    public function createContenu($text,$checkQuestion,$scenario,$categoriesId,$isActive = true);
    public function saveContenuKeywords($contenu,$keywords);
}
