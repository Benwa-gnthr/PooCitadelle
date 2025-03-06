<?php

class Partie {
    public $tourActuel;
    private $joueurs = [];

    public function __construct() {
        $this->tourActuel = 0; // Initialisation de la propriété tourActuel
    }

    public function ajouterJoueur($joueur) {
        $this->joueurs[] = $joueur;
    }

    public function demarrerPartie() {
        // Logique pour démarrer la partie
    }

    public function tourSuivant() {
        $this->tourActuel++;
        // Logique pour passer au tour suivant
    }

    public function getJoueurs() {
        return $this->joueurs;
    }
}
?>