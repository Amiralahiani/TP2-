<?php
require_once "PokemonFeu.php";
require_once "PokemonEau.php";
require_once "PokemonPlante.php";
require_once "AttackPokemon.php";

function lancerCombat($p1, $p2, $titreCombat) {
    $round = 1;

    echo "<h2 class='result'>$titreCombat</h2>";

    echo "<div class='row'>";
    echo "<div class='pokemon'>";
    $p1->whoAmI();
    echo "</div><div class='pokemon'>";
    $p2->whoAmI();
    echo "</div></div>";

    while (!$p1->isDead() && !$p2->isDead()) {
        echo "<div class='round'>Round $round</div>";

        $d1 = $p1->attack($p2);
        $d2 = $p2->attack($p1);

        echo "<div class='result'>{$p1->getNom()} inflige $d1 à {$p2->getNom()}</div>";
        echo "<div class='result'>{$p2->getNom()} inflige $d2 à {$p1->getNom()}</div>";

        echo "<div class='row'>";
        echo "<div class='pokemon'>";
        $p1->whoAmI();
        echo "</div><div class='pokemon'>";
        $p2->whoAmI();
        echo "</div></div>";

        if ($p1->isDead() || $p2->isDead()) break;
        $round++;
    }

    $vainqueur = $p1->isDead() ? $p2 : $p1;
    $name = $vainqueur->getNom();
    echo "<div class='winner'>Le vainqueur est : $name 🏆<br>";
    echo "<img src='{$vainqueur->getUrl()}' width='100'>";
    echo "</div>";

    echo "<div style='text-align:center; margin-top:20px;'>
            <a href='choixCombat.php'>⬅️ Rejouer un combat</a>
          </div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat Pokémon Typé</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["combat"])) {
    $combat = $_POST["combat"];

    if ($combat === "Feu_vs_Plante") {
        $p1 = new PokemonFeu("Dracaufeu", "Dracaufeu_Gigamax.png", 200, new AttackPokemon(15, 45, 2, 30));
        $p2 = new PokemonPlante("Bulbizarre", "bulbizarre.png", 200, new AttackPokemon(10, 35, 2, 25));
        lancerCombat($p1, $p2, "🔥 Dracaufeu vs 🌱 Bulbizarre");

    } elseif ($combat === "Plante_vs_Eau") {
        $p1 = new PokemonPlante("Bulbizarre", "bulbizarre.png", 200, new AttackPokemon(10, 35, 2, 25));
        $p2 = new PokemonEau("Tortank", "Tortank.jpg", 200, new AttackPokemon(15, 45, 2, 25));
        lancerCombat($p1, $p2, "🌱 Bulbizarre vs 💧 Tortank");

    } elseif ($combat === "Eau_vs_Feu") {
        $p1 =new PokemonEau("Tortank", "Tortank.jpg", 200, new AttackPokemon(15, 45, 2, 25));
        $p2 = new PokemonFeu("Dracaufeu", "Dracaufeu_Gigamax.png", 200, new AttackPokemon(15, 45, 2, 30));
        lancerCombat($p1, $p2, "💧 Tortank vs 🔥 Dracaufeu");

    } else {
        echo "<p>Type de combat non reconnu.</p>";
    }
} else {
    echo "<p>Veuillez passer par le formulaire de <a href='choixCombat.php'>choix</a>.</p>";
}
?>