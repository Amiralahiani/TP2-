<?php

$host = 'localhost';
$dbname = 'student';
$username = 'root';
$password = 'Ronaldo2023';

try {
   
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if (!isset($_GET['id'])) {
        header("Location: liste_etudiants.php?error=id_missing");
        exit();
    }

    $studentId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$studentId) {
        header("Location: liste_etudiants.php?error=invalid_id");
        exit();
    }

    
    $sql = "SELECT id, name, birth_date FROM student WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
    $stmt->execute();
    
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        header("Location: liste_etudiants.php?error=student_not_found");
        exit();
    }

   
    $birthDate = new DateTime($student['birth_date']);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

} catch(PDOException $e) {
    
    error_log("Database error: " . $e->getMessage());
    
    
    header("Location: error.php?code=db_error");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Étudiant #<?= htmlspecialchars($student['id']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card student-card">
            <div class="card-header text-white student-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0">Détails de l'Étudiant</h1>
                    <span class="badge bg-light text-primary">ID #<?= htmlspecialchars($student['id']) ?></span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="detail-item">
                    <div class="row">
                        <div class="col-md-4 fw-bold">Nom complet:</div>
                        <div class="col-md-8"><?= htmlspecialchars($student['name']) ?></div>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="row">
                        <div class="col-md-4 fw-bold">Date de naissance:</div>
                        <div class="col-md-8"><?= $birthDate->format('d/m/Y') ?></div>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="row">
                        <div class="col-md-4 fw-bold">Âge:</div>
                        <div class="col-md-8"><?= $age ?> ans</div>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="javascript:history.back()" class="btn btn-outline-primary me-2">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <a href="index.php" class="btn btn-primary">
                        <i class="bi bi-list-ul"></i> Liste complète
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>