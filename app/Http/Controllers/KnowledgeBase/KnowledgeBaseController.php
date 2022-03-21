<?php

namespace App\Http\Controllers\Contenu;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\KnowledgeBaseRepositoryInterface;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{

    protected $knowledgeBaseRepo;
    public function __construct(KnowledgeBaseRepositoryInterface $knowledgeBaseRepo)
    {
        $this->knowledgeBaseRepo = $knowledgeBaseRepo;
    }



}
