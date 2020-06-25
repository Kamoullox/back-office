<?php

namespace App;

class CartesArray 
{
    protected $cartes = [];

    public function __construct(array $cartes=[])
    {
        $this->cartes = $cartes;
    }

   

    public function addCarte(Carte $carte)
    {
        $this->cartes[] = $carte;

        return $this;
    }
}