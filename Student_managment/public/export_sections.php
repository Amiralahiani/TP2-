<?php
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/Section.php';

$section = new Section();
$sections = $section->findAll();

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $filename = 'sections_' . date('Y-m-d');

    // Export CSV
    if ($type == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
    
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Designation', 'Description']);
        foreach ($sections as $sec) {
            fputcsv($output, [$sec['id'], $sec['designation'], $sec['description']]);
        }
        fclose($output);
        exit();
    }
    
    // Export Excel (faux Excel en HTML)
    if ($type == 'excel') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        
        $html = '<html>';
        $html .= '<head><meta charset="UTF-8"></head>';
        $html .= '<body>';
        $html .= '<table border="1">';
        $html .= '<tr><th>ID</th><th>Designation</th><th>Description</th></tr>';
        
        foreach ($sections as $sec) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($sec['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($sec['designation']) . '</td>';
            $html .= '<td>' . htmlspecialchars($sec['description']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '</body></html>';
        
        echo $html;
        exit();
    }
    
    // Export PDF (solution simple sans TCPDF)
    // Export PDF basique (nécessite un navigateur moderne)
if ($type == 'pdf') {
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des Sections</title>
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
        <h1>Liste des Sections</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Designation</th>
                <th>Description</th>
            </tr>';

    foreach ($sections as $sec) {
        $html .= '<tr>
            <td>' . htmlspecialchars($sec['id']) . '</td>
            <td>' . htmlspecialchars($sec['designation']) . '</td>
            <td>' . htmlspecialchars($sec['description']) . '</td>
        </tr>';
    }

    $html .= '</table>
        <div class="footer">Généré le ' . date('d/m/Y à H:i') . '</div>
    </body>
    </html>';

    // Enregistrement temporaire
    $tempFile = tempnam(sys_get_temp_dir(), 'pdf');
    file_put_contents($tempFile . '.html', $html);

    // Téléchargement
    header('Content-Type: text/html');
    header('Content-Disposition: attachment; filename="sections_' . date('Y-m-d') . '.html"');
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
}

echo 'Type d\'export invalide. Les formats disponibles sont : csv, excel, pdf';
exit();