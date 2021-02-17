<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\CategoryRepository;
use App\Service\GetArticleService;
use App\Service\GetNbrArticleService;
use App\Service\PaginatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private GetArticleService $articleService;

    private GetNbrArticleService $nbrArticle;

    private EntityManagerInterface $manager;

    public function __construct(GetArticleService $articleService,
                                GetNbrArticleService $nbrArticle,
                                EntityManagerInterface $manager)
    {
        $this->articleService = $articleService;
        $this->nbrArticle = $nbrArticle;
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="home_article")
     */
    public function home(): Response
    {
        return $this->render('article/home.html.twig', [
        ]);
    }

    /**
     * @Route("/article", name="list_article")
     */
    public function index(Request $request, PaginatorService $paginator): Response
    {
        $articles = $paginator->pagination();

        return $this->render('article/list.html.twig', [
//           "articles" => array_reverse($this->articleService->getArticles()),// revers the array instead to create a queryBuilder and using more resources
            'articles' => $articles,
            'totalArticle' => $this->nbrArticle->getArticles(),
        ]);
    }

    /**
     * @Route("/article/add", name="add_article" , methods={"GET","POST"})
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
     *
     * @return Response
     *
     * Using ParamConverter by injecting the Article Entity (design pattern dependency injection) in the action parameters
     */
    public function show(Article $article, CategoryRepository $category): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
            // mapping Article->categoryId By Category->getName()
            'categoryName' => $category->findBy(['id' => $article->getCategory()])[0]->getName(),
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="edit_article", methods={"GET","POST"})
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
     */
    public function deleteStudent(Article $article): Response
    {
        $this->manager->remove($article);
        $this->manager->flush();

        return $this->redirectToRoute('list_article');
    }

    /**
     * @param $objet
     */
    public function save($objet): void
    {
        $this->manager->persist($objet);
        $this->manager->flush();
    }
}
