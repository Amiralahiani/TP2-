<?php
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/Students.php';

if (!isset($_GET['id'])) {
    die('Student ID not provided.');
}

$studentId = $_GET['id'];

$student = new Student();
$studentDetails = $student->find($studentId);

if (!$studentDetails) {
    die('Student not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Getting the updated data from the form
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];

    // Updating the student in the database
    $student->update($studentId, $name, $birthday, $section);
    header('Location: student_list.php'); // Redirect to the student list after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Student</h2>

        <form action="edit_student.php?id=<?= $studentId ?>" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $studentDetails['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $studentDetails['birthday'] ?>" required>
            </div>
            <div class="form-group">
                <label for="section">Section</label>
                <input type="text" class="form-control" id="section" name="section" value="<?= $studentDetails['section'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
