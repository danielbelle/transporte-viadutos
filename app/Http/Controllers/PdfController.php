<?php

namespace App\Http\Controllers;

use setasign\Fpdi\Fpdi;


class PdfController extends Controller
{

    public function show()
    {
        $this->editPdf();
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
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetCreator('Daniel Henrique Belle', true);

        $this->setText($pdf);
        // Output the modified PDF
        $outputPath = storage_path('app/public/attachments/modified.pdf');
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath);
    }

    private function convertIso($string): string
    {
        return iconv(mb_detect_encoding($string, mb_detect_order(), true), "ISO-8859-1", $string);
    }

    private function setText($pdf)
    {
        foreach ($this->positions as $key => $position) {
            $pdf->SetXY($position[0], $position[1]); // Position (x,y in mm)
            $pdf->Write(0, $this->convertIso($this->formInput[$key]));
        }
    }

    private array $positions = [
        'nameFull' => [37, 46],
        'docRG' => [88, 56],
        'docCPF' => [35, 66],
        'course' => [30, 75],
        'period' => [77, 85],
        'institution' => [31, 95],
        'month' => [101, 124],
        'timesInMonth' => [170, 124],
        'city' => [125, 134],
        'signature' => [86, 160],
        'signatureName' => [91, 170],
    ];

    private array $formInput = [
        'nameFull' => 'Daniel Henrique Bellé',
        'docRG' => '8097098522',
        'docCPF' => '024.449.020-17',
        'period' => '1°',
        'institution' => 'IFRS',
        'course' => 'Análise e Desenvolvimento de Sistemas',
        'month' => 'abril',
        'timesInMonth' => 20,
        'city' => 'Erechim',
        'signature' => 'ASSINATURA',
        'signatureName' => 'Daniel Henrique Bellé',

    ];
}

/*
    private function formInputData($mapDataObject): object
    {
        return (object) [
            'nameFull' => $mapDataObject->nameFull,
            'docRG' => $mapDataObject->docRG,
            'docCPF' => $mapDataObject->docCPF,
            'period' => $mapDataObject->period,
            'course' => $mapDataObject->course,
            'month' => $mapDataObject->month,
            'timesInMonth' => $mapDataObject->timesInMonth,
            'city' => $mapDataObject->city,
            'signature' => $mapDataObject->signature,
        ];
    }

*/
