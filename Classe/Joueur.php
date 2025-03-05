<?php
class Joueur {
    private $nom;
    private $or;
    private $quartiers;
    private $personnage;

    public function __construct($nom) {
        $this->nom = $nom;
        $this->or = 0;
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

    public function getNom() {
        return $this->nom;
    }

    public function getOr() {
        return $this->or;
    }

    public function getQuartiers() {
        return $this->quartiers;
    }
}
?>
