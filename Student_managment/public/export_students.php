<?php
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/Students.php';
require_once '../classes/Section.php';

$student = new Student();
$students = $student->findAll();

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    // Export CSV
    if ($type == 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="students.txt"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Name', 'Birthday', 'Section']);
        foreach ($students as $stu) {
            fputcsv($output, [$stu['id'], $stu['name'], $stu['birthday'], $stu['section']]);
        }
        fclose($output);
        exit();
    }

    // Export Excel
    if ($type == 'excel') {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="students.xlsx"');

        // Utilisation de la bibliothèque PHPExcel ou PhpSpreadsheet
        require_once 'path/to/PhpSpreadsheet/vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Ajouter des données à l'Excel
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Birthday');
        $sheet->setCellValue('D1', 'Section');

        $row = 2;
        foreach ($students as $stu) {
            $sheet->setCellValue('A' . $row, $stu['id']);
            $sheet->setCellValue('B' . $row, $stu['name']);
            $sheet->setCellValue('C' . $row, $stu['birthday']);
            $sheet->setCellValue('D' . $row, $stu['section']);
            $row++;
        }

        // Écrire le fichier Excel dans le flux
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Export PDF
    if ($type == 'pdf') {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="students.pdf"');

        // Utilisation de la bibliothèque TCPDF ou FPDF pour générer un PDF
        require_once 'path/to/tcpdf/tcpdf.php';

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', '', 12);

        // Titre du document
        $pdf->Cell(0, 10, 'Liste des Étudiants', 0, 1, 'C');

        // Entêtes du tableau
        $pdf->Cell(30, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Name', 1);
        $pdf->Cell(30, 10, 'Birthday', 1);
        $pdf->Cell(40, 10, 'Section', 1);
        $pdf->Ln();

        // Ajouter les données des étudiants au PDF
        foreach ($students as $stu) {
            $pdf->Cell(30, 10, $stu['id'], 1);
            $pdf->Cell(50, 10, $stu['name'], 1);
            $pdf->Cell(30, 10, $stu['birthday'], 1);
            $pdf->Cell(40, 10, $stu['section'], 1);
            $pdf->Ln();
        }

        // Générer et envoyer le PDF
        $pdf->Output('students.pdf', 'D');
        exit();
    }
}

echo 'Type d\'export invalide.';
exit();
