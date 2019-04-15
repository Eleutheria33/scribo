<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class TroncTextExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [
            new TwigFunction('Text_150', [$this, 'TroncatureText']),
        ];
    }


    public function TroncatureText($text) {
         // on tronque l'article
        $textTrq = explode(' ', $text);
        if (count($textTrq) > 250) {
            $textTrq = implode(' ', array_slice($textTrq, 0, 150)).'...';
        }

        return $textTrq;
    }

}
