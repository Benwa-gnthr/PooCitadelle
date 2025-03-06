<?php
class Joueur {
    private $nom;
    private $or;
    private $quartiers;
    private $personnage;
    private $cartesQuartier = [];

    public function __construct($nom) {
        $this->nom = $nom;
        $this->or = 2; // Chaque joueur commence avec 2 pièces d'or
        $this->quartiers = [];
    }

    public function prendreOr($montant) {
        $this->or += $montant;
    }

    public function rendreOr($montant) {
        if ($this->or >= $montant) {
            $this->or -= $montant;
            return $montant;
        } else {
            throw new Exception("Pas assez d'or.");
        }
    }

    public function construireQuartier(Quartier $quartier) {
        if ($this->or >= $quartier->getCout()) {
            $this->or -= $quartier->getCout();
            $this->quartiers[] = $quartier;
        } else {
            throw new Exception("Pas assez d'or pour construire ce quartier.");
        }
    }

    public function recevoirCartes($cartes) {
        $this->cartesQuartier = array_merge($this->cartesQuartier, $cartes);
    }

    public function getNom() {
        return $this->nom;
    }

    public function getOr() {
        return $this->or;
    }

    public function getQuartiers() {
        return $this->quartiers;
    }

    public function getCartesQuartier() {
        return $this->cartesQuartier;
    }
}

// Exemple d'héritage
class JoueurSpecial extends Joueur {
    private $specialAbility;

    public function __construct($nom, $specialAbility) {
        parent::__construct($nom);
        $this->specialAbility = $specialAbility;
    }

    public function getSpecialAbility() {
        return $this->specialAbility;
    }
}
?>
