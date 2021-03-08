<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Helper\UploaderHelper;
use App\Service\GetNbrArticleService;
use App\Service\PaginatorService;
use App\Service\SaveDataService;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @var SaveDataService
     */
    private SaveDataService $saveData;
    /**
     * @var UploaderHelper
     */
    private UploaderHelper $helper;

    /**
     * @codeCoverageIgnore
     * @param SaveDataService $saveData
     * @param UploaderHelper $helper
     */
    public function __construct(
        SaveDataService $saveData,
        UploaderHelper $helper
    ) {
        $this->saveData = $saveData;
        $this->helper = $helper;
    }


    /**
     * @Route("", name="app_admin_index")
     * @Route("/articles", name="app_admin_articles")
     * @param PaginatorService $paginator
     * @return Response
     * @codeCoverageIgnore
     */
    public function indexAction(PaginatorService $paginator): Response
    {
        $articles = $paginator->pagination();

        return $this->render('dashboard/admin-articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articles/new", name="app_add_article" , methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @codeCoverageIgnore
     * @throws OptimisticLockException
     */
    public function newAction(Request $request): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveData->save($article);
        return $this->redirectToRoute('app_show_article',["id" => $article->getId()]);
        }

        return $this->render('dashboard/admin-new-article.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles/{id}", name="app_show_article" , requirements={"id"="\d+"})
     * @codeCoverageIgnore
     * @param Article $article
     * @return Response
     *
     * Using ParamConverter by injecting the Article Entity (design pattern dependency injection) in the action parameters
     */
    public function showAction(Article $article): Response
    {
        return $this->render('dashboard/admin-show-article.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/articles/{id}/edit", name="app_article_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @param Request $request
     * @param Article $article
     * @return Response
     * @codeCoverageIgnore
     * @throws OptimisticLockException
     */
    public function editAction(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveData->save($article);
            return $this->redirectToRoute('app_show_article', ['id' => $article->getId()]);
        }

        return $this->render('dashboard/admin-edit-article.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_article_delete", methods={"GET","DELETE"} , requirements={"id"="\d+"})
     * @param Article $article
     * @return Response
     * @codeCoverageIgnore
     * @throws OptimisticLockException
     */
    public function deleteAction(Article $article): Response
    {
        $this->saveData->remove($article);
        return $this->redirectToRoute('app_admin_articles');
    }


}
