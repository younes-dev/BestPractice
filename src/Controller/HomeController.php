<?php

namespace App\Controller;

use App\Service\PaginatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @param PaginatorService $paginator
     * @return Response
     * @codeCoverageIgnore
     */
    public function indexAction(PaginatorService $paginator): Response
    {
        $articles = $paginator->pagination();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/show", name="app_show")
     * @return Response
     * @codeCoverageIgnore
     */
    public function showAction(): Response
    {
        return $this->render('home/show.html.twig', [
        ]);
    }


}
