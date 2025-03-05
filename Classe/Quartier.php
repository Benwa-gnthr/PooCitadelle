<?php
class Quartier {
    private $nom;
    private $cout;
    private $type;

    public function __construct($nom, $cout, $type) {
        $this->nom = $nom;
        $this->cout = $cout;
        $this->type = $type;
    }

    public function getCout() {
        return $this->cout;
    }
}
?>