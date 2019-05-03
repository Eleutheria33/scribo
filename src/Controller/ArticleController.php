<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
Use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Services\Article\Statistiques\CalculNbr;
use App\Services\Article\Troncature\TroncText;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article/create", name="article_create")
     */
    public function createArticle(Request $req, ObjectManager $manager, CategoryRepository $repoC, UserRepository $repoU) {

      $article = new Article();
      $user = $repoU->find($this->getUser()->getId());
      $formArticle = $this->createForm(ArticleType::class, $article);

      $formArticle->handleRequest($req);

      if ($formArticle->isSubmitted() && $formArticle->isValid()) {

          foreach ($formArticle->get('categories')->getData() as $categorie) {
            $category = $repoC->find($categorie->getId());
            $category->addArticle($article);
            $article->addCategory($categorie);
            $article->setAuthor($this->getUser()->getUsername());
            $article->setAuthorId($this->getUser()->getId());
            $manager->persist($article);
            $manager->persist($category);
          }
          $user->addArticle($article);
          $article->setCreatedAt(new \DateTime());

          $manager->persist($article);
          $manager->flush();

          return $this->redirectToRoute('article', [
           'id' => $article->getId()
          ]);
      }

      return $this->render('article/createArticle.html.twig', [
        'formArticle' => $formArticle->createView(),
        'modeAction' =>  $article->getId() === null
      ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit")
     */
    public function editArticle(Article $article = null, Request $req, ObjectManager $manager, CategoryRepository $repoC, ArticleRepository $repoA) {

      $formArticle = $this->createForm(ArticleType::class, $article);

      $formArticle->handleRequest($req);
      if ($formArticle->isSubmitted() && $formArticle->isValid()) {
          // constitution du tableau de toutes les catégories
          $tabAllCateg = [];
          $allCategory = $repoC->findAll();
          foreach ($allCategory as $category) {
              $tabAllCateg[] = $category->getId();
            }
          // création du tableau des nouvelles catégories
          $newCategories = $formArticle->getData()->getCategories();
          foreach ($newCategories as $categorie) {
            $tabNewCateg[] = $categorie->getId();
            }
            // nettoyage des anciennes catégories & insertion des nouvelles
            foreach ($tabAllCateg as $singleCat) {
                if (in_array($singleCat, $tabNewCateg)) {
                      $category = $repoC->find($singleCat);
                      $category->addArticle($article);
                      $article->addCategory($category);
                } else {
                      $category = $repoC->find($singleCat);
                      $category->removeArticle($article);
                      $article->removeCategory($category);
                }
          }
          $manager->flush();

          return $this->redirectToRoute('article', [
           'id' => $article->getId()
          ]);
      }

      return $this->render('article/createArticle.html.twig', [
        'formArticle' => $formArticle->createView(),
        'modeAction' =>  $article->getId() === null
      ]);
    }

    /**
     * @Route("/article/{id<\d+>}", name="article")
     */
    public function showArticle($id, Request $req, ObjectManager $manager, ArticleRepository $repoA)//symfony(par param converter)fait le lien id-->article
    {
        $article =  $repoA->getfindOrderByComments($id)[0];
        /*dump($article);
        dump($p->CalculArtNbrMonth(2018, 11));
        dump($_SERVER);
        dump($_COOKIE);*/
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($req);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
         /* dump($req);
          dump($formComment);
          dump($comment);*/

           $comment->setContent($formComment->getData()->getContent());
           $comment->setCreatedAt(new \DateTime());
           $comment->setAuthor($this->getUser()->getUsername());
           $comment->setAuthorId($this->getUser()->getId());
           $article->addComment($comment);

           $manager->persist($article);
           $manager->persist($comment);
           $manager->flush();

           /*$comment = new Comment();
           $formComment = $this->createForm(CommentType::class, $comment);*/

           return $this->redirectToRoute('article', [
           'id' => $article->getId()
          ]);
        }


        return $this->render('article/article.html.twig', [
            'article' => $article,
            'formComment' => $formComment->createView(),

        ]);
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function showArticles(ArticleRepository $repo, TroncText $TroncText) // injection de dépendances
    {

        $articles = $repo->getfindOrderByArticles();
        foreach ($articles as $article) {
                $article->setContent($TroncText->getTextTronque($article->getContent(), 3, 25)[0]);

          }

        return $this->render('article/articles.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/removeArticle/{id}", name="removeArticle")
     */
    public function removeArticle($id, ObjectManager $manager, ArticleRepository $repoA) {
       // suppresion d'un article
          $artic = $repoA->find($id);
          $titArticle = $artic->getTitle();
          if ($artic){
            $manager->remove($artic);
            $manager->flush();
            $this->addFlash(
            'flash-systeme',
            $titArticle
        );
            return $this->redirectToRoute('articles');
          }
    }

    public function removeCategory($id, $repoC, $manager, $repoA) {
       // suppresion de toutes les catégories précédentes
          $artic = $repoA->find($id);
          $categories = $repoC->findAll();
         /* dump($categories);*/
          foreach ($categories as $category) {
            $category->removeArticle($artic);
            /*dump($category);*/
            $artic->removeCategory($category);
            $manager->flush();
          }
    }


}
