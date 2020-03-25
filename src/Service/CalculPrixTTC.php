<?php


namespace App\Service;


class CalculPrixTTC
{
    private $tva;

    public function __construct($tva)
    {
        $this->tva = $tva;
    }

    public function calculerPrixTTC($price)
    {
        return ($price + ($price * $this->tva));
    }

}