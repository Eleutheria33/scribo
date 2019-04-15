<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Repository\UserRepository;

class StatUserExtension extends AbstractExtension
{
    private $repoU;

    public function __construct(UserRepository $repoU)
    {
        $this->repoU = $repoU;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('statUser', [$this, 'calculateUser']),
        ];
    }

    public function calculateUser()
    {
         return $this->repoU->findCountUser()[1];

    }
}
