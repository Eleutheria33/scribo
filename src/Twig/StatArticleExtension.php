<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Repository\ArticleRepository;

class StatArticleExtension extends AbstractExtension
{
    private $repoA;

    public function __construct(ArticleRepository $repoA)
    {
        $this->repoA = $repoA;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('statArticles', [$this, 'calculateArticles']),
        ];
    }

    public function calculateArticles()
    {
         return $this->repoA->findCountArticles()[1];

    }
}
