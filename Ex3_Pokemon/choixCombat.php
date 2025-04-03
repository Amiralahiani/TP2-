<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du combat Pokémon</title>
</head>
<body>

<h2>Choisir un type de combat</h2>

<form method="post" action="lanceCombat.php">
    <label for="combat">Sélectionner un combat :</label>
    <select name="combat" id="combat">
        <option value="Feu_vs_Plante">🔥 Feu vs 🌱 Plante</option>
        <option value="Plante_vs_Eau">🌱 Plante vs 💧 Eau</option>
        <option value="Eau_vs_Feu">💧 Eau vs 🔥 Feu</option>
    </select>

    <br><br>
    <button type="submit">Lancer le combat</button>
</form>
</body>
</html>

