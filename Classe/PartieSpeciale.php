<?php
class PartieSpeciale extends Partie {
    private $specialRule;

    public function __construct($specialRule) {
        parent::__construct();
        $this->specialRule = $specialRule;
    }

    public function getSpecialRule() {
        return $this->specialRule;
    }
}
?>