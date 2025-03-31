<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;


class PdfController extends Controller
{
    public $pdfEditor;
    public function __construct()
    {
        $this->pdfEditor = $this->editPdf();
    }

    public function show()
    {
        return view('pdfs/pdf');
    }

    private function editPdf()
    {
        // Initialize FPDI
        $pdf = new Fpdi();

        // Path to existing PDF
        $templatePath = storage_path('app\public\attachments\auxilio-transporte.pdf');

        // Get page count and import first page
        $pageCount = $pdf->setSourceFile($templatePath);
        $templateId = $pdf->importPage(1);

        // Add a page and use the imported template
        $pdf->AddPage();
        $pdf->useTemplate($templateId);

        // Set font and add new text
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize('11');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(36, 47); // Position (x,y in mm)
        $pdf->Write(0, 'Daniel Henrique Belle');

        $pdf->SetXY(88, 57); // Position (x,y in mm)
        $pdf->Write(0, '024.449.020-17');


        // Output the modified PDF
        $outputPath = storage_path('app/public/attachments/modified.pdf');
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath);
    }
}
