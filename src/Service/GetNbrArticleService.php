<?php

namespace App\Service;

use App\Repository\ArticleRepository;

class GetNbrArticleService implements Articles
{
    private ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getArticles(): int
    {
        return count($this->repository->findAll());
    }
}
