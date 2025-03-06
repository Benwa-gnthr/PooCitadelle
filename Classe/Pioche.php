<?php
class Pioche {
    private $cartes = [];

    public function __construct() {
        // Initialiser les cartes de la pioche
        $this->cartes = [
            new Quartier("Quartier 1"),
            new Quartier("Quartier 2"),
            new Quartier("Quartier 3"),
            // Ajoutez toutes les cartes de quartier nécessaires
        ];
        shuffle($this->cartes); // Mélanger les cartes
    }

    public function piocher($nombre) {
        return array_splice($this->cartes, 0, $nombre);
    }
}
?>
