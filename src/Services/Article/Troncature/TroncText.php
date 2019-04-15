<?php

namespace App\Services\Article\Troncature;

use App\Repository\ArticleRepository;

class TroncText
{
    public function getTextTronque($text, $long, $limit) {
         // on tronque les textes
        $textTrq = explode(' , ', $text);
        if (count($textTrq) > $long) {
            $textTrq = implode(' ', array_slice($textTrq, 0, $limit)).'...';
        }

        return $textTrq;
    }
}
