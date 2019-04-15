<?php
// src/Services/Statistiques/CalculNbr.php
namespace App\Services\Article\Statistiques;

use App\Repository\ArticleRepository;

class CalculNbr
{
    private $nbr;
    private $repo;

    public function __construct(ArticleRepository $repoA)
    {
        $this->repo = $repoA;

    }

    public function CalculArtNbrMonth($year, $month) {
        $nbr =  $this->repo->findCountMonth($year, $month);
        return $nbr;
    }
}
