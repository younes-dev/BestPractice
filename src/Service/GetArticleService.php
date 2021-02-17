<?php

namespace App\Service;

use App\Repository\ArticleRepository;

class GetArticleService implements Articles
{
    private ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getArticles(): array
    {
        return $this->repository->findAll();
    }
}
