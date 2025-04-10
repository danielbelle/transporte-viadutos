<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use setasign\Fpdi\Fpdi;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


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

            $processResult = $this->formatPDF($decryptedInput);
        } catch (DecryptException $e) {
            throw new \RuntimeException('Failed to decrypt input data');
        }

        return $processResult;
    }

    protected function formatPDF($decryptedInput)
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
        //$pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetCreator('Daniel Henrique Belle', true);

        $decryptedInput['sign'] = $this->setText($pdf, $decryptedInput);

        // Output the modified PDF
        $outputPathAux = 'transporte-carro-' . explode(' ', $decryptedInput['name'])[0] . '.pdf';
        $outputPath = storage_path('app/private/attachments/' . $outputPathAux);
        $pdf->Output($outputPath, 'F');

        response()->download($outputPath);


        // get and save inputDocument
        if (isset($decryptedInput['inputDocument'])) {
            $inputDocument = $decryptedInput['inputDocument'];
            $inputDocumentAux = 'app/private/attachments/comprovante-presença-' . explode(' ', $decryptedInput['name'])[0] . '.pdf';
            $inputDocumentPath = storage_path($inputDocumentAux);
            $decryptedInput['inputDocument'] = $inputDocumentAux;
            file_put_contents($inputDocumentPath, base64_decode($inputDocument));
        }

        //Mail::to($decryptedInput['email'])->send(new ContactUs($decryptedInput, $outputPath, $inputDocumentPath));

        $decryptedInput['outputPath'] = $outputPathAux;
        $processResult =  $decryptedInput;
        return $processResult;
    }


    private function setText($pdf, array $decryptedInput)
    {
        foreach ($this->PDFpositions as $key => $position) {
            if ($key == 'signatureName' || $key == 'month') {
                $pdf->SetFont('Helvetica', '', 8);
                if ($key == 'signatureName') {
                    $decryptedInput[$key] = $decryptedInput['name'];
                }
            } else {
                $pdf->SetFont('Helvetica', 'B', 12);
            }


            if ($key == 'sign') {
                $imageLocation = $this->savePadSignature($decryptedInput[$key], $decryptedInput['name']);
                $decryptedInput[$key] = $imageLocation['filename'];
                $pdf->Image($imageLocation['full_path'], $position[0], $position[1], 44, 18);
            } else {
                $pdf->SetXY($position[0], $position[1]); // Position (x,y in mm)
                $pdf->Write(0, $this->convertIso($decryptedInput[$key]));
            }
        }
        return $decryptedInput['sign'];
    }

    private function savePadSignature($padSignature, $name)
    {
        try {
            // Define o caminho relativo (dentro do storage)
            $folderPath = 'attachments/';

            // Verifica e cria o diretório se não existir
            if (!Storage::disk('local')->exists($folderPath)) {
                Storage::disk('local')->makeDirectory($folderPath);
            }

            // Extrai o tipo da imagem
            $imageParts = explode(";base64,", $padSignature);
            $imageTypeAux = explode("data:image/", $imageParts[0]);
            $imageType = $imageTypeAux[1] ?? 'png'; // Default para PNG se não detectar

            // Decodifica a imagem
            $image_base64 = base64_decode($imageParts[1]);
            if ($image_base64 === false) {
                throw new \RuntimeException('Falha ao decodificar a imagem base64');
            }

            // Gera um nome de arquivo seguro
            $filename = Str::slug($name) . '-assinatura.' . $imageType;
            $relativePath = $folderPath . $filename;

            // Salva usando o Storage do Laravel
            Storage::disk('local')->put($relativePath, $image_base64);

            return [
                'full_path' => storage_path('app/private/' . $relativePath),
                'filename' => $filename,
                'relative_path' => $relativePath
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao salvar assinatura: ' . $e->getMessage());
            throw new \RuntimeException('Erro ao salvar a assinatura: ' . $e->getMessage());
        }
    }

    private function convertIso($string)
    {
        return iconv(mb_detect_encoding($string, mb_detect_order(), true), "ISO-8859-1", $string);
    }

    private array $PDFpositions = [
        'name' => [37, 46],
        'docRG' => [88, 56],
        'docCPF' => [35, 66],
        'course' => [30, 75],
        'period' => [77, 85],
        'institution' => [31, 95],
        'month' => [101, 124],
        'timesInMonth' => [170, 124],
        'city' => [125, 134],
        'sign' => [86, 150],
        'signatureName' => [91, 170],
    ];
}
