<?php
class Quartier {
    private $nom;
    private $cout;

    public function __construct($nom, $cout) {
        $this->nom = $nom;
        $this->cout = $cout;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getCout() {
        return $this->cout;
    }
}
?>
