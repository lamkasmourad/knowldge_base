<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ContenuRepositoryInterface;
use App\Repositories\Interfaces\KnowledgeBaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            ContenuRepositoryInterface::class,
            ContenuRepository::class
        );

        $this->app->bind(
            KnowledgeBaseRepositoryInterface::class,
            KnowledgeBaseRepository::class
        );

    }
}
