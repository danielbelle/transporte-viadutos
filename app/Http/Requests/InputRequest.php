<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class InputRequest extends FormRequest
{
    public function rules()
    {
        return [

            'name' => 'required',
            'email' => 'required',
            'docRG' => 'required',
            'docCPF' => 'required',
            'period' => 'required', // primeiro ao décimo
            'institution' => 'required', // verificar se algum valor n entra nulo, se n quebra programa
            'course' => 'required',
            'month' => 'required',
            'timesInMonth' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'sign' => '',
            'signatureName' => '',

        ];
        /*
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
            'sign' => '',
            'signatureName' => '',
        ]; */
    }

    public function getEncryptedData()
    {

        $arrayEncrypted = [];

        foreach ($this->rules() as $key => $value) {
            $arrayEncrypted[$key] = $this->encryptAndValidate($key);
        }

        return $arrayEncrypted;
    }

    private function encryptAndValidate(string $data): string
    {

        return Crypt::encryptString($this->validated()[$data]);
    }
}
