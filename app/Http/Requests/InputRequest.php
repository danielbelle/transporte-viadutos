<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class InputRequest extends FormRequest
{
    public function rules()
    {
        return [

            'name' => 'required|min:3',
            'email' => 'required|email',
            'docRG' => 'required|min:4',
            'docCPF' => 'required|cpf',
            'period' => 'required|min:1', // primeiro ao décimo
            'institution' => 'required|min:3',
            'course' => 'required|min:3',
            'month' => 'required|min:1',
            'timesInMonth' => 'required|integer',
            'city' => 'required|min:3',
            'phone' => 'required',
        ];
    }

    public function getEncryptedData()
    {

        // transformar return em um foreach

        return [

            'name' => $this->encryptAndValidate('name'),
            'email' => $this->encryptAndValidate('email'),
            'docRG' => $this->encryptAndValidate('docRG'),
            'docCPF' => $this->encryptAndValidate('docCPF'),
            'period' => $this->encryptAndValidate('period'),
            'institution' => $this->encryptAndValidate('institution'),
            'course' => $this->encryptAndValidate('course'),
            'month' => $this->encryptAndValidate('month'),
            'timesInMonth' => $this->encryptAndValidate('timesInMonth'),
            'city' => $this->encryptAndValidate('city'),
            'phone' => $this->encryptAndValidate('phone'),
        ];
    }
    private function encryptAndValidate(string $data): string
    {
        return Crypt::encryptString(
            $this->validated()[$data]
        );
    }
}
