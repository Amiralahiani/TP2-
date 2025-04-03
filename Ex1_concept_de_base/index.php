<?php
require_once 'Etudiant.php';
$etudiants = [
    new Etudiant("Aymen",[11, 13, 18, 7, 10, 13, 2, 5, 1]),
    new Etudiant("Bob",[15, 9, 8, 16]),
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Résultats</title>
    <style>
        .etudiant {
            float: left;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            width: 200px;
        }
        .moyenne {
            background-color: #cce0ff;
            padding: 5px;
            margin-top: 10px;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        .nom {
            background-color:rgb(247, 251, 252);
            font-weight: bold;
            margin-left: 2px;
            padding: 5px;
        }
    </style>
</head>
<body>
<div class="clearfix">
<?php
foreach ($etudiants as $etudiant) {
    echo "<div class='etudiant'>";
    echo "<div class='nom'><strong>{$etudiant->nom}</strong></div>";
    $etudiant->afficheNotes();
    $moyenne = number_format($etudiant->calculerMoyenne(), 10);
    echo "<div class='moyenne'>Votre moyenne est $moyenne</div>";
    echo "<div class='moyenne'>Statut : <strong>{$etudiant->estAdmis()}</strong></div>";
    echo "</div>";
}
?>
</div>
</body>
</html>