<?php

$host = 'localhost';
$dbname = 'student';
$username = 'root';
$password = 'Ronaldo2023';

try {
    
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS student (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                birth_date DATE NOT NULL
              )");
    
    $count = $pdo->query("SELECT COUNT(*) FROM student")->fetchColumn();
    
    
    if ($count == 0) {
        $students = [
            ['Mohamed Abdelwahed', '2004-09-06'],
        ['Amira Lahiani', '2004-07-19'],
        ['Youssef Turki', '2003-11-03'],
        ['Melek Mseddi', '2004-11-02'],
        ['Melek Kammoun', '2001-04-14']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO student (name, birth_date) VALUES (?, ?)");
        foreach ($students as $student) {
            $stmt->execute([$student[0], $student[1]]);
        }
    }
    

    $stmt = $pdo->query("SELECT * FROM student ORDER BY name");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Erreur de base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-box {
            border-left: 5px solid #0d6efd;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0">Liste des Étudiants</h1>
            </div>
            
            <div class="card-body">
                <!-- Info Box -->
                <div class="alert alert-info info-box mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Base de données :</strong> <?= $dbname ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Table :</strong> student
                        </div>
                        <div class="col-md-4">
                            <strong>Nombre d'étudiants :</strong> <?= count($students) ?>
                        </div>
                    </div>
                </div>
                
                
                <?php if (!empty($students)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Date de naissance</th>
                                    <th class="text-center">Âge</th>
                                    <th>Details</th>
                                    <th></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): 
                                    $birthDate = new DateTime($student['birth_date']);
                                    $today = new DateTime();
                                    $age = $today->diff($birthDate)->y;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['id']) ?></td>
                                        <td><?= htmlspecialchars($student['name']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($student['birth_date'])) ?></td>
                                        <td class="text-center"><?= $age ?> ans</td>
                                        <td>
                                        <a href="detailEtudiant.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-info">
                                        Détails
                                        </a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        Aucun étudiant trouvé dans la base de données.
                    </div>
                <?php endif; ?>
                
                
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>