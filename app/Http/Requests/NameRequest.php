<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class NameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255'
        ];
    }

    public function getEncryptedData()
    {
        return [
            'first_name' => Crypt::encryptString($this->validated()['first_name']),
            'last_name' => Crypt::encryptString($this->validated()['last_name'])
        ];
    }
}
