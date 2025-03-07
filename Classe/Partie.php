<?php
class Partie {
    private $joueurs;
    private $pioche;
    private $banque;
    private $tourActuel;
    private $choixPersonnages = [];
    private $personnagesDisponibles = [];

    public function __construct() {
        $this->joueurs = [];
        $this->banque = new Banque();
        $this->pioche = new Pioche();
        $this->tourActuel = 0;
        $this->personnagesDisponibles = [
            new Personnage("Assassin", "Peut tuer un autre personnage"),
            new Personnage("Voleur", "Peut voler tout l'or d'un autre joueur"),
            new Personnage("Magicien", "Peut échanger des cartes avec un autre joueur"),
            new Personnage("Roi", "Prend l'or de l'assassin s'il est tué"),
            new Personnage("Évêque", "Est protégé contre le voleur"),
            new Personnage("Marchand", "Reçoit une pièce d'or supplémentaire"),
            new Personnage("Architecte", "Peut construire jusqu'à trois quartiers pour le coût de deux"),
            new Personnage("Condottiere", "Prend tout l'or des joueurs ayant 10 pièces ou plus")
        ];
    }

    private function defausserPersonnagesInitiaux() {
        // Défaussage aléatoire de deux personnages
        $personnageDefaussePublic = array_splice($this->personnagesDisponibles, rand(0, count($this->personnagesDisponibles) - 1), 1)[0];
        $personnageDefaussePrive = array_splice($this->personnagesDisponibles, rand(0, count($this->personnagesDisponibles) - 1), 1)[0];

        echo "Personnage défaussé (connu de tous) : " . $personnageDefaussePublic->getNom() . "\n";
        echo "Un autre personnage a été défaussé secrètement.\n";
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
        $this->personnagesDisponibles = [
            new Personnage("Assassin", "Peut tuer un autre personnage"),
            new Personnage("Voleur", "Peut voler tout l'or d'un autre joueur"),
            new Personnage("Magicien", "Peut échanger des cartes avec un autre joueur"),
            new Personnage("Roi", "Prend l'or de l'assassin s'il est tué"),
            new Personnage("Évêque", "Est protégé contre le voleur"),
            new Personnage("Marchand", "Reçoit une pièce d'or supplémentaire"),
            new Personnage("Architecte", "Peut construire jusqu'à trois quartiers pour le coût de deux"),
            new Personnage("Condottiere", "Prend tout l'or des joueurs ayant 10 pièces ou plus")
        ];

        // Défaussage initial
        $this->defausserPersonnagesInitiaux();

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
        echo "Joueur " . $joueur->getNom() . ", choisissez un personnage:\n";
        foreach ($this->personnagesDisponibles as $index => $personnage) {
            echo ($index + 1) . ": " . $personnage->getNom() . " - " . $personnage->getPouvoir() . "\n";
        }

        $choix = (int)trim(fgets(STDIN));
        if ($choix > 0 && $choix <= count($this->personnagesDisponibles)) {
            $personnageChoisi = $this->personnagesDisponibles[$choix - 1];
            $this->choixPersonnages[$joueur->getNom()] = $personnageChoisi;
            unset($this->personnagesDisponibles[$choix - 1]);
            $this->personnagesDisponibles = array_values($this->personnagesDisponibles); // Réindexer le tableau
        } else {
            echo "Choix invalide. Veuillez choisir un personnage disponible.\n";
            $this->choisirPersonnagePourJoueur($joueur); // Relancer le choix
        }
    }

    private function choisirCiblePersonnage(Joueur $joueur) {
        $personnageJoueur = $this->choixPersonnages[$joueur->getNom()];
        echo $joueur->getNom() . ", choisissez un personnage cible parmi tous les personnages (sauf " . $personnageJoueur->getNom() . "):\n";
    
        $index = 1;
        foreach ($this->personnagesDisponibles as $personnage) {
            if ($personnage->getNom() !== $personnageJoueur->getNom()) {
                echo ($index++) . ": " . $personnage->getNom() . "\n";
            }
        }
    
        $choix = (int)trim(fgets(STDIN));
        if ($choix > 0 && $choix < $index) {
            return $this->personnagesDisponibles[$choix - 1];
        }
        echo "Choix invalide. Aucune cible sélectionnée.\n";
        return null;
    }
    
    

    private function pouvoirAssassin(Joueur $joueur) {
        echo $joueur->getNom() . " (Assassin) peut tuer un autre personnage.\n";
        $cible = $this->choisirCiblePersonnage($joueur);
        if ($cible) {
            // Vérifiez si le personnage cible a été choisi par un joueur
            $trouve = false;
            foreach ($this->choixPersonnages as $nomJoueur => $personnageChoisi) {
                if ($personnageChoisi->getNom() === $cible->getNom()) {
                    echo $nomJoueur . " (jouant " . $cible->getNom() . ") est tué et ne reçoit pas d'or ce tour.\n";
                    $trouve = true;
                    break;
                }
            }
            if (!$trouve) {
                echo "Le personnage cible n'a pas été choisi par un joueur ce tour.\n";
            }
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
