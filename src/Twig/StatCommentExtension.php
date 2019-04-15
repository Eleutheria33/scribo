<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Repository\CommentRepository;

class StatCommentExtension extends AbstractExtension
{
    private $repoC;

    public function __construct(CommentRepository $repoC)
    {
        $this->repoC = $repoC;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('statComments', [$this, 'calculateComments']),
        ];
    }

    public function calculateComments()
    {
         return $this->repoC->findCountComments()[1];

    }
}
