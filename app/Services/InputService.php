<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use setasign\Fpdi\Fpdi;


class InputService
{
    public function processInput(array $encryptedData)
    {
        try {
            $decryptedInput = [];

            foreach ($encryptedData as $key => $value) {
                $decryptedInput[$key] = Crypt::decryptString($value);
            }

            // Business logic goes here

            $this->formatPDF($decryptedInput);
        } catch (DecryptException $e) {
            throw new \RuntimeException('Failed to decrypt input data');
        }
    }

    protected function formatPDF($formInput)
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

        $this->setText($pdf, $formInput);

        // Output the modified PDF
        $outputPath = storage_path('app/public/attachments/declaração -' . explode(' ', $formInput['name'])[0] . '.pdf');
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath);
    }

    private function convertIso($string): string
    {
        return iconv(mb_detect_encoding($string, mb_detect_order(), true), "ISO-8859-1", $string);
    }

    private function setText($pdf, array $formInput)
    {
        foreach ($this->positions as $key => $position) {
            if ($key == 'signature' || $key == 'signatureName') {
                $pdf->SetFont('Helvetica', 'I', 8);
                $formInput[$key] = $formInput['name'];
            } elseif ($key == 'month') {
                $pdf->SetFont('Helvetica', '', 8);
            } else {
                $pdf->SetFont('Helvetica', 'B', 12);
            }
            $pdf->SetXY($position[0], $position[1]); // Position (x,y in mm)
            $pdf->Write(0, $this->convertIso($formInput[$key]));
        }
    }

    private array $positions = [
        'name' => [37, 46],
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
}
