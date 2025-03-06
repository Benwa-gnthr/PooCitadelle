<?php
class Personnage {
    private $nom;
    private $pouvoir;

    public function __construct($nom, $pouvoir) {
        $this->nom = $nom;
        $this->pouvoir = $pouvoir;
    }

    public function utiliserPouvoir(Joueur $joueur, Partie $partie) {
        switch ($this->nom) {
            case "Assassin":
                $this->pouvoirAssassin($joueur, $partie);
                break;
            case "Voleur":
                $this->pouvoirVoleur($joueur, $partie);
                break;
            case "Magicien":
                $this->pouvoirMagicien($joueur, $partie);
                break;
            case "Roi":
                $this->pouvoirRoi($joueur, $partie);
                break;
            case "Évêque":
                $this->pouvoirEveque($joueur, $partie);
                break;
            case "Marchand":
                $joueur->prendreOr($partie->getBanque()->prendreOr(1));
                break;
            case "Architecte":
                $this->pouvoirArchitecte($joueur, $partie);
                break;
            case "Condottiere":
                $this->pouvoirCondottiere($joueur, $partie);
                break;
            default:
                $joueur->prendreOr($partie->getBanque()->prendreOr(1));
        }
    }

    private function pouvoirAssassin(Joueur $joueur, Partie $partie) {
        // L'assassin peut tuer un autre personnage
        echo $joueur->getNom() . " (Assassin) peut tuer un autre personnage.\n";
        $cible = $this->choisirCible($joueur, $partie);
        if ($cible) {
            echo $cible->getNom() . " est tué et ne reçoit pas d'or ce tour.\n";
            // Logique pour empêcher la cible de recevoir de l'or ce tour
        }
    }

    private function pouvoirVoleur(Joueur $joueur, Partie $partie) {
        // Le voleur peut voler tout l'or d'un autre joueur
        echo $joueur->getNom() . " (Voleur) peut voler tout l'or d'un autre joueur.\n";
        $cible = $this->choisirCible($joueur, $partie);
        if ($cible && $cible->getNom() !== "Évêque") {
            $orVole = $cible->rendreOr($cible->getOr());
            $joueur->prendreOr($orVole);
            echo $joueur->getNom() . " vole " . $orVole . " pièces d'or de " . $cible->getNom() . ".\n";
        } else {
            echo "L'Évêque est protégé contre le voleur.\n";
        }
    }

    private function pouvoirMagicien(Joueur $joueur, Partie $partie) {
        // Le magicien peut échanger des cartes avec un autre joueur
        echo $joueur->getNom() . " (Magicien) peut échanger des cartes avec un autre joueur.\n";
        $cible = $this->choisirCible($joueur, $partie);
        if ($cible) {
            // Logique pour échanger des cartes (simplifié ici)
            echo $joueur->getNom() . " échange des cartes avec " . $cible->getNom() . ".\n";
        }
    }

    private function pouvoirRoi(Joueur $joueur, Partie $partie) {
        // Le roi prend l'or de l'assassin s'il est tué
        echo $joueur->getNom() . " (Roi) prend l'or de l'assassin s'il est tué.\n";
        // Logique pour prendre l'or de l'assassin (simplifié ici)
    }

    private function pouvoirEveque(Joueur $joueur, Partie $partie) {
        // L'évêque est protégé contre le voleur
        echo $joueur->getNom() . " (Évêque) est protégé contre le voleur.\n";
    }

    private function pouvoirArchitecte(Joueur $joueur, Partie $partie) {
        // L'architecte peut construire jusqu'à trois quartiers pour le coût de deux
        echo $joueur->getNom() . " (Architecte) peut construire jusqu'à trois quartiers pour le coût de deux.\n";
        // Logique pour construire des quartiers (simplifié ici)
    }

    private function pouvoirCondottiere(Joueur $joueur, Partie $partie) {
        // Le condottiere prend tout l'or des joueurs ayant 10 pièces ou plus
        echo $joueur->getNom() . " (Condottiere) prend tout l'or des joueurs ayant 10 pièces ou plus.\n";
        foreach ($partie->getJoueurs() as $autreJoueur) {
            if ($autreJoueur->getOr() >= 10) {
                $orPris = $autreJoueur->rendreOr($autreJoueur->getOr());
                $joueur->prendreOr($orPris);
                echo $joueur->getNom() . " prend " . $orPris . " pièces d'or de " . $autreJoueur->getNom() . ".\n";
            }
        }
    }

    private function choisirCible(Joueur $joueur, Partie $partie) {
        echo $joueur->getNom() . ", choisissez une cible parmi les joueurs:\n";
        $joueurs = $partie->getJoueurs();
        foreach ($joueurs as $index => $autreJoueur) {
            if ($autreJoueur->getNom() !== $joueur->getNom()) {
                echo ($index + 1) . ": " . $autreJoueur->getNom() . "\n";
            }
        }
        $choix = (int)trim(fgets(STDIN));
        if ($choix > 0 && $choix <= count($joueurs)) {
            return $joueurs[$choix - 1];
        }
        return null;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPouvoir() {
        return $this->pouvoir;
    }
}
?>
