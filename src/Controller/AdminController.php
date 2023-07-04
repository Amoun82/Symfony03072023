<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/admin/category/update/{id}', name: "admin_category_update")]
    #[Route('/admin/category/new', name: 'admin_category_new')]
    public function formCartegory(Request $request, EntityManagerInterface $manager, Category $category = null)
    {
        if ($category == null) {
            $category = new Category;
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('admin_category_gestion');
            //dd($article) ;
        }

        return $this->render('admin/formCategory.html.twig', [
            'form' => $form,
            'editMode' => $category->getId() != null
        ]);
    }

    #[Route('/admin/category/gestion', name: 'admin_category_gestion')]
    public function gestionCategory(CategoryRepository $repo)
    {
        $categories = $repo->findAll();
        return $this->render('admin/gestionCategory.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'admin_category_delete')]
    public function deleteCategory(Category $category, EntityManagerInterface $manager)
    {
        $manager->remove($category);
        $manager->flush();
        return $this->redirectToRoute('admin_category_gestion') ;
    }

    #[Route('/admin/comment/update/{id}', name: "admin_comment_update")]
    #[Route('/admin/comment/new', name: 'admin_comment_new')]
    public function formComment(Request $request, EntityManagerInterface $manager, Comment $comment = null)
    {
        if ($comment == null) {
            $comment = new Comment;
        }

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime);
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('admin_comment_gestion');
            //dd($article) ;
        }

        return $this->render('admin/formComment.html.twig', [
            'form' => $form,
            'editMode' => $comment->getId() != null
        ]);
    }

    #[Route('/admin/comment/gestion', name: 'admin_comment_gestion')]
    public function gestionComment(CommentRepository $repo)
    {
        $comments = $repo->findAll();
        return $this->render('admin/gestionComment.html.twig', [
            'comments' => $comments
        ]);
    }

    #[Route('/admin/comment/delete/{id}', name: 'admin_comment_delete')]
    public function deleteComment(Comment $comment, EntityManagerInterface $manager)
    {
        $manager->remove($comment);
        $manager->flush();
        return $this->redirectToRoute('admin_comment_gestion') ;
    }


}
