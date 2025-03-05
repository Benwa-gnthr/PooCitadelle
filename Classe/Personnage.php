<?php
class Personnage {
    private $nom;
    private $pouvoir;

    public function __construct($nom, $pouvoir) {
        $this->nom = $nom;
        $this->pouvoir = $pouvoir;
    }

    public function utiliserPouvoir() {
        // Logique pour utiliser le pouvoir
    }
}
?>