<?php
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/Students.php';
require_once '../classes/Section.php';

// Vérification du paramètre type
if (!isset($_GET['type'])) {
    http_response_code(400);
    echo 'Paramètre "type" manquant dans l\'URL';
    exit();
}

$validTypes = ['csv', 'excel', 'pdf'];
$type = $_GET['type'];

if (!in_array($type, $validTypes)) {
    http_response_code(400);
    echo 'Type d\'export non supporté. Options disponibles: csv, excel, pdf';
    exit();
}

// Récupération des données étudiants
$student = new Student();
$students = $student->findAll();

if (empty($students)) {
    http_response_code(404);
    echo 'Aucune donnée étudiante à exporter';
    exit();
}

// Gestion des exports
$filename = 'students_' . date('Y-m-d');

switch ($type) {
    case 'csv':
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

        $output = fopen('php://output', 'w');
        // Ajout du BOM UTF-8 pour Excel
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, ['ID', 'Nom', 'Date de naissance', 'Section'], ';');
        
        foreach ($students as $stu) {
            fputcsv($output, [
                $stu['id'],
                $stu['name'],
                date('d/m/Y', strtotime($stu['birthday'])),
                $stu['section']
            ], ';');
        }
        fclose($output);
        exit();

    case 'excel':
        // Solution Excel sans PhpSpreadsheet
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        
        $html = '<html>';
        $html .= '<head><meta charset="UTF-8"></head>';
        $html .= '<body>';
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Nom</th>';
        $html .= '<th>Date de naissance</th>';
        $html .= '<th>Section</th>';
        $html .= '</tr>';
        
        foreach ($students as $stu) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($stu['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($stu['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars(date('d/m/Y', strtotime($stu['birthday']))) . '</td>';
            $html .= '<td>' . htmlspecialchars($stu['section']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '</body></html>';
        
        echo $html;
        exit();

    case 'pdf':
        // Solution PDF sans TCPDF
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Liste des Étudiants</title>
            <style>
                body { font-family: Arial; margin: 20px; }
                h1 { text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .footer { text-align: right; margin-top: 30px; font-size: 0.8em; }
            </style>
        </head>
        <body>
            <h1>Liste des Étudiants</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Section</th>
                </tr>';

        foreach ($students as $stu) {
            $html .= '<tr>
                <td>' . htmlspecialchars($stu['id']) . '</td>
                <td>' . htmlspecialchars($stu['name']) . '</td>
                <td>' . htmlspecialchars(date('d/m/Y', strtotime($stu['birthday']))) . '</td>
                <td>' . htmlspecialchars($stu['section']) . '</td>
            </tr>';
        }

        $html .= '</table>
            <div class="footer">Généré le ' . date('d/m/Y à H:i') . '</div>
        </body>
        </html>';

        // Envoi au navigateur avec option d'impression
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename="' . $filename . '.html"');
        echo '<script>
            window.onload = function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 1000);
            }
        </script>';
        echo $html;
        exit();
}