<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/User.php';
require_once '../classes/Section.php';

$user = new User();

// Vérification si l'utilisateur est authentifié
if (!$user->isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$isAdmin = $user->isAdmin();
$section = new Section();

// Vérifier si un terme de recherche a été soumis
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer la liste des sections en filtrant si nécessaire
$sections = $section->findAll($search);  // Fonction findAll avec recherche par designation ou description
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des sections</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .container {
            padding-top: 20px;
        }
        .btn-export {
            margin-right: 10px;
        }
    </style>
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

    <div class="container">
        <h2 class="mb-4">Liste des sections</h2>


        <!-- Boutons d'exportation -->
        <div class="mb-3">
            <a href="export_sections.php?type=csv" class="btn btn-secondary btn-export">Exporter en CSV</a>
            <a href="export_sections.php?type=excel" class="btn btn-success btn-export">Exporter en Excel</a>
            <a href="export_sections.php?type=pdf" class="btn btn-danger btn-export">Exporter en PDF</a>
        </div>

        <!-- Tableau des sections -->
        <table class="table table-bordered table-striped" id="sectionsTable">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Designation</th>
                    <th>Description</th>
                    <?php if ($isAdmin): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sections as $sec): ?>
                    <tr>
                        <td><?= $sec['id'] ?></td>
                        <td><?= $sec['designation'] ?></td>
                        <td><?= $sec['description'] ?></td>
                        <?php if ($isAdmin): ?>
                            <td>
                            <form method="POST" action="section_list.php" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $sec['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette section ?');">Supprimer</button>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
        $deleteId = $_POST['delete_id'];
        if ($section->delete($deleteId)) {
            echo "<script>alert('Section supprimée avec succès'); window.location.href='section_list.php';</script>";
        } else {
            echo "<script>alert('Erreur lors de la suppression');</script>";
        }
    }
    ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sectionsTable').DataTable();
        });
    </script>
</body>
</html>
