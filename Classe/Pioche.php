<?php
class Pioche {
    private $cartes = [];

    public function __construct() {
        // Initialiser les cartes de la pioche
        $this->cartes = [
            new Quartier("Quartier 1", 3),
            new Quartier("Quartier 2", 4),
            new Quartier("Quartier 3", 5),
            // Ajoutez toutes les cartes de quartier nécessaires
        ];
        shuffle($this->cartes); // Mélanger les cartes
    }

    public function piocherQuartier() {
        return array_pop($this->cartes);
    }
}
?>
