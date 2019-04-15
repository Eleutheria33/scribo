<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SliderArticlesController extends AbstractController
{
    /**
     * @Route("/slider/articles", name="slider_articles")
     */
    public function sliderArticles()
    {
        return $this->render('accueil/slider.html.twig', [
            'controller_name' => $articles,
        ]);
    }
}
