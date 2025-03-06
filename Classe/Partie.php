<?php
class Partie {
    private $joueurs;
    private $pioche;
    private $banque;
    private $tourActuel;

    public function __construct() {
        $this->joueurs = [];
        $this->banque = new Banque();
        $this->pioche = new Pioche();
        $this->tourActuel = 0;
    }

    public function ajouterJoueur(Joueur $joueur) {
        $this->joueurs[] = $joueur;
    }

    public function demarrerPartie() {
        // Logique pour démarrer la partie
        foreach ($this->joueurs as $joueur) {
            $joueur->prendreOr($this->banque->prendreOr(0));
        }
    }

    public function tourSuivant() {
        // Logique pour passer au tour suivant
        $this->tourActuel++;
        foreach ($this->joueurs as $joueur) {
            // Exemple d'action : piocher une carte quartier
            $quartier = $this->pioche->piocherQuartier();
            if ($quartier) {
                $joueur->ajouterQuartier($quartier);
            }

            // Construire un quartier si possible
            if (count($joueur->getQuartiers()) > 0 && $joueur->getOr() >= $joueur->getQuartiers()[0]->getCout()) {
                $joueur->construireQuartier($joueur->getQuartiers()[0]);
            }
        }
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

    public function getTourActuel() {
        return $this->tourActuel;
    }
}
?>
