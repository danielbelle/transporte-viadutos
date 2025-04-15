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
use Illuminate\Contracts\Filesystem\Filesystem;


class InputService
{
    // separar em variaveis cada STORAGE public e private

    private string $attachDir = '/attachments/';
    private Filesystem $publicPath;
    private Filesystem $internalPath;


    public function __construct()
    {
        $this->publicPath = Storage::disk('public');
        $this->internalPath = Storage::disk('local');
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

    public function processInput(array $encryptedData)
    {
        try {
            $decryptedInput = array_map(function ($value) {
                return Crypt::decryptString($value);
            }, $encryptedData);

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
        $templatePath = $this->publicPath->path($this->attachDir . $_ENV['PDF_AUXILIO_TEMPLATE']);

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
        $firstName = explode(' ', $decryptedInput['name'])[0];
        $outputPathAux = 'transporte-carro-' . $firstName . '.pdf';
        $outputPath = $this->internalPath->path($this->attachDir . $outputPathAux);
        $pdf->Output($outputPath, 'F');

        response()->download($outputPath);

        // get and save inputDocument
        if (isset($decryptedInput['inputDocument']) && !empty($decryptedInput['inputDocument'])) {
            $inputDocumentPath = $this->internalPath->path($this->attachDir . $_ENV['PDF_OPTIONAL_ATTACH'] . $firstName . '.pdf');
            file_put_contents($inputDocumentPath, base64_decode($decryptedInput['inputDocument']));
            $decryptedInput['inputDocument'] = $inputDocumentPath;
        }


        Mail::to($decryptedInput['email'])->send(new ContactUs($decryptedInput, $outputPath, $inputDocumentPath));

        $decryptedInput['outputPath'] = $outputPathAux;
        return $decryptedInput;
    }


    private function setText($pdf, array $decryptedInput)
    {
        foreach ($this->PDFpositions as $key => $position) {
            $fontStyle = ($key == 'signatureName' || $key == 'month') ? ['', 8] : ['B', 12];
            $pdf->SetFont('Helvetica', $fontStyle[0], $fontStyle[1]);

            if ($key == 'signatureName') {
                $decryptedInput[$key] = $decryptedInput['name'];
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
            // Verifica e cria o diretório se não existir
            if (!$this->internalPath->exists($this->attachDir)) {
                $this->internalPath->makeDirectory($this->attachDir);
            }

            // Extrai o tipo da imagem
            $imageParts = explode(";base64,", $padSignature);
            $imageType = explode("data:image/", $imageParts[0])[1] ?? 'png';
            $imageData = base64_decode($imageParts[1]);

            // Decodifica a imagem
            if ($imageData === false) {
                throw new \RuntimeException('Failed to decode base64 image');
            }

            // Gera um nome de arquivo seguro
            $filename = Str::slug($name) . '-assinatura.' . $imageType;
            $relativePath = $this->attachDir . $filename;

            // Salva usando o Storage do Laravel
            $this->internalPath->put($relativePath, $imageData);

            return [
                'full_path' => $this->internalPath->path($relativePath),
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
}
