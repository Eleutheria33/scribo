<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
Use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Services\Article\Troncature\TroncText;

class AccueilController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(ArticleRepository $repoA, TroncText $TroncText)
    {

        $articles =  $repoA->findSixLastArticles();
        foreach ($articles as $article) {
                $article->setContent($TroncText->getTextTronque($article->getContent(), 3, 25));

          }
        return $this->render('accueil/home.html.twig', [
            'articles' => $articles

        ]);
    }




}


