<?php
session_start();
require_once '../classes/User.php';
require_once '../classes/Database.php';
require_once '../classes/Students.php';
require_once '../classes/Section.php';

$user = new User();
if (!$user->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$pdo = Database::connect();
$sections = $pdo->query("SELECT * FROM sections")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    $imageUrl = $_POST['image']; 

    $stmt = $pdo->prepare("INSERT INTO students (name, birthday, section, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $birthday, $section, $imageUrl]);

    header("Location: student_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Ajouter un étudiant</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Date de naissance</label>
            <input type="date" name="birthday" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Section</label>
            <select name="section" class="form-control" required>
                <?php foreach ($sections as $s): ?>
                    <option value="<?= $s['designation'] ?>"><?= $s['designation'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>URL de l’image</label>
            <input type="url" name="image" class="form-control" placeholder="https://exemple.com/photo.jpg" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="student_list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
