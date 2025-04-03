<?php
require_once "Pokemon.php";

$p1 = new Pokemon("Dracaufeu", "Dracaufeu_Gigamax.png", 200, new AttackPokemon(10, 50, 2, 30));
$p2 = new Pokemon("Gigamax Pikachu", "Gigamax_Pikachu.png", 200, new AttackPokemon(20, 40, 3, 20));

$round = 1;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat Pokémon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2 class="result">Les combattants</h2>
<div class="row">
    <div class="pokemon"><?php $p1->whoAmI(); ?></div>
    <div class="pokemon"><?php $p2->whoAmI(); ?></div>
</div>

<?php
while (!$p1->isDead() && !$p2->isDead()) {
    echo "<div class='round'>Round $round</div>";

    $damage1 = $p1->attack($p2);
    $damage2 = $p2->attack($p1);

    echo "<div class='result'>{$p1->getNom()} inflige $damage1 à {$p2->getNom()}</div>";
    echo "<div class='result'>{$p2->getNom()} inflige $damage2 à {$p1->getNom()}</div>";
    

    
    echo "<div class='row'>";
    echo "<div class='pokemon'>";
    $p1->whoAmI();
    echo "</div>";
    echo "<div class='pokemon'>";
    $p2->whoAmI();
    echo "</div>";
    echo "</div>";

    if ($p1->isDead() || $p2->isDead()) {
        break;
    }
    $round++;
}

if ($p1->isDead()) {
    $vainqueur = $p2;
} else {
    $vainqueur = $p1;
}
$name = $vainqueur->getNom();
echo "<div class='winner'>Le vainqueur est : $name 🏆" ;
echo "<img src='{$vainqueur->getUrl()} ' width='100'>";
echo "</div>";
?>

</body>
</html>
