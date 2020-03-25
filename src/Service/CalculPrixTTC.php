<?php


namespace App\Service;


class CalculPrixTTC
{
    public function calculerPrixTTC($price)
    {
        return ($price + ($price*0.2));
    }

}