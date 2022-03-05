<?php

namespace App\Repositories;

use App\Repositories\Interfaces\KnowledgeBaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            KnowledgeBaseRepositoryInterface::class,
            KnowledgeBaseRepository::class
        );

    }
}
