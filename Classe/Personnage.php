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

    public function getNom() {
        return $this->nom;
    }

    public function getPouvoir() {
        return $this->pouvoir;
    }
}

// Exemple de polymorphisme avec une interface
interface Actionnable {
    public function agir();
}

class PersonnageActionnable extends Personnage implements Actionnable {
    public function agir() {
        // Implémentation de l'action
    }
}
?>