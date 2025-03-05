<?php
class Partie {
    private $joueurs;
    private $pioche;
    private $banque;

    public function __construct() {
        $this->joueurs = [];
        $this->banque = new Banque();
        $this->pioche = new Pioche();
    }

    public function ajouterJoueur(Joueur $joueur) {
        $this->joueurs[] = $joueur;
    }

    public function demarrerPartie() {
        // Logique pour démarrer la partie
        foreach ($this->joueurs as $joueur) {
            $joueur->prendreOr($this->banque->prendreOr(2));
        }
    }

    public function tourSuivant() {
        // Logique pour passer au tour suivant
    }

    public function getJoueurs() {
        return $this->joueurs;
    }

    public function getBanque() {
        return $this->banque;
    }

    public function getPioche() {
        return $this->pioche;
    }
}
?>
