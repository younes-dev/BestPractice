<?php

namespace App\Service;

use App\Repository\ArticleRepository;

class GetNbrArticleService implements ServiceInterface
{
    private ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): int
    {
        return count($this->repository->findAll());
    }
}
