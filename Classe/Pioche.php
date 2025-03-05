<?php
class Pioche {
    private $personnages;
    private $quartiers;

    public function __construct() {
        $this->personnages = []; // Initialiser avec des objets Personnage
        $this->quartiers = []; // Initialiser avec des objets Quartier
    }

    public function piocherPersonnage() {
        return array_pop($this->personnages);
    }

    public function piocherQuartier() {
        return array_pop($this->quartiers);
    }
}
?>
