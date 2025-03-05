<?php
class Banque {
    private $reserveOr;

    public function __construct() {
        $this->reserveOr = 30; // Exemple de réserve initiale
    }

    public function prendreOr($montant) {
        if ($this->reserveOr >= $montant) {
            $this->reserveOr -= $montant;
            return $montant;
        } else {
            throw new Exception("Pas assez d'or dans la banque.");
        }
    }

    public function donnerOr($joueur, $montant) {
        $joueur->prendreOr($montant);
        $this->reserveOr += $montant;
    }

    public function getReserveOr() {
        return $this->reserveOr;
    }
}
?>
