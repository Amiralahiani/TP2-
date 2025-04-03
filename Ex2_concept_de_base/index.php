<?php
require_once "SessionManager.php";

$session = new SessionManager();
if (isset($_POST['reset'])) {
    $session->reinitialiser();
}
$session->incrementerVisite();
$nb = $session->getNombreVisites();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Session Visit Counter</title>
</head>
<body>
    <h1>Gestion de session</h1>

    <p>
        <?php
        if ($session->estPremiereVisite()) {
            echo "Bienvenue à notre plateforme !";
        } else {
            echo "Merci pour votre fidélité, c'est votre $nb " . "visite.";
        }
        ?>
    </p>

    <form method="post">
        <button type="submit" name="reset" value="1">Réinitialiser la session</button>
    </form>
</body>
</html>
