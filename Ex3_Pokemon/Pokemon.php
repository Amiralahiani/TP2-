<?php
require_once 'AttackPokemon.php';
class Pokemon
{
    private $nom;
    private $url;
    private $hp;
    protected $attackPokemon;

    public function __construct($non, $url, $hp, AttackPokemon $attackPokemon)
    {
        $this->nom = $non;
        $this->url = $url;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
    }
    public function getNom()
    {
        return $this->nom;
    }       
    public function getUrl()
    {
        return $this->url;
    }   
    public function getHp()
    {
        return $this->hp;
    }

    public function getAttackPokemon()
    {
        return $this->attackPokemon;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function setHp($hp)
    {
        $this->hp = $hp;
    }
    public function setAttackPokemon(AttackPokemon $attackPokemon)
    {
        $this->attackPokemon = $attackPokemon;
    }
    public function isDead() {
        return $this->hp <= 0;
    }
    public function attack(Pokemon $pokemon) {
        $damage = $this->attackPokemon->generateAttackPoints();
        $pokemon->setHp($pokemon->getHp() - $damage);
        
        return $damage;
    }
    public function whoAmI() {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 5px;'>";
        echo "<div class='name'><strong>{$this->nom}</strong></div>";
        echo "<img src='{$this->url}' width='100'><br>";
        echo "Points de vie : {$this->hp}<br>";
        echo "Min Attack Points : {$this->attackPokemon->getAttackMinimal()}<br>";
        echo "Max Attack Points : {$this->attackPokemon->getAttackMaximal()}<br>";
        echo "Special Attack : x{$this->attackPokemon->getSpecialAttack()}<br>";
        echo "Probability Special Attack : {$this->attackPokemon->getProbabilitySpecialAttack()}%<br>";
        echo "</div>";
    }
}
?>