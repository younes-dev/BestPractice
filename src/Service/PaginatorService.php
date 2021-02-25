<?php

namespace App\Service;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginatorService
{
    private PaginatorInterface $paginator;

    private RequestStack $requestStack;

    private ArticleService $articleService;

    /**
     * PaginatorService constructor.
     * @param PaginatorInterface $paginator
     * @param RequestStack $requestStack
     * @param ArticleService $articleService
     * @codeCoverageIgnore
     */
    public function __construct(PaginatorInterface $paginator, RequestStack $requestStack, ArticleService $articleService)
    {
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
        $this->articleService = $articleService;
    }

    /**
     * @return object
     * @codeCoverageIgnore
     */
    public function pagination(): object
    {
        return $this->paginator->paginate(
            array_reverse($this->articleService->getAll()),
            $this->requestStack->getCurrentRequest()->query->getInt('page', 1),
            6
        );
    }
}
