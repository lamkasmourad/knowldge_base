<?php

namespace App\Repositories\Interfaces;


interface KnowledgeBaseRepositoryInterface
{

    public function createContenu($text,$checkQuestion,$scenario,$isActive = true);
    public function saveContenuKeywords($contenu,$keywords);
}
