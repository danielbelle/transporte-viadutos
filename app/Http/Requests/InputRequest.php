<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class InputRequest extends FormRequest
{
    public function rules()
    {
        return [

            'name' => '',
            'email' => '',
            'docRG' => '',
            'docCPF' => '',
            'period' => '', // matutino, vespertino, noturno, integral
            'institution' => '', // verificar se algum valor n entra nulo, se n quebra programa
            'course' => '',
            'month' => '',
            'timesInMonth' => '',
            'city' => '',
            'phone' => '',
            'sign' => '',
            'signatureName' => '',
            'inputDocument' => '', // 10MB

        ];
        /*
        return [

            'name' => 'required|min:3',
            'email' => 'required|email',
            'docRG' => 'required|min:4',
            'docCPF' => 'required|cpf',
            'period' => 'required|min:1', // matutino, vespertino, noturno, integral
            'institution' => 'required|min:3', // verificar se algum valor n entra nulo, se n quebra programa
            'course' => 'required|min:3',
            'month' => 'required|min:1',
            'timesInMonth' => 'required|integer',
            'city' => 'required|min:3',
            'phone' => 'required',
            'sign' => '',
            'signatureName' => '',
            'inputDocument' => 'required|mimes:pdf|max:10240', // 10MB
        ]; */
    }

    public function getInputAndEncryptData()
    {

        $arrayEncrypted = [];

        foreach ($this->rules() as $key => $value) {
            $arrayEncrypted[$key] = $this->encryptAndValidate($key) ?? '';
        }

        return $arrayEncrypted;
    }

    private function encryptAndValidate(string $data): string
    {

        return Crypt::encryptString($this->validated()[$data]) ?? '';
    }
}
