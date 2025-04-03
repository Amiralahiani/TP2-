<?php
class AttackPokemon{
    private $attackMinimal;
    private $attackMaximal;
    private $specialAttack;
    private $probabilitySpecialAttack;
    
    public function __construct($min, $max, $special, $prob) {
        $this->attackMinimal = $min;
        $this->attackMaximal = $max;
        $this->specialAttack = $special;
        $this->probabilitySpecialAttack = $prob;
    }

    public function getAttackMinimal() {
        return $this->attackMinimal;
    }

    public function getAttackMaximal() {
        return $this->attackMaximal;
    }

    public function getSpecialAttack() {
        return $this->specialAttack;
    }

    public function getProbabilitySpecialAttack() {
        return $this->probabilitySpecialAttack;
    }

    public function generateAttackPoints() {
        $points = rand($this->attackMinimal, $this->attackMaximal);

        $tirage = rand(1, 100);
        if ($tirage <= $this->probabilitySpecialAttack) {
            return $points * $this->specialAttack;
        }
        return $points;
    }

}
?>