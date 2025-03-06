<?php
class Banque {
    private $or;

    public function __construct() {
        $this->or = 30; // Montant initial dans la banque
    }

    public function prendreOr($montant) {
        if ($this->or >= $montant) {
            $this->or -= $montant;
            return $montant;
        }
        throw new Exception("Pas assez d'or dans la banque");
    }

    public function ajouterOr($montant) {
        $this->or += $montant;
    }

    public function getOr() {
        return $this->or;
    }
}
?>
