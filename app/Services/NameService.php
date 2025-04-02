<?php
// app/Services/NameService.php
namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class NameService
{
    public function processNames(array $encryptedData)
    {
        try {
            $decryptedFirstName = Crypt::decryptString($encryptedData['first_name']);
            $decryptedLastName = Crypt::decryptString($encryptedData['last_name']);

            // Business logic goes here
            $fullName = $this->formatFullName($decryptedFirstName, $decryptedLastName);
            $initials = $this->getInitials($decryptedFirstName, $decryptedLastName);

            return [
                'full_name' => $fullName,
                'initials' => $initials,
                'name_length' => strlen($fullName)
            ];
        } catch (DecryptException $e) {
            throw new \RuntimeException('Failed to decrypt name data');
        }
    }

    protected function formatFullName(string $firstName, string $lastName): string
    {
        return "{$firstName} {$lastName}";
    }

    protected function getInitials(string $firstName, string $lastName): string
    {
        return strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
    }
}
