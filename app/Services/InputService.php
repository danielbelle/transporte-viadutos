<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class InputService
{
    public function processInput(array $encryptedData)
    {
        try {
            $decryptedInput = Crypt::decryptString($encryptedData['input']);

            // Business logic goes here
            $fullInput = $this->formatFullInput($decryptedInput);

            return [
                'full_input' => $fullInput,
            ];
        } catch (DecryptException $e) {
            throw new \RuntimeException('Failed to decrypt input data');
        }
    }

    protected function formatFullInput(string $data)
    {
        return "{$data} ---1";
    }
}
