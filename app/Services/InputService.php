<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
            $fullInput = $this->formatFullInput($decryptedInput);

            return [
                'full_input' => $fullInput,
            ];
        } catch (DecryptException $e) {
            throw new \RuntimeException('Failed to decrypt input data');
        }
    }

    protected function formatFullInput(array $data): string
    {
        return "{$data['name']} --- {$data['email']}";
    }
}
