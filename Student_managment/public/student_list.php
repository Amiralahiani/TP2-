<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/User.php';
require_once '../classes/Students.php';

$user = new User();

// Vérification si l'utilisateur est authentifié
if (!$user->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$isAdmin = $user->isAdmin();
$student = new Student();

// Vérifier si un terme de recherche a été soumis
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer la liste des étudiants en filtrant par nom si nécessaire
$students = $student->findAll($search);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Students Management</a>
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
        <h2 class="mb-4">Liste des étudiants</h2>

    
    <form method="GET" action="student_list.php" class="form-inline mb-3">
        <input type="text" name="search" placeholder="Rechercher par nom"
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
            class="form-control mr-2" style="width: 250px;">

        <button type="submit" class="btn btn-primary mr-2">Filtrer</button>

            <a href="add_student.php" class="btn btn-success" title="Ajouter un étudiant">
            <i class="bi bi-person-add"></i>
            </a>

    </form>



        <!-- Boutons d'exportation -->
        <div class="mb-3">
            <a href="export_students.php?type=csv" class="btn btn-secondary">Exporter en CSV</a>
            <a href="export_students.php?type=excel" class="btn btn-success">Exporter en Excel</a>
            <a href="export_students.php?type=pdf" class="btn btn-danger">Exporter en PDF</a>

        </div>

        <!-- Tableau des étudiants -->
        <table id="studentsTable" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Section</th>
                    <?php if ($isAdmin): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $stu): ?>
                    <tr>
                        <td><?= $stu['id'] ?></td>
                        <td><img src="<?= $stu['image'] ?>" alt="Image" width="50"></td>
                        <td><?= $stu['name'] ?></td>
                        <td><?= $stu['birthday'] ?></td>
                        <td><?= $stu['section'] ?></td>
                        <?php if ($isAdmin): ?>
                            <td>
                                <a href="edit_student.php?id=<?= $stu['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="delete_student.php?id=<?= $stu['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#studentsTable').DataTable();
        });
    </script>
</body>
</html>
