<?php
require_once "Pokemon.php";

class PokemonEau extends Pokemon {
    protected $type = "Eau";

    public function __construct($nom, $url, $hp, AttackPokemon $attackPokemon) {
        parent::__construct($nom, $url, $hp, $attackPokemon);
    }

    public function getType() {
        return $this->type;
    }

    public function attack(Pokemon $cible) {
        $damage = $this->attackPokemon->generateAttackPoints();
        $typeAdv = $cible->getType();

        if ($typeAdv === "Feu") {
            $damage *= 2;
        } elseif ($typeAdv === "Eau" || $typeAdv === "Plante") {
            $damage *= 0.5;
        }
        $cible->setHp($cible->getHp() - $damage);
        return round($damage);
    }
}
?>