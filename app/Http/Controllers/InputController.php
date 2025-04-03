<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputRequest;
use App\Services\InputService;
use Illuminate\Http\RedirectResponse;

class InputController extends Controller
{
    public function __construct(
        protected InputService $inputService
    ) {}

    public function showFormInput()
    {
        return view('home');
    }

    public function processInput(InputRequest $request): RedirectResponse
    {
        $encryptedData = $request->getEncryptedData();

        try {
            $result = $this->inputService->processInput($encryptedData);
            return redirect()->back();
            /*->with('result', "Full Input: {$result['full_input']}")*/
        } catch (\RuntimeException $e) {
            return redirect()->back()->withErrors([
                'error' => 'Failed to process input data: ' . $e->getMessage(),
            ]);
        }
    }
}
