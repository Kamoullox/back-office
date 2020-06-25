<?php

namespace App; 

use App\Carte;
use App\CartesArray;

/**
 * Modéliser un jeu de carte.
 * 
 * Voici les classes à créer :
 * - Carte
 * - Joueur
 * - CartesArray
 */

require __DIR__.'/../vendor/autoload.php';




class PaquetCartStandard extends CartesArray
{
    public function __construct()
    {
        try {
            foreach (Carte::FIGURES as $codeFigure => $nomFigure) {
                for ($i = Carte::AS; $i <= Carte::ROI; $i++) {
                    if ($codeFigure == 0 ||$codeFigure == 1) {
                        $couleur = Carte::NOIR;
                    } else {
                        $couleur = Carte::ROUGE;
                    }
        
                    $carte = new Carte($couleur, $codeFigure, $i);
                    
                    $this->cartes[] = $carte;
                }
            }
        } catch (Exception $e) {
            echo 'oups il y a eu une erreur<br>';
            echo $e->getMessage();
        }
    }
}   

