<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Service\GetNbrArticleService;
use App\Service\PaginatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private GetNbrArticleService $nbrArticle;

    private EntityManagerInterface $manager;

    /**
     * @codeCoverageIgnore
     * @param GetNbrArticleService $nbrArticle
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        GetNbrArticleService $nbrArticle,
        EntityManagerInterface $manager
    ) {
        $this->nbrArticle = $nbrArticle;
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="home_article")
     *
     * @codeCoverageIgnore
     *
     */
    public function home(): Response
    {
        return $this->render('article/home.html.twig', [
        ]);
    }

    /**
     * @Route("/article", name="list_article")
     * @param PaginatorService $paginator
     * @return Response
     * @codeCoverageIgnore
     */
    public function index(PaginatorService $paginator): Response
    {
        $articles = $paginator->pagination();
        // dd($this->nbrArticle->getAll());

        return $this->render('article/list.html.twig', [
            'articles' => $articles,
            'totalArticle' => $this->nbrArticle->getAll(),
        ]);
    }

    /**
     * @Route("/article/add", name="add_article" , methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @codeCoverageIgnore
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($article);

            return $this->redirectToRoute('list_article');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="show_article" , requirements={"id"="\d+"})
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
//     * @Route("/article/{id}", name="show_article" , requirements={"id"="\d+"})
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
     * @Route("/article/{id}/edit", name="edit_article", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     * @codeCoverageIgnore
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete", methods={"GET","DELETE"} , requirements={"id"="\d+"})
     * @param Article $article
     * @return Response
     * @codeCoverageIgnore
     */
    public function deleteStudent(Article $article): Response
    {
        $this->manager->remove($article);
        $this->manager->flush();

        return $this->redirectToRoute('list_article');
    }

    public function save(Article $objet): void
    {
        $this->manager->persist($objet);
        $this->manager->flush();
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
