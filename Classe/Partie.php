<?php

class Partie {
    public $tourActuel;
    private $joueurs = [];
    private $pioche;
    private $personnages;

    public function __construct() {
        $this->tourActuel = 0;
        $this->pioche = new Pioche();
        $this->personnages = $this->initialiserPersonnages();
    }

    public function ajouterJoueur($joueur) {
        $this->joueurs[] = $joueur;
    }

    public function demarrerPartie() {
        foreach ($this->joueurs as $joueur) {
            $joueur->recevoirCartes($this->pioche->piocher(4));
        }
        // Logique pour démarrer la partie
    }

    public function tourSuivant() {
        $this->tourActuel++;
        // Logique pour passer au tour suivant
    }

    public function getJoueurs() {
        return $this->joueurs;
    }

    private function initialiserPersonnages() {
        // Initialiser les personnages du jeu Citadelles
        return [
            new Personnage("Assassin", "Pouvoir de l'Assassin"),
            new Personnage("Voleur", "Pouvoir du Voleur"),
            new Personnage("Magicien", "Pouvoir du Magicien"),
            new Personnage("Roi", "Pouvoir du Roi"),
            new Personnage("Évêque", "Pouvoir de l'Évêque"),
            new Personnage("Marchand", "Pouvoir du Marchand"),
            new Personnage("Architecte", "Pouvoir de l'Architecte"),
            new Personnage("Condottiere", "Pouvoir du Condottiere")
        ];
    }
}
?>