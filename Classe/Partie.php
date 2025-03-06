<?php
class Partie {
    private $joueurs;
    private $pioche;
    private $banque;
    private $tourActuel;
    private $choixPersonnages = [];

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
        foreach ($this->joueurs as $joueur) {
            $joueur->prendreOr($this->banque->prendreOr(2));
        }
    }

    public function tourSuivant() {
        $this->tourActuel++;
        $this->choixPersonnages = [];

        echo "Choix des personnages pour le tour $this->tourActuel:\n";
        foreach ($this->joueurs as $joueur) {
            $this->choisirPersonnagePourJoueur($joueur);
        }

        echo "Révélation des personnages:\n";
        foreach ($this->choixPersonnages as $joueurNom => $personnage) {
            echo "$joueurNom joue " . $personnage->getNom() . "\n";
        }

        foreach ($this->joueurs as $joueur) {
            $this->jouerTourJoueur($joueur);
        }
    }

    private function choisirPersonnagePourJoueur(Joueur $joueur) {
        $personnagesDisponibles = [
            new Personnage("Assassin", "Peut tuer un autre personnage"),
            new Personnage("Voleur", "Peut voler tout l'or d'un autre joueur"),
            new Personnage("Magicien", "Peut échanger des cartes avec un autre joueur"),
            new Personnage("Roi", "Prend l'or de l'assassin s'il est tué"),
            new Personnage("Évêque", "Est protégé contre le voleur"),
            new Personnage("Marchand", "Reçoit une pièce d'or supplémentaire"),
            new Personnage("Architecte", "Peut construire jusqu'à trois quartiers pour le coût de deux"),
            new Personnage("Condottiere", "Prend tout l'or des joueurs ayant 10 pièces ou plus")
        ];

        echo "Joueur " . $joueur->getNom() . ", choisissez un personnage:\n";
        foreach ($personnagesDisponibles as $index => $personnage) {
            echo ($index + 1) . ": " . $personnage->getNom() . " - " . $personnage->getPouvoir() . "\n";
        }

        $choix = (int)trim(fgets(STDIN));
        if ($choix > 0 && $choix <= count($personnagesDisponibles)) {
            $personnageChoisi = $personnagesDisponibles[$choix - 1];
            $this->choixPersonnages[$joueur->getNom()] = $personnageChoisi;
        } else {
            echo "Choix invalide. Personnage par défaut sélectionné.\n";
            $this->choixPersonnages[$joueur->getNom()] = $personnagesDisponibles[0];
        }
    }

    private function jouerTourJoueur(Joueur $joueur) {
        $personnage = $this->choixPersonnages[$joueur->getNom()];
        $personnage->utiliserPouvoir($joueur, $this);

        $quartier = $this->pioche->piocherQuartier();
        if ($quartier) {
            $joueur->recevoirCartes([$quartier]);
            echo $joueur->getNom() . " pioche " . $quartier->getNom() . "\n";
        }

        foreach ($joueur->getCartesQuartier() as $quartier) {
            if ($joueur->getOr() >= $quartier->getCout()) {
                $joueur->construireQuartier($quartier);
                echo $joueur->getNom() . " construit " . $quartier->getNom() . "\n";
                break;
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
