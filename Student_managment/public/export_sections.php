<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
require_once '../classes/Database.php';
require_once '../classes/Repository.php';
require_once '../classes/Section.php';

$section = new Section();
$sections = $section->findAll();

if (isset($_GET['type'])) {
    $type = $_GET['type'];

    // Export CSV
    if ($_GET['type'] == 'csv') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sections.txt"');
    
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Designation', 'Description']);
        foreach ($sections as $sec) {
            fputcsv($output, [$sec['id'], $sec['designation'], $sec['description']]);
        }
        fclose($output);
        exit();
    }
    

    // Export Excel
    if ($_GET['type'] == 'excel') {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sections.xlsx"');
    
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Designation', 'Description']);
        foreach ($sections as $sec) {
            fputcsv($output, [$sec['id'], $sec['designation'], $sec['description']]);
        }
        fclose($output);
        exit();
    }
    
    // Export PDF
    if ($type == 'pdf') {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="sections.pdf"');

        require_once 'path/to/tcpdf/tcpdf.php';

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', '', 12);

        $pdf->Cell(0, 10, 'Liste des Sections', 0, 1, 'C');

        $pdf->Cell(30, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Designation', 1);
        $pdf->Cell(60, 10, 'Description', 1);
        $pdf->Ln();

        foreach ($sections as $sec) {
            $pdf->Cell(30, 10, $sec['id'], 1);
            $pdf->Cell(50, 10, $sec['designation'], 1);
            $pdf->Cell(60, 10, $sec['description'], 1);
            $pdf->Ln();
        }

        $pdf->Output('sections.pdf', 'D');
        exit();
    }
}

echo 'Type d\'export invalide.';
exit();
