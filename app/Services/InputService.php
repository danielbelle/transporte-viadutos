<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use setasign\Fpdi\Fpdi;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;

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
        $outputPath = storage_path('app/private/attachments/transporte-carro-' . explode(' ', $formInput['name'])[0] . '.pdf');
        $pdf->Output($outputPath, 'F');

        response()->download($outputPath);

        Mail::to($formInput['email'])->send(new ContactUs($formInput, $outputPath));
        return redirect()->back()->with('success', 'Email enviado com sucesso!');
    }

    private function convertIso($string): string
    {
        return iconv(mb_detect_encoding($string, mb_detect_order(), true), "ISO-8859-1", $string);
    }

    private function setText($pdf, array $formInput)
    {
        foreach ($this->positions as $key => $position) {
            if ($key == 'signatureName' || $key == 'month') {
                $pdf->SetFont('Helvetica', '', 8);
                $key === 'signatureName' ? $formInput[$key] = $formInput['name'] : $formInput[$key] = $formInput[$key];
            } else {
                $pdf->SetFont('Helvetica', 'B', 12);
            }

            if ($key == 'sign') {
                $this->savePadSignature($formInput[$key]);
            }

            $pdf->SetXY($position[0], $position[1]); // Position (x,y in mm)
            $pdf->Write(0, $this->convertIso($formInput[$key]));
        }
    }

    private function savePadSignature($padSignature)
    {
        $folderPath = storage_path('app/private/attachments/');
        $image_parts = explode(";base64,", $padSignature, 1);

        $image_type_aux = explode("data:image/", $image_parts[0]);
        $image_type = $image_type_aux[0];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.' . $image_type;
        return $padSignature = file_put_contents($file, $image_base64);
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
        'sign' => [86, 160],
        'signatureName' => [91, 170],
    ];
}
