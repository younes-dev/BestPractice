<?php

namespace App\Service;

use App\Repository\ArticleRepository;

class ArticleService implements ServiceInterface
{
    private ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getCount(): int
    {
        return count($this->getAll());
    }
}
