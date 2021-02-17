<?php

namespace App\Service;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginatorService
{
    private PaginatorInterface $paginator;

    private RequestStack $requestStack;

    private GetArticleService $articleService;

    public function __construct(PaginatorInterface $paginator, RequestStack $requestStack, GetArticleService $articleService)
    {
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
        $this->articleService = $articleService;
    }

    public function pagination(): object
    {
        return $this->paginator->paginate(
            array_reverse($this->articleService->getArticles()),
            // Define the page parameter
            $this->requestStack->getCurrentRequest()->query->getInt('page', 1),
            // Items per page
            5
        );
    }
}
