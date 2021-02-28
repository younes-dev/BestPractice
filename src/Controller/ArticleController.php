<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Service\GetNbrArticleService;
use App\Service\PaginatorService;
use App\Service\SaveDataService;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @var GetNbrArticleService
     */
    private GetNbrArticleService $nbrArticle;

    /**
     * @var SaveDataService
     */
    private SaveDataService $saveData;

    /**
     * @codeCoverageIgnore
     * @param GetNbrArticleService $nbrArticle
     * @param SaveDataService $saveData
     */
    public function __construct(
        GetNbrArticleService $nbrArticle,
        SaveDataService $saveData

    ) {
        $this->nbrArticle = $nbrArticle;
        $this->saveData = $saveData;
    }


    /**
     * @Route("", name="list_article")
     * @param PaginatorService $paginator
     * @return Response
     * @codeCoverageIgnore
     */
    public function index(PaginatorService $paginator): Response
    {
        $articles = $paginator->pagination();

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
            'totalArticle' => $this->nbrArticle->getAll(),
        ]);
    }

    /**
     * @Route("/add", name="add_article" , methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @codeCoverageIgnore
     * @throws OptimisticLockException
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveData->save($article);
            return $this->redirectToRoute('list_article');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_article" , requirements={"id"="\d+"})
     * @codeCoverageIgnore
     * @param Article $article
     * @return Response
     *
     * Using ParamConverter by injecting the Article Entity (design pattern dependency injection) in the action parameters
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    //    /**
//     * @Route("/{id}", name="show_article" , requirements={"id"="\d+"})
//     *
//     * @param Article $article
//     * @return array
//     * @Template("article/show.html.twig")
//     *
//     * Using ParamConverter by injecting the Article Entity (design pattern dependency injection) in the action parameters
//     */
//    public function showAction2(Article $article): array
//    {
//        return ['article' => $article];
//    }

    /**
     * @Route("/{id}/edit", name="edit_article", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     * @codeCoverageIgnore
     * @throws OptimisticLockException
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveData->save($article);

            return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="article_delete", methods={"GET","DELETE"} , requirements={"id"="\d+"})
     * @param Article $article
     * @return Response
     * @codeCoverageIgnore
     * @throws OptimisticLockException
     */
    public function deleteStudent(Article $article): Response
    {
        $this->saveData->remove($article);
        return $this->redirectToRoute('list_article');
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function getObjectVars(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getKernelVersion(): string
    {
        return \Symfony\Component\HttpKernel\Kernel::VERSION; // this will return version;
    }
}
