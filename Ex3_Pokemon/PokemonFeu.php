<?php
require_once "Pokemon.php";

class PokemonFeu extends Pokemon {
    protected $type = "Feu";

    public function __construct($nom, $url, $hp, AttackPokemon $attackPokemon) {
        parent::__construct($nom, $url, $hp, $attackPokemon);
    }

    public function getType() {
        return $this->type;
    }

    public function attack(Pokemon $cible) {
        $damage = $this->attackPokemon->generateAttackPoints();
        $typeAdv = $cible->getType();

        if ($typeAdv === "Plante") {
            $damage *= 2;
        } elseif ($typeAdv === "Feu" || $typeAdv === "Eau") {
            $damage *= 0.5;
        }
        $cible->setHp($cible->getHp() - $damage);
        return round($damage);
    }
}
?>