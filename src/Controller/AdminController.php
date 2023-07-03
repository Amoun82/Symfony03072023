<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/article/update/{id}', name: "admin_article_update")]
    #[Route('/admin/article/new', name: 'admin_article_new')]
    public function formArticle(Request $request, EntityManagerInterface $manager, Article $article = null)
    {
        if ($article == null) {
            $article = new Article;
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime);
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('admin_article_gestion');
            //dd($article) ;
        }

        return $this->render('admin/formArticle.html.twig', [
            'form' => $form,
            'editMode' => $article->getId() != null
        ]);
    }

    #[Route('/admin/article/gestion', name: 'admin_article_gestion')]
    public function gestionARticle(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('admin/gestionArticle.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/admin/article/delete/{id}', name: 'admin_article_delete')]
    public function deleteArticle(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute('admin_article_gestion') ;
    }
}
