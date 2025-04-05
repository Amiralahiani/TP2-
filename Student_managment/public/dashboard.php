<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/User.php';
require_once '../classes/Section.php';
require_once '../classes/Students.php';

$user = new User();

// Vérification si l'utilisateur est authentifié
if (!$user->isAuthenticated()) {
    header('Location: login.php');  
    exit;
}

// Vérification du rôle de l'utilisateur (admin ou user)
$isAdmin = $user->isAdmin();
$isUser = $user->isUser();

$student = new Student();
$section = new Section();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Students Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="student_list.php">Liste des étudiants</a></li>
                <li class="nav-item"><a class="nav-link" href="section_list.php">Liste des sections</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Bienvenue sur le tableau de bord, <?php echo $_SESSION['user']['username']; ?>!</h1>
            <p class="lead">Vous pouvez gérer les étudiants et les sections à partir de cette page.</p>
        </div>

        <div class="row">
            <!-- Students Section -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Gestion des étudiants</h4>
                    </div>
                    <div class="card-body">
                        <p>Gérer les étudiants de l'école.</p>
                        
                            <a href="student_list.php" class="btn btn-primary btn-block">Voir la liste des étudiants</a>
                        
                    </div>
                </div>
            </div>

            <!-- Sections Section -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Gestion des sections</h4>
                    </div>
                    <div class="card-body">
                        <p>Gérer les différentes sections de l'école.</p>
                        
                            <a href="section_list.php" class="btn btn-primary btn-block">Voir la liste des sections</a>
            
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
